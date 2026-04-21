<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_number')->unique(); // Nomor Nota
        // Membedakan jenis transaksi sesuai kebutuhanmu: Kasir (POS), BOPS (Click & Collect), atau Delivery
        $table->enum('transaction_type', ['pos', 'bops', 'delivery']); 
        $table->enum('status', ['pending', 'completed', 'cancelled']); // Status pesanan
        $table->integer('total_amount'); // Total belanja
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
