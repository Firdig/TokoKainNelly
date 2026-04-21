<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Fix foreign key constraints on order_items and cart_items.
 *
 * The previous migration renamed the column from product_id to
 * product_variant_id, but the FK constraint still references
 * the `products` table. This migration drops the old FK and
 * creates a correct one pointing to `product_variants`.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Drop old FK on order_items (original name from product_id column)
        Schema::table('order_items', function (Blueprint $table) {
            // The original FK was created as order_items_product_id_foreign
            // After column rename, MySQL may keep the old constraint name
            $table->dropForeign('order_items_product_id_foreign');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('cascade');
        });

        // Drop old FK on cart_items
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign('cart_items_product_id_foreign');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_variant_id', 'order_items_product_id_foreign')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('product_variant_id', 'cart_items_product_id_foreign')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }
};
