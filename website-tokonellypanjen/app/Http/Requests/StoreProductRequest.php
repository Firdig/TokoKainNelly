<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request for creating a new product (admin).
 * Validates product details, gallery images, and variant entries.
 */
class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'                 => 'required|string|max:255',
            'description'          => 'required|string',
            'price'                => 'required|numeric|min:0',
            'fabric_type'          => 'nullable|string|max:100',
            'texture'              => 'nullable|string|max:255',
            'comfort_level'        => 'nullable|integer|min:1|max:5',
            'width'                => 'nullable|string|max:255',
            'composition'          => 'nullable|string|max:255',
            'fabric_care'          => 'nullable|string',
            'gallery'              => 'nullable|array',
            'gallery.*'            => 'nullable|image|max:2048',
            'variants'             => 'required|array|min:1',
            'variants.*.color_name' => 'required|string|max:255',
            'variants.*.hex_code'  => 'required|string|max:20',
            'variants.*.stock'     => 'required|numeric|min:0',
            'variants.*.image'     => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                 => 'Nama produk kain wajib diisi.',
            'variants.required'             => 'Minimal harus ada satu varian warna.',
            'variants.*.color_name.required' => 'Nama warna varian wajib diisi.',
            'variants.*.stock.required'     => 'Stok varian wajib diisi.',
        ];
    }
}
