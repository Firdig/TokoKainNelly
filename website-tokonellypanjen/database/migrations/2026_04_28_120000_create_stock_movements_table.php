<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: stock_movements
 *
 * Tabel pencatatan terpusat untuk semua pergerakan stok:
 * penjualan POS, penjualan online, dan adjustment manual.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            // Varian produk yang stoknya bergerak
            $table->foreignId('product_variant_id')
                  ->constrained('product_variants')
                  ->cascadeOnDelete();

            // Jenis pergerakan stok
            $table->enum('movement_type', [
                'sale_pos',          // Penjualan via kasir
                'sale_online',       // Penjualan via e-commerce
                'opname_adjustment', // Penyesuaian dari stock opname
                'manual_addition',   // Penambahan stok manual
                'return',            // Retur barang
            ]);

            // Jumlah stok yang bergerak (negatif = keluar, positif = masuk)
            $table->double('quantity');

            // Snapshot stok sebelum dan sesudah pergerakan
            $table->double('stock_before');
            $table->double('stock_after');

            // Referensi ke sumber pergerakan (polymorphic-style, manual)
            $table->string('reference_type')->nullable(); // 'order' atau 'stock_audit'
            $table->unsignedBigInteger('reference_id')->nullable();

            // Catatan tambahan (opsional)
            $table->text('notes')->nullable();

            // Siapa yang memicu pergerakan ini (nullable untuk sistem/checkout publik)
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();

            // Index untuk performa query laporan
            $table->index(['product_variant_id', 'created_at']);
            $table->index(['reference_type', 'reference_id']);
            $table->index('movement_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
