<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add fabric_type column for catalog filtering by jenis kain.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('fabric_type', 100)->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('fabric_type');
        });
    }
};
