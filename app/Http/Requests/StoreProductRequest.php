<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'old_price' => 'nullable|numeric|min:0|max:999999.99|gte:price',
            'brand' => 'required|string|max:100',
            'category' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0|max:10000',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'is_active' => 'boolean',
        ];
    }
    
    public function messages(): array
    {
        return [
            'old_price.gte' => 'Old price must be greater than or equal to current price.',
            'price.min' => 'Price must be at least $0.01.',
            'stock.max' => 'Stock cannot exceed 10,000 units.',
        ];
    }
}
