<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request for POS (Point of Sale) transaction validation.
 * Validates transaction type and line items with variant IDs and quantities.
 */
class PosTransactionRequest extends FormRequest
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
            'transaction_type'              => 'required|in:pos',
            'payment_method'                => 'nullable|in:cash,transfer,qris',
            'items'                         => 'required|array|min:1',
            'items.*.product_variant_id'    => 'required|exists:product_variants,id',
            'items.*.quantity'              => 'required|numeric|min:0.5',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required'                     => 'Keranjang kasir tidak boleh kosong.',
            'items.*.product_variant_id.required' => 'ID varian produk wajib ada.',
            'items.*.product_variant_id.exists'   => 'Varian produk tidak ditemukan di database.',
            'items.*.quantity.min'                => 'Jumlah minimal pembelian adalah 0.5 meter.',
        ];
    }
}
