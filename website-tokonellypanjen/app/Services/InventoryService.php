<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockAudit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Service class for centralized inventory management operations.
 * Handles stock deduction with locking and variant-level stock opname.
 */
class InventoryService
{
    /**
     * Deduct stock from a specific product variant with pessimistic locking.
     *
     * @param  int   $variantId  The product variant to deduct from
     * @param  float $quantity   The amount to deduct
     * @return \App\Models\ProductVariant  The updated variant
     *
     * @throws \Exception If stock is insufficient.
     */
    public function deductStock(int $variantId, float $quantity): ProductVariant
    {
        return DB::transaction(function () use ($variantId, $quantity) {
            $variant = ProductVariant::where('id', $variantId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($variant->stock < $quantity) {
                throw new \Exception(
                    "Stok tidak mencukupi untuk varian \"{$variant->color_name}\". "
                    . "Tersedia: {$variant->stock}, diminta: {$quantity}."
                );
            }

            $variant->decrement('stock', $quantity);

            return $variant->fresh();
        });
    }

    /**
     * Perform stock opname (physical audit) at the variant level.
     *
     * Compares physical stock counts against system records,
     * creates audit trail entries, and reconciles differences.
     *
     * @param  array $audits  Array of audit entries:
     *                        [['product_variant_id' => int, 'physical_stock' => float, 'notes' => string|null], ...]
     * @param  int   $auditorId  The user performing the audit
     * @return bool  True if any updates were made
     */
    public function performStockOpname(array $audits, int $auditorId): bool
    {
        $hasUpdates = false;

        DB::transaction(function () use ($audits, $auditorId, &$hasUpdates) {
            foreach ($audits as $auditData) {
                // Skip entries without physical_stock value
                if (!isset($auditData['physical_stock']) || $auditData['physical_stock'] === '') {
                    continue;
                }

                $variant = ProductVariant::where('id', $auditData['product_variant_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $difference = $auditData['physical_stock'] - $variant->stock;

                // Only create audit if there's a difference or a note
                if ($difference != 0 || !empty($auditData['notes'])) {
                    StockAudit::create([
                        'product_id'         => $variant->product_id,
                        'product_variant_id' => $variant->id,
                        'auditor_id'         => $auditorId,
                        'system_stock'       => $variant->stock,
                        'physical_stock'     => $auditData['physical_stock'],
                        'difference'         => $difference,
                        'notes'              => $auditData['notes'] ?? null,
                        'status'             => 'reconciled',
                    ]);

                    // Reconcile: update system stock to match physical count
                    $variant->update(['stock' => $auditData['physical_stock']]);
                    $hasUpdates = true;
                }
            }
        });

        return $hasUpdates;
    }
}
