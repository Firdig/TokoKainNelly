<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request for E-Commerce checkout validation.
 * Validates transaction type, payment method, and customer information.
 */
class CheckoutRequest extends FormRequest
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
        $rules = [
            'transaction_type' => 'required|in:bops,delivery',
            'payment_method'   => 'required|string|max:50',
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
        ];

        // Delivery requires an address
        if ($this->input('transaction_type') === 'delivery') {
            $rules['delivery_address'] = 'required|string|max:500';
        }

        return $rules;
    }

    /**
     * Custom error messages in Bahasa Indonesia for user clarity.
     */
    public function messages(): array
    {
        return [
            'transaction_type.required' => 'Silakan pilih metode pengambilan/pengiriman.',
            'transaction_type.in'       => 'Metode pengambilan tidak valid.',
            'payment_method.required'   => 'Silakan pilih metode pembayaran.',
            'customer_name.required'    => 'Nama lengkap wajib diisi.',
            'customer_phone.required'   => 'Nomor telepon wajib diisi.',
            'delivery_address.required' => 'Alamat pengiriman wajib diisi untuk metode Delivery.',
        ];
    }
}
