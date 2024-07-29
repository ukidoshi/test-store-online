<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddProductToCartRequest;
use App\Http\Requests\Cart\MakeOrderRequest;
use App\Http\Requests\Cart\RemoveProductFromCartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(Request $request)
    {
        $this->cartService = new CartService($request);
    }

    public function index()
    {
        return $this->cartService->showItemsInCart();
    }

    public function add(AddProductToCartRequest $product_id)
    {
        return $this->cartService->addProduct($product_id);
    }

    public function remove(RemoveProductFromCartRequest $product_id)
    {
        return $this->cartService->removeProduct($product_id);
    }

    public function clear(RemoveProductFromCartRequest $product_id)
    {
        return $this->cartService->clearProduct($product_id);
    }

    public function order(MakeOrderRequest $request)
    {
        return $this->cartService->makeOrder($request);
    }
}
