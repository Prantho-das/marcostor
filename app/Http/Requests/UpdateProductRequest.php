<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
   public function rules()
{
    $productParam = $this->route('product');
    $productId = is_object($productParam) ? $productParam->id : $productParam;

    return [
        'name' => 'required|string|max:255',
        'slug' => [
            'nullable', 'string', 'max:255',
            Rule::unique('products', 'slug')->ignore($productId),
        ],
        'brand_id' => 'nullable|exists:brands,id',
        'colors.*' => 'nullable|exists:colors,id',
        'category_id' => 'nullable|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'discount_price' => 'nullable|numeric|min:0|',
        'stock' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
    ];
}

}
