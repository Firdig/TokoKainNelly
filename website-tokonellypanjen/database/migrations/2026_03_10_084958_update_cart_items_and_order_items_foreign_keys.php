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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->renameColumn('product_id', 'product_variant_id');
            // Normally we'd drop & re-add the constraint, but since local dev might use simple schema we rename logical column
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('product_id', 'product_variant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->renameColumn('product_variant_id', 'product_id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('product_variant_id', 'product_id');
        });
    }
};
