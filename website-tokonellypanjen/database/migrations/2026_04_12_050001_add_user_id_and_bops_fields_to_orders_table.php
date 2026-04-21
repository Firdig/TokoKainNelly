<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add user_id to link orders to customers, and BOPS-specific fields
     * for pickup code and estimated pickup time.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('pickup_code', 10)->nullable()->after('status');
            $table->timestamp('estimated_pickup_at')->nullable()->after('pickup_code');
            $table->string('customer_name')->nullable()->after('estimated_pickup_at');
            $table->string('customer_phone', 20)->nullable()->after('customer_name');
            $table->text('delivery_address')->nullable()->after('customer_phone');
            $table->string('payment_method', 50)->nullable()->after('delivery_address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id', 'pickup_code', 'estimated_pickup_at',
                'customer_name', 'customer_phone', 'delivery_address', 'payment_method'
            ]);
        });
    }
};
