<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(ProductIndexRequest $request)
    {
        return ProductCollection::make(Product::all())->resolve();
    }

    public function show(Product $product)
    {
        return ProductResource::make($product)->resolve();
    }

    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());
        return ProductResource::make($product)->resolve();
    }
}
