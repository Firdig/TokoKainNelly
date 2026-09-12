<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

/**
 * Service class for Midtrans payment gateway integration.
 *
 * Handles:
 * - Snap token generation for the payment popup
 * - Webhook notification processing and signature verification
 * - Payment status updates and order lifecycle management
 */
class MidtransService
{
    public function __construct()
    {
        // Configure Midtrans SDK
        \Midtrans\Config::$serverKey  = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Create a Midtrans Snap token for the given order.
     *
     * The token is used on the frontend to open the Snap payment popup.
     * Item details and customer info are sent to Midtrans for the payment page.
     *
     * @param  Order  $order  The order (must have items loaded)
     * @return string Snap token
     *
     * @throws \Exception If Snap token creation fails
     */
    public function createSnapToken(Order $order): string
    {
        // Ensure items are loaded
        $order->loadMissing('items.productVariant.product');

        // Build item details array for Midtrans
        $itemDetails = [];
        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id'       => 'VARIANT-' . $item->product_variant_id,
                'price'    => (int) round($item->price * $item->quantity / $item->quantity), // per-unit price
                'quantity' => (int) ceil($item->quantity), // Midtrans requires integer qty
                'name'     => mb_substr(
                    ($item->productVariant->product->name ?? 'Produk') . ' - ' . ($item->productVariant->color_name ?? ''),
                    0,
                    50 // Midtrans max 50 chars
                ),
            ];
        }

        // Recalculate to ensure Midtrans total matches
        // Midtrans requires gross_amount == sum(price * quantity) of all items
        $calculatedTotal = 0;
        foreach ($itemDetails as &$detail) {
            $detail['price'] = (int) round($detail['price']);
            $calculatedTotal += $detail['price'] * $detail['quantity'];
        }

        // If there's a rounding discrepancy, add adjustment item
        $orderTotal = (int) round($order->total_amount);
        if ($calculatedTotal !== $orderTotal) {
            $diff = $orderTotal - $calculatedTotal;
            $itemDetails[] = [
                'id'       => 'ADJUSTMENT',
                'price'    => $diff,
                'quantity' => 1,
                'name'     => 'Penyesuaian Pembulatan',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order->invoice_number,
                'gross_amount' => $orderTotal,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $order->customer_name ?? 'Pelanggan',
                'phone'      => $order->customer_phone ?? '',
                'email'      => $order->user->email ?? '',
            ],
            'callbacks' => [
                'finish' => route('checkout.success', $order->id),
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Persist the token so the customer can re-open payment later
            $order->update(['snap_token' => $snapToken]);

            Log::info('Midtrans Snap token created', [
                'order_id' => $order->id,
                'invoice'  => $order->invoice_number,
            ]);

            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Snap token creation failed', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Handle incoming Midtrans webhook notification.
     *
     * Verifies the signature hash to ensure the notification is authentic,
     * then updates the order's payment status accordingly.
     *
     * @param  array  $payload  The raw notification payload from Midtrans
     * @return Order|null The updated order, or null if not found
     */
    public function handleNotification(array $payload): ?Order
    {
        $orderId           = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus       = $payload['fraud_status'] ?? 'accept';
        $paymentType       = $payload['payment_type'] ?? null;
        $transactionId     = $payload['transaction_id'] ?? null;
        $signatureKey      = $payload['signature_key'] ?? null;
        $statusCode        = $payload['status_code'] ?? null;
        $grossAmount       = $payload['gross_amount'] ?? null;

        if (!$orderId) {
            Log::warning('Midtrans notification: missing order_id');
            return null;
        }

        // Verify signature to prevent spoofing
        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash('sha512',
            $orderId . $statusCode . $grossAmount . $serverKey
        );

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans notification: invalid signature', [
                'order_id' => $orderId,
            ]);
            return null;
        }

        // Find order by invoice number (order_id in Midtrans = our invoice_number)
        $order = Order::where('invoice_number', $orderId)->first();

        if (!$order) {
            Log::warning('Midtrans notification: order not found', [
                'order_id' => $orderId,
            ]);
            return null;
        }

        // Prevent processing if already in a terminal state
        if (in_array($order->payment_status, ['paid', 'refunded'])) {
            Log::info('Midtrans notification: order already in terminal state', [
                'order_id'       => $orderId,
                'payment_status' => $order->payment_status,
            ]);
            return $order;
        }

        Log::info('Midtrans notification received', [
            'order_id'           => $orderId,
            'transaction_status' => $transactionStatus,
            'fraud_status'       => $fraudStatus,
            'payment_type'       => $paymentType,
        ]);

        // Determine new payment status based on Midtrans transaction_status
        $newPaymentStatus = $this->resolvePaymentStatus($transactionStatus, $fraudStatus);

        // Update order with Midtrans details
        $updateData = [
            'midtrans_transaction_id' => $transactionId,
            'midtrans_payment_type'   => $paymentType,
            'payment_status'          => $newPaymentStatus,
        ];

        if ($newPaymentStatus === 'paid') {
            $updateData['paid_at'] = now();
        }

        $order->update($updateData);

        // Handle cancellation: restore stock if payment failed/expired/denied
        if (in_array($newPaymentStatus, ['expired', 'failed', 'cancelled'])) {
            $this->cancelOrderAndRestoreStock($order);
        }

        return $order;
    }

    /**
     * Map Midtrans transaction_status to our payment_status.
     */
    private function resolvePaymentStatus(string $transactionStatus, string $fraudStatus): string
    {
        return match ($transactionStatus) {
            'capture' => $fraudStatus === 'accept' ? 'paid' : 'failed',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'cancelled',
            'refund', 'partial_refund' => 'refunded',
            default => 'unpaid',
        };
    }

    /**
     * Cancel the order and restore stock for all items.
     * Only cancels if the order isn't already cancelled.
     */
    private function cancelOrderAndRestoreStock(Order $order): void
    {
        if ($order->status === 'cancelled') {
            return;
        }

        // Use InventoryService if available for consistent stock restoration
        try {
            $inventoryService = app(InventoryService::class);
            $inventoryService->restoreStockForCancelledOrder($order, null);
        } catch (\Exception $e) {
            Log::error('Failed to restore stock for cancelled order', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }

        $order->update(['status' => 'cancelled']);

        Log::info('Order cancelled due to payment failure', [
            'order_id' => $order->id,
            'invoice'  => $order->invoice_number,
        ]);
    }

    /**
     * Refund a paid Midtrans order (full refund).
     *
     * Calls the Midtrans Refund API to return the payment to the buyer.
     * Updates the order's payment_status to 'refunded' on success.
     *
     * @param  Order  $order  The paid order to refund
     * @return bool True if refund was successful
     */
    public function refundOrder(Order $order): bool
    {
        if ($order->payment_status !== 'paid') {
            Log::warning('Refund skipped: order is not paid', [
                'order_id'       => $order->id,
                'payment_status' => $order->payment_status,
            ]);
            return false;
        }

        if (empty($order->midtrans_transaction_id)) {
            Log::warning('Refund skipped: no Midtrans transaction ID', [
                'order_id' => $order->id,
            ]);
            return false;
        }

        $refundKey = 'refund-' . $order->invoice_number . '-' . time();
        $params = [
            'refund_key' => $refundKey,
            'amount'     => (int) round($order->total_amount),
            'reason'     => 'Pembatalan pesanan oleh pelanggan',
        ];

        try {
            \Midtrans\Transaction::refund($order->midtrans_transaction_id, $params);

            $order->update(['payment_status' => 'refunded']);

            Log::info('Midtrans refund successful', [
                'order_id'       => $order->id,
                'invoice'        => $order->invoice_number,
                'transaction_id' => $order->midtrans_transaction_id,
                'amount'         => $params['amount'],
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Midtrans refund failed', [
                'order_id'       => $order->id,
                'invoice'        => $order->invoice_number,
                'transaction_id' => $order->midtrans_transaction_id,
                'error'          => $e->getMessage(),
            ]);

            return false;
        }
    }
}
