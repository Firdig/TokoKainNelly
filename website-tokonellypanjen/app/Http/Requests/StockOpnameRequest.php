<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request for stock opname (physical audit) validation.
 * Validates audit entries at the variant level.
 */
class StockOpnameRequest extends FormRequest
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
            'audits'                          => 'required|array',
            'audits.*.product_variant_id'     => 'required|exists:product_variants,id',
            'audits.*.physical_stock'         => 'nullable|numeric|min:0',
            'audits.*.notes'                  => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'audits.required'                          => 'Data audit tidak boleh kosong.',
            'audits.*.product_variant_id.required'     => 'ID varian produk wajib ada.',
            'audits.*.product_variant_id.exists'       => 'Varian produk tidak ditemukan.',
            'audits.*.physical_stock.numeric'          => 'Stok fisik harus berupa angka.',
        ];
    }
}
