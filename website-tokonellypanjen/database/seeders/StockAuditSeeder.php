<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockAudit;
use App\Models\User;

/**
 * Seeder untuk data stock opname (audit fisik stok).
 * Membuat beberapa record audit dengan selisih stok untuk demo laporan.
 */
class StockAuditSeeder extends Seeder
{
    public function run(): void
    {
        $auditor = User::where('role', 'admin')->first()
            ?? User::where('role', 'staff')->first();

        if (!$auditor) {
            $this->command->warn('⚠️  Jalankan AdminUserSeeder terlebih dahulu!');
            return;
        }

        $variants = ProductVariant::with('product')->inRandomOrder()->take(8)->get();

        if ($variants->isEmpty()) {
            $this->command->warn('⚠️  Jalankan ProductSeeder terlebih dahulu!');
            return;
        }

        $auditCount = 0;

        foreach ($variants as $variant) {
            $systemStock = $variant->stock;
            // Simulate slight differences found during physical count
            $physicalStock = $systemStock + rand(-5, 3);
            if ($physicalStock < 0) $physicalStock = 0;

            $difference = $physicalStock - $systemStock;

            StockAudit::create([
                'product_id'         => $variant->product_id,
                'product_variant_id' => $variant->id,
                'auditor_id'         => $auditor->id,
                'system_stock'       => $systemStock,
                'physical_stock'     => $physicalStock,
                'difference'         => $difference,
                'notes'              => $difference === 0
                    ? 'Stok sesuai, tidak ada selisih.'
                    : ($difference > 0
                        ? 'Ditemukan kelebihan stok ' . abs($difference) . 'm. Kemungkinan salah input sebelumnya.'
                        : 'Kekurangan stok ' . abs($difference) . 'm. Kemungkinan penyusutan atau salah potong.'),
                'status'             => $difference === 0 ? 'reconciled' : 'reconciled',
                'created_at'         => now()->subDays(rand(1, 7)),
            ]);

            // Update the variant stock to the physical count
            $variant->update(['stock' => $physicalStock]);
            $auditCount++;
        }

        $this->command->info("✅ StockAuditSeeder: {$auditCount} record audit stok berhasil di-seed.");
    }
}
