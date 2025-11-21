<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // AJAX add
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);
        $quantity = $data['quantity'] ?? 1;
        $product = Product::findOrFail($data['product_id']);


        if (Auth::check()) {
            $this->cartService->addToDb(Auth::id(), $product, $quantity);
            return response()->json(['success' => true, 'message' => 'Added to cart (saved)']);
        } else {
            $this->cartService->addToSession($product, $quantity);
            return response()->json(['success' => true, 'message' => 'Added to cart (session)']);
        }
    }

    // show cart (both for guest & logged-in)
    public function index()
    {
        if (Auth::check()) {
            $items = $this->cartService->getDbCart(Auth::id());
            // normalize to view data
            $rows = $items->map(function($c){
                $p = $c->product;
                return [
                    'product_id' => $p->id,
                    'name' => $p->name,
                    'image' => $p->mainImage ? asset('public/storage/'.$p->mainImage->image_path) : asset('public/assets/images/placeholder.png'),
                    'price' => $p->discount_price ?? $p->price,
                    'quantity' => $c->quantity,
                    'subtotal' => ($p->discount_price ?? $p->price) * $c->quantity,
                ];
            })->toArray();
        } else {
            $session = $this->cartService->getSessionCart();
            $rows = array_map(function($i){
                return [
                    'product_id' => $i['product_id'],
                    'name' => $i['name'],
                    'image' => $i['image'] ? asset('public/storage/'.$i['image']) : asset('public/assets/images/placeholder.png'),
                    'price' => $i['price'],
                    'quantity' => $i['quantity'],
                    'subtotal' => $i['price'] * $i['quantity'],
                ];
            }, $session);
        }

        return view('cart', ['cartItems' => $rows]);
    }

    // update quantity
    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('product_id', $data['product_id'])->first();
            if ($cart) {
                $cart->update(['quantity' => $data['quantity']]);
            }
            return response()->json(['success' => true]);
        } else {
            $session = $this->cartService->getSessionCart();
            if (isset($session[$data['product_id']])) {
                $session[$data['product_id']]['quantity'] = $data['quantity'];
                $this->cartService->putSessionCart($session);
            }
            return response()->json(['success' => true]);
        }
    }

    // remove
    public function remove(Request $request)
    {
        $data = $request->validate(['product_id' => 'required|integer|exists:products,id']);
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->where('product_id', $data['product_id'])->delete();
        } else {
            $this->cartService->removeFromSession($data['product_id']);
        }
        return response()->json(['success' => true]);
    }

    // fetch cart data (for sidebar)
      public function fetch()
    {
        $items = [];
        $subtotal = 0;

        if (Auth::check()) {
            // DB cart for logged-in user
            $cartItems = $this->cartService->getDbCart(Auth::id());
            foreach ($cartItems as $cart) {
                $p = $cart->product;
                if (!$p) continue;

              $price = $p->discount_price ?? $p->price;
                $subtotal += $price * $cart->quantity;

                $items[] = [
                    'id' => $p->id,
                    'name' => $p->name,
                    'image' => $p->mainImage ? asset('public/storage/' . $p->mainImage->image_path) : asset('public/assets/images/placeholder.png'),
                    'price' => $price,
                    'quantity' => $cart->quantity,
                ];
            }
        } else {
            // Session cart for guests
            $cart = $this->cartService->getSessionCart();
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];

                $items[] = [
                    'id' => $item['product_id'],
                    'name' => $item['name'],
                    'image' => $item['image'] ? asset('public/storage/' . $item['image']) : asset('public/assets/images/placeholder.png'),
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ];
            }
        }

        return response()->json([
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    
}
