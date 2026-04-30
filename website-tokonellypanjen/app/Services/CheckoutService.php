<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Service class responsible for all checkout and transaction logic.
 * Handles both E-Commerce (online) and POS (offline) checkout flows,
 * ensuring stock integrity via pessimistic locking.
 */
class CheckoutService
{
    /**
     * Process an E-Commerce checkout (Delivery or BOPS).
     *
     * Uses DB::transaction with pessimistic locking (lockForUpdate)
     * to prevent race conditions when multiple users checkout
     * the same low-stock variant simultaneously.
     *
     * @param  array  $cartItems     Collection of CartItem models (with productVariant loaded)
     * @param  string $transactionType  'delivery' or 'bops'
     * @param  string $paymentMethod    Payment method identifier
     * @param  int|null $userId         Authenticated customer's user ID
     * @param  array  $customerInfo     ['name' => ..., 'phone' => ..., 'address' => ...]
     * @return \App\Models\Order
     *
     * @throws \Exception If stock is insufficient for any item.
     */
    public function processEcommerceCheckout(
        $cartItems,
        string $transactionType,
        string $paymentMethod,
        ?int $userId = null,
        array $customerInfo = []
    ): Order {
        return DB::transaction(function () use ($cartItems, $transactionType, $paymentMethod, $userId, $customerInfo) {
            $totalAmount = 0;

            // Generate a unique pickup code for BOPS orders
            $pickupCode = $transactionType === 'bops'
                ? strtoupper(Str::random(6))
                : null;

            // Estimated pickup: 2 hours from now for BOPS
            $estimatedPickup = $transactionType === 'bops'
                ? now()->addHours(2)
                : null;

            // 1. Create the order header
            $order = Order::create([
                'invoice_number'       => 'INV-' . time() . '-' . strtoupper(Str::random(4)),
                'user_id'              => $userId,
                'transaction_type'     => $transactionType,
                'status'               => 'pending',
                'total_amount'         => 0,
                'pickup_code'          => $pickupCode,
                'estimated_pickup_at'  => $estimatedPickup,
                'customer_name'        => $customerInfo['name'] ?? null,
                'customer_phone'       => $customerInfo['phone'] ?? null,
                'delivery_address'     => $customerInfo['address'] ?? null,
                'payment_method'       => $paymentMethod,
            ]);

            // 2. Process each cart item with pessimistic locking
            foreach ($cartItems as $item) {
                // Lock the variant row to prevent concurrent modification
                $variant = ProductVariant::where('id', $item->product_variant_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Validate stock availability under the lock
                if ($variant->stock < $item->quantity) {
                    throw new \Exception(
                        "Maaf, stok kain \"{$variant->product->name}\" warna \"{$variant->color_name}\" "
                        . "tidak mencukupi. Tersedia: {$variant->stock}, diminta: {$item->quantity}."
                    );
                }

                $subTotal = $variant->product->price * $item->quantity;
                $totalAmount += $subTotal;

                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $variant->id,
                    'quantity'           => $item->quantity,
                    'price'              => $variant->product->price,
                ]);

                // Simpan stok sebelum dikurangi untuk log movement
                $stockBefore = $variant->stock;

                // Deduct stock atomically
                $variant->decrement('stock', $item->quantity);

                // Catat pergerakan stok ke log terpusat
                StockMovement::create([
                    'product_variant_id' => $variant->id,
                    'movement_type'      => 'sale_online',
                    'quantity'           => -$item->quantity,
                    'stock_before'       => $stockBefore,
                    'stock_after'        => $stockBefore - $item->quantity,
                    'reference_type'     => 'order',
                    'reference_id'       => $order->id,
                    'created_by'         => $userId,
                ]);
            }

            // 3. Update total amount
            $order->update(['total_amount' => $totalAmount]);

            return $order;
        });
    }

    /**
     * Process a POS (Point of Sale) transaction for in-store purchases.
     *
     * Similar to E-Commerce but immediately marks order as 'completed'
     * since payment is received on the spot.
     *
     * @param  array  $items  Array of ['product_variant_id' => int, 'quantity' => float]
     * @param  int|null $cashierId  The staff/admin user processing the sale
     * @return \App\Models\Order
     *
     * @throws \Exception If stock is insufficient for any item.
     */
    public function processPosTransaction(array $items, ?int $cashierId = null, string $paymentMethod = 'cash'): Order
    {
        return DB::transaction(function () use ($items, $cashierId, $paymentMethod) {
            $totalAmount = 0;

            $order = Order::create([
                'invoice_number'   => 'POS-' . time() . '-' . strtoupper(Str::random(4)),
                'user_id'          => $cashierId,
                'transaction_type' => 'pos',
                'status'           => 'completed',
                'total_amount'     => 0,
                'payment_method'   => $paymentMethod,
            ]);

            foreach ($items as $itemData) {
                // Pessimistic lock: prevent race condition
                $variant = ProductVariant::where('id', $itemData['product_variant_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($variant->stock < $itemData['quantity']) {
                    throw new \Exception(
                        "Maaf, stok kain \"{$variant->product->name}\" warna \"{$variant->color_name}\" "
                        . "tidak mencukupi. Tersedia: {$variant->stock}, diminta: {$itemData['quantity']}."
                    );
                }

                $subTotal = $variant->product->price * $itemData['quantity'];
                $totalAmount += $subTotal;

                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $variant->id,
                    'quantity'           => $itemData['quantity'],
                    'price'              => $variant->product->price,
                ]);

                // Simpan stok sebelum dikurangi untuk log movement
                $stockBefore = $variant->stock;

                $variant->decrement('stock', $itemData['quantity']);

                // Catat pergerakan stok ke log terpusat
                StockMovement::create([
                    'product_variant_id' => $variant->id,
                    'movement_type'      => 'sale_pos',
                    'quantity'           => -$itemData['quantity'],
                    'stock_before'       => $stockBefore,
                    'stock_after'        => $stockBefore - $itemData['quantity'],
                    'reference_type'     => 'order',
                    'reference_id'       => $order->id,
                    'created_by'         => $cashierId,
                ]);
            }

            $order->update(['total_amount' => $totalAmount]);

            return $order;
        });
    }
}
