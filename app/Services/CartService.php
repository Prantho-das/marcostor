<?php
namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CartService
{
    protected $sessionKey = 'cart';

    // Get session cart (assoc by product_id)
    public function getSessionCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    public function putSessionCart(array $cart)
    {
        Session::put($this->sessionKey, $cart);
    }

    public function addToSession($product, int $quantity = 1)
    {
        $cart = $this->getSessionCart();
        $id = (string)$product->id;
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->discount_price ?? $product->price,
                'name' => $product->name,
                'image' => $product->mainImage ? $product->mainImage->image_path : null,
            ];
        }
        $this->putSessionCart($cart);
        return $cart;
    }

    public function removeFromSession($productId)
    {
        $cart = $this->getSessionCart();
        unset($cart[(string)$productId]);
        $this->putSessionCart($cart);
    }

    public function clearSession()
    {
        Session::forget($this->sessionKey);
    }

    // DB operations for logged-in users
    public function addToDb($userId, $product, int $quantity = 1)
    {
        // Check if cart item already exists
        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $product->id)
                    ->first();

        if ($cart) {
            // Existing product → increment quantity
            $cart->quantity += $quantity;
            $cart->meta = [
                'price' => $product->discount_price ?? $product->price,
                'name' => $product->name,
                'image' => $product->mainImage?->image_path ?? null
            ];
            $cart->save();
        } else {
            // New product → set quantity exactly
            $cart = Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'meta' => [
                    'price' => $product->discount_price ?? $product->price,
                    'name' => $product->name,
                    'image' => $product->mainImage?->image_path ?? null
                ]
            ]);
        }

        return $cart;
    }


    public function mergeSessionToDb($userId)
    {
        $sessionCart = $this->getSessionCart();
        DB::transaction(function() use ($sessionCart, $userId) {
            foreach ($sessionCart as $item) {
                $productId = $item['product_id'];
                $qty = (int)$item['quantity'];
                $cart = Cart::where('user_id',$userId)->where('product_id',$productId)->first();
                if ($cart) {
                    $cart->increment('quantity', $qty);
                } else {
                    Cart::create([
                        'user_id' => $userId,
                        'product_id' => $productId,
                        'quantity' => $qty,
                        'meta' => [
                            'price' => $item['price'] ?? null,
                            'name' => $item['name'] ?? null,
                            'image' => $item['image'] ?? null,
                        ],
                    ]);
                }
            }
            // Clear session after merge
            $this->clearSession();
        });
    }

    public function getDbCart($userId)
    {
        return Cart::with('product')->where('user_id', $userId)->get();
    }
}
