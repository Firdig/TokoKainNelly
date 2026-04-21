<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('auditor_id')->constrained('users')->onDelete('cascade');
            $table->integer('system_stock');
            $table->integer('physical_stock');
            $table->integer('difference'); // physical_stock - system_stock
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'reconciled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_audits');
    }
};
