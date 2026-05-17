<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add fabric weight fields to products table.
 *
 * - weight_value: numeric weight value (e.g., 200, 300)
 * - weight_unit: unit of measurement — 'gsm' (gram per square meter) or 'gpy' (gram per yard)
 *
 * These are used by the Biteship API to calculate shipping rates.
 * The actual shipping weight is calculated at checkout time based on
 * the fabric width, quantity ordered, and weight specification.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('weight_value')->default(200)->after('fabric_care');
            $table->string('weight_unit', 10)->default('gsm')->after('weight_value');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight_value', 'weight_unit']);
        });
    }
};
