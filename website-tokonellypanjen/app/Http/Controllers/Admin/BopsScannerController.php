<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class BopsScannerController extends Controller
{
    /**
     * Display the scanner interface.
     */
    public function index()
    {
        return view('admin.scanner.index');
    }

    /**
     * Verify the pickup code.
     * AD-13: Returns order details including payment status so admin
     * knows whether to collect COD payment before handover.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'pickup_code' => 'required|string',
        ]);

        $order = Order::with('items.productVariant.product', 'user')
            ->where('transaction_type', 'bops')
            ->where('pickup_code', $request->pickup_code)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Kode pengambilan tidak ditemukan.'
            ], 404);
        }

        if ($order->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan ini sudah selesai / sudah diambil.'
            ], 400);
        }

        if ($order->status !== 'ready_for_pickup') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan belum siap untuk diambil. Status saat ini: ' . str_replace('_', ' ', $order->status)
            ], 400);
        }

        // AD-13: Detect if payment is COD (not yet paid) so UI can prompt admin to collect cash
        $needsCodPayment = !$order->isPaid();

        return response()->json([
            'success' => true,
            'order' => [
                'id'              => $order->id,
                'invoice_number'  => $order->invoice_number,
                'customer_name'   => $order->customer_name ?? ($order->user->name ?? 'Pelanggan'),
                'total_amount'    => number_format($order->total_amount, 0, ',', '.'),
                'items_count'     => $order->items->count(),
                'payment_status'  => $order->payment_status,
                'needs_cod'       => $needsCodPayment,
            ]
        ]);
    }

    /**
     * Finalize the order (Handover).
     * AD-13: If order was not yet paid (COD), mark payment as paid upon handover.
     */
    public function handover(Request $request, Order $order)
    {
        if ($order->transaction_type !== 'bops') {
            return redirect()->back()->with('error', 'Pesanan bukan tipe BOPS.');
        }

        if ($order->status !== 'ready_for_pickup') {
            return redirect()->back()->with('error', 'Pesanan belum siap diambil.');
        }

        $updateData = [
            'status'     => 'completed',
            'updated_at' => now(),
        ];

        // AD-13: If the order was COD (not yet paid), record payment on handover
        if (!$order->isPaid()) {
            $updateData['payment_status'] = 'paid';
            $updateData['paid_at']        = now();
        }

        $order->update($updateData);

        return redirect()->route('admin.scanner.index')
            ->with('success', "Pesanan {$order->invoice_number} berhasil diserahkan dan diselesaikan.");
    }
}
