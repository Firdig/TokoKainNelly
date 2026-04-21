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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->double('stock', 10, 2)->change();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->double('quantity', 10, 2)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->double('quantity', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->integer('stock')->change();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->integer('quantity')->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('quantity')->change();
        });
    }
};
