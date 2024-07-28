<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
//            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
//            'phone' => 'required|string|min:10|max:13',
        ];
    }
}
