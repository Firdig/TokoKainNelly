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
            'payment_method'   => 'required|string|in:midtrans,cod',
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
        ];

        // Delivery requires address + coordinates for Gojek/Grab
        if ($this->input('transaction_type') === 'delivery') {
            $rules['delivery_address']        = 'required|string|max:500';
            $rules['destination_area_id']     = 'required|string|max:100';
            $rules['shipping_cost']           = 'required|numeric|min:0';
            $rules['shipping_courier_code']   = 'required|string|max:50';
            $rules['shipping_courier_service'] = 'required|string|max:50';
            $rules['shipping_courier_name']   = 'required|string|max:100';
            $rules['shipping_etd']            = 'nullable|string|max:50';
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
