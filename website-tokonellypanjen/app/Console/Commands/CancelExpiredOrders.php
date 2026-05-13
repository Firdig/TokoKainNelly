<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelExpiredOrders extends Command
{
    protected $signature = 'orders:cancel-expired';
    protected $description = 'Batalkan pesanan yang belum dibayar lebih dari 24 jam dan kembalikan stok';

    public function handle(): int
    {
        $expiredOrders = Order::where('payment_status', 'unpaid')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('Tidak ada pesanan kedaluwarsa.');
            return self::SUCCESS;
        }

        $count = 0;

        foreach ($expiredOrders as $order) {
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $variant = ProductVariant::where('id', $item->product_variant_id)
                        ->lockForUpdate()
                        ->first();

                    if ($variant) {
                        $stockBefore = $variant->stock;
                        $variant->increment('stock', $item->quantity);

                        StockMovement::create([
                            'product_variant_id' => $variant->id,
                            'movement_type'      => 'return',
                            'quantity'           => $item->quantity,
                            'stock_before'       => $stockBefore,
                            'stock_after'        => $stockBefore + $item->quantity,
                            'reference_type'     => 'order',
                            'reference_id'       => $order->id,
                            'notes'              => 'Pembatalan otomatis: pembayaran tidak diterima dalam 24 jam',
                        ]);
                    }
                }

                $order->update([
                    'status'         => 'cancelled',
                    'payment_status' => 'expired',
                ]);
            });

            $count++;
        }

        $this->info("Berhasil membatalkan {$count} pesanan kedaluwarsa.");
        return self::SUCCESS;
    }
}
