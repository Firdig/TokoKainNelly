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
        Schema::table('products', function (Blueprint $table) {
            $table->string('texture')->nullable()->after('description'); // e.g., Lembut, Kasar
            $table->tinyInteger('comfort_level')->default(5)->after('texture'); // e.g., 1-5 indicating comfort
            $table->unsignedBigInteger('branch_id')->default(1)->after('id'); // e.g., 1 = Kepanjen
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['texture', 'comfort_level', 'branch_id']);
        });
    }
};
