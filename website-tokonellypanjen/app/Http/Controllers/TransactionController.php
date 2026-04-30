<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosTransactionRequest;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Auth;

/**
 * Handles POS (Point of Sale) transactions from the cashier interface.
 * Delegates all transaction logic to CheckoutService.
 */
class TransactionController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService
    ) {}

    /**
     * Process a POS transaction via AJAX from the cashier UI.
     * Uses pessimistic locking to prevent race conditions on stock.
     *
     * @param  PosTransactionRequest $request  Validated POS items
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PosTransactionRequest $request)
    {
        try {
            $order = $this->checkoutService->processPosTransaction(
                items: $request->validated('items'),
                cashierId: Auth::id(),
                paymentMethod: $request->validated('payment_method') ?? 'cash',
            );

            return response()->json([
                'message' => 'Transaksi berhasil, stok sudah dipotong!',
                'order'   => $order,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}