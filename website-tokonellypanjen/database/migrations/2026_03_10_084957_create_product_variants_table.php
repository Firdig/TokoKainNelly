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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('color_name'); // e.g., "Abu Muda", "Jet Black"
            $table->string('hex_code')->nullable(); // e.g., "#C0C0C0" for the color selector UI
            $table->integer('stock')->default(0); // This variant's specific physical stock
            $table->string('image_path')->nullable(); // Specific image for this color
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
