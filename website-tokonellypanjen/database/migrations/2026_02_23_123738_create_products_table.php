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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama kain
        $table->text('description')->nullable(); // Deskripsi kain
        $table->integer('price'); // Harga kain
        $table->integer('stock'); // Stok kain (Ini yang akan jadi acuan Perpetual Inventory)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
