<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'category_id' => 'required|integer',
            'quantity' => 'sometimes|integer',
            'weight' => 'sometimes',
            'width' => 'sometimes',
            'length' => 'sometimes'
        ];
    }
}
