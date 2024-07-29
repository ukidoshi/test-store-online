<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        return new CategoryCollection(Category::paginate(15));
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validationData();

        if (!Category::isValidDepth($data['parent_id'] ?? null)) {
            return response()->json(['error' => 'Category level cannot exceed 3'], 400);
        }

        $category = Category::create($data);
        return new CategoryResource($category);
    }
}
