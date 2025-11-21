<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;            // <-- added
use Carbon\Carbon;                            // <-- optional, for timestamps

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::with(['product.mainImage'])
            ->where('user_id', $userId)
            ->get();

        $items = $cartItems->map(function ($cart) {
            $p = $cart->product;
            if (!$p) return null;

            // price: prefer discount_price if present
            $price = $p->discount_price ?? $p->price;

            $image = $p->mainImage
                ? asset('public/storage/' . $p->mainImage->image_path)   // <- changed to storage path
                : asset('assets/images/placeholder.png');

            return [
                'product_id' => $p->id,
                'name' => $p->name,
                'image' => $image,
                'price' => $price,
                'quantity' => $cart->quantity,
                'subtotal' => $price * $cart->quantity,
            ];
        })->filter()->values();

        $subtotal = $items->sum('subtotal');

        return view('checkout', [
            'cartItems' => $items,
            'subtotal'  => $subtotal,
        ]);
    }

    /**
     * Payment order and initiate payment
     */
    public function payment(Request $request)
    {
        Log::info('CheckoutController@payment hit', ['request' => $request->except(['_token'])]);

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'area' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:COD,sslcommerz',
        ]);

        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // calculate subtotal (use discount if exists)
        $subtotal = $cartItems->sum(fn($item) => ($item->product->discount_price ?? $item->product->price) * $item->quantity);
        $deliveryCharge = 120;
        $total = $subtotal + $deliveryCharge;

        $orderNumber = 'ORD-' . strtoupper(Str::random(8));
        $tran_id = 'TXN-' . strtoupper(Str::random(12));

        // Use DB transaction to create order + items atomically
        DB::beginTransaction();
        try {
            // Create order and include payment_gateway field now
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'area' => $request->area,
                'address' => $request->address,
                'subtotal' => $subtotal,
                'delivery_charge' => $deliveryCharge,
                'total' => $total,
                'payment_method' => $request->payment_method === 'COD' ? 'COD' : 'SSLCommerz',
                'payment_gateway' => $request->payment_method === 'COD' ? 'COD' : 'SSLCommerz', // <-- new
                'is_paid' => 0,
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'transaction_id' => $tran_id,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->discount_price ?? $item->product->price,
                ]);
            }

            // For COD: we can clear cart now (customer will pay on delivery)
            if ($request->payment_method === 'COD') {
                Cart::where('user_id', $userId)->delete();
            }
            // For SSLCommerz: DO NOT clear cart here. Wait for IPN/Success confirmation.

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order creation failed: '.$e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to create order. Try again.');
        }

        // COD Payment flow (done)
        if ($request->payment_method === 'COD') {
            return redirect()->route('home')->with('success', 'Order placed successfully. Pay on delivery.');
        }

        // SSLCommerz Payment flow
        $post_data = [
            'total_amount' => $total,
            'currency' => 'BDT',
            'tran_id' => $tran_id,
            'cus_name' => $order->name,
            'cus_email' => $request->user()->email,
            'cus_add1' => $order->address,
            'cus_city' => $order->area,
            'cus_country' => 'Bangladesh',
            'cus_phone' => $order->mobile,
            'shipping_method' => 'NO',
            'product_name' => 'Order ' . $orderNumber,
            'product_category' => 'Ecommerce',
            'product_profile' => 'general',
            'success_url' => route('checkout.success'),
            'fail_url' => route('checkout.fail'),
            'cancel_url' => route('checkout.cancel'),
            'ipn_url' => route('checkout.ipn'),
        ];
        
    //   dd('initiating sslcommerz', $post_data);

        $sslc = new SslCommerzNotification();
        return $sslc->makePayment($post_data, 'hosted');
    }

    /**
     * Success callback
     */
public function success(Request $request)
{
    $tran_id = $request->input('tran_id');

    if (!$tran_id) {
        return redirect()->route('home')->with('error', 'Invalid transaction.');
    }

    // fetch order by transaction_id
    $order = Order::where('transaction_id', $tran_id)->first();

    if (!$order) {
        return redirect()->route('home')->with('error', 'Order not found.');
    }

    return view('checkout-success', compact('order'));
}



    /**
     * Fail or Cancel callback
     */
    public function fail(Request $request)
    {
        return view('checkout-fail');
    }
    
    public function cancel(Request $request)
    {
        return view('checkout-cancel');
    }


    /**
     * IPN (server-to-server) route
     */
    public function ipn(Request $request)
    {
        Log::info('IPN Hit now:', $request->all()); // debug logging

        $tran_id = $request->input('tran_id');
        if (!$tran_id) {
            Log::warning('IPN missing tran_id', $request->all());
            return response('Invalid data', 400);
        }

        $order = Order::where('transaction_id', $tran_id)->first();
        if (!$order) {
            Log::warning("IPN order not found for tran_id: {$tran_id}", $request->all());
            return response('Order not found', 404);
        }

        // Only process if unpaid
        if ($order->payment_status === 'unpaid') {
            $sslc = new SslCommerzNotification();

            // Perform validation using the library - log result
            try {
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order->total, 'BDT');
            } catch (\Throwable $e) {
                Log::error('IPN validation exception: '.$e->getMessage(), ['exception' => $e]);
                return response('Validation error', 500);
            }

            Log::info("IPN validation result for {$tran_id}: ".var_export($validation, true));

            if ($validation === true) {
                // update order as paid and store gateway response & gateway ids
                $updateData = [
                    'payment_status' => 'paid',
                    'status' => 'processing',
                    'payment_gateway' => 'SSLCommerz',
                    'payment_date' => Carbon::now(),
                    'gateway_response' => json_encode($request->all()),
                    'is_paid' => 1,
                ];

              

                $order->update($updateData);

                // optionally clear cart now that payment confirmed (if still present)
                try {
                    Cart::where('user_id', $order->user_id)->delete();
                } catch (\Throwable $e) {
                    Log::warning('Failed to clear cart after IPN: '.$e->getMessage());
                }

                Log::info("Order updated via IPN: {$tran_id}");
                return response('Transaction successfully completed', 200);
            }

            Log::error("IPN Validation Failed: {$tran_id}", $request->all());
            return response('Validation failed', 400);
        }

        return response('Transaction already processed', 200);
    }
}
