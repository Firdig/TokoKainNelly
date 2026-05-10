<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Controller for handling Midtrans payment gateway notifications.
 *
 * This controller receives webhook notifications from Midtrans
 * when payment status changes (settlement, expire, cancel, etc.).
 *
 * The endpoint must be:
 * - Publicly accessible (no auth middleware)
 * - Excluded from CSRF verification (handled via API routes)
 * - Returns 200 OK quickly to acknowledge receipt
 */
class MidtransController extends Controller
{
    public function __construct(
        private readonly MidtransService $midtransService
    ) {}

    /**
     * Handle incoming Midtrans notification webhook.
     *
     * Midtrans sends POST requests with JSON payload containing:
     * - order_id: Our invoice_number
     * - transaction_status: settlement, pending, deny, expire, cancel, etc.
     * - fraud_status: accept, challenge, deny
     * - signature_key: SHA-512 hash for verification
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function notification(Request $request)
    {
        try {
            $payload = $request->all();

            Log::info('Midtrans webhook received', [
                'order_id'           => $payload['order_id'] ?? 'unknown',
                'transaction_status' => $payload['transaction_status'] ?? 'unknown',
            ]);

            $order = $this->midtransService->handleNotification($payload);

            if ($order) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Notification processed',
                    'order_id' => $order->invoice_number,
                    'payment_status' => $order->payment_status,
                ], 200);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Order not found or invalid signature',
            ], 404);

        } catch (\Exception $e) {
            Log::error('Midtrans webhook error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Always return 200 to Midtrans to prevent retry floods
            // The error is logged for debugging
            return response()->json([
                'status'  => 'error',
                'message' => 'Internal error, logged for review',
            ], 200);
        }
    }
}
