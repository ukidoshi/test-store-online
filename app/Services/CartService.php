<?php

namespace App\Services;

use App\Http\Requests\Cart\AddProductToCartRequest;
use App\Http\Requests\Cart\MakeOrderRequest;
use App\Http\Requests\Cart\RemoveProductFromCartRequest;
use App\Http\Resources\Cart\CartItemResource;
use App\Http\Resources\Cart\CartResource;
use App\Http\Resources\Cart\OrderResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected int $user_id;
    protected string $session_id;

    protected Cart $cart;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            if (!$request->get('session_id')) return response()->json(['message' => 'session_id required'], 400);
            $cart = Cart::firstOrCreate(['session_id' => $request->get('session_id')]);
        }
        $this->cart = $cart;
    }

    public function showItemsInCart()
    {
        return new CartResource($this->cart);
    }

    public function addProduct(AddProductToCartRequest $request)
    {

        $product = Product::find($request->validated(['product_id']));
        if (! $product) return response()->json(['message' => 'no such product'], 404);

        $cartItem = CartItem::where('cart_id', $this->cart->id)->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $this->cart->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return new CartItemResource($cartItem);
    }

    public function removeProduct(RemoveProductFromCartRequest $request)
    {
        $product = Product::find($request->validated(['product_id']));
        if (! $product) return response()->json(['message' => 'no such product'], 404);

        $cartItem = CartItem::where('cart_id', $this->cart->id)->where('product_id', $product->id)->first();

        if (!$cartItem) return response()->json(['message' => 'no such cart'], 404);

        $cartItem->quantity--;
        if ($cartItem->quantity == 0) {
            $cartItem->delete();
        } else {
            $cartItem->save();
        }

        return new CartItemResource($cartItem);
    }

    public function clearProduct(RemoveProductFromCartRequest $request)
    {
        $product = Product::find($request->validated(['product_id']));
        if (! $product) return response()->json(['message' => 'no such product'], 404);

        $cartItem = CartItem::where('cart_id', $this->cart->id)->where('product_id', $product->id)->first();

        if (!$cartItem) return response()->json(['message' => 'no such cart'], 404);

        $cartItem->delete();

        return new CartItemResource(null);
    }

    public function makeOrder(MakeOrderRequest $request)
    {
        $phone = '';
        $email = '';
        if (Auth::check()) {
            $phone = Auth::user()->phone;
            $email = Auth::user()->email;
        } else {
            $phone = $request->validated(['phone']);
            $email = $request->validated(['email']);
        }

        $order = Order::create([
            'email' => $email,
            'phone' => $phone,
            'cart_id' => $this->cart->id
        ]);

        return new OrderResource($order);
    }
}
