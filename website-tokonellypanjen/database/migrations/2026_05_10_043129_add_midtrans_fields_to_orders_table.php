<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Midtrans payment gateway fields to orders table.
 *
 * - snap_token: Midtrans Snap token for payment popup
 * - payment_status: Track payment lifecycle (unpaid → paid / expired / failed)
 * - midtrans_transaction_id: Transaction ID from Midtrans for reconciliation
 * - midtrans_payment_type: Payment method chosen (bank_transfer, gopay, etc.)
 * - paid_at: Timestamp when payment was confirmed
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('snap_token')->nullable()->after('payment_method');
            $table->string('payment_status', 20)->default('unpaid')->after('snap_token');
            $table->string('midtrans_transaction_id')->nullable()->after('payment_status');
            $table->string('midtrans_payment_type', 50)->nullable()->after('midtrans_transaction_id');
            $table->timestamp('paid_at')->nullable()->after('midtrans_payment_type');

            // Index for webhook lookups by Midtrans transaction ID
            $table->index('midtrans_transaction_id', 'idx_orders_midtrans_txn');
            $table->index('payment_status', 'idx_orders_payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_midtrans_txn');
            $table->dropIndex('idx_orders_payment_status');
            $table->dropColumn([
                'snap_token',
                'payment_status',
                'midtrans_transaction_id',
                'midtrans_payment_type',
                'paid_at',
            ]);
        });
    }
};
