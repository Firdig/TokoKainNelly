<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add database indexes on frequently queried columns to optimize
     * performance under high concurrency.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
            $table->index('transaction_type');
            $table->index('created_at');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('fabric_type');
            $table->index('price');
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->index('stock');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['transaction_type']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['fabric_type']);
            $table->dropIndex(['price']);
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropIndex(['stock']);
        });
    }
};
