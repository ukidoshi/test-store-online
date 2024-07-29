<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;

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
        $productData = $request->safe()->except(['quantity','width','length','weight']);
        $productAttrData = $request->safe()->only(['quantity','width','length','weight']);

        $category = Category::find($productData['category_id']);
        if ($category && $category->getDepth() === 0) {
            return response()->json(['error' => 'Cannot add products to categories on the first level.'], 400);
        }

        $product = Product::create($productData);
        $productAttr = ProductAttribute::create($productAttrData + ['product_id' => $product->id]);
        return ProductResource::make($product)->resolve();
    }
}
