<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Biteship shipping fields to orders table.
 *
 * - shipping_cost: the courier fee charged to the customer
 * - shipping_courier_code: courier identifier (e.g., jne, sicepat)
 * - shipping_courier_service: service type (e.g., reg, express)
 * - shipping_courier_name: display name (e.g., "JNE Reguler")
 * - shipping_etd: estimated time of delivery (e.g., "2-3 hari")
 * - shipping_tracking_id: waybill or Biteship order ID for tracking
 * - destination_area_id: Biteship area ID for the destination
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_cost', 12, 2)->default(0)->after('total_amount');
            $table->string('shipping_courier_code', 50)->nullable()->after('shipping_cost');
            $table->string('shipping_courier_service', 50)->nullable()->after('shipping_courier_code');
            $table->string('shipping_courier_name', 100)->nullable()->after('shipping_courier_service');
            $table->string('shipping_etd', 50)->nullable()->after('shipping_courier_name');
            $table->string('shipping_tracking_id')->nullable()->after('shipping_etd');
            $table->string('destination_area_id', 100)->nullable()->after('shipping_tracking_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_cost',
                'shipping_courier_code',
                'shipping_courier_service',
                'shipping_courier_name',
                'shipping_etd',
                'shipping_tracking_id',
                'destination_area_id',
            ]);
        });
    }
};
