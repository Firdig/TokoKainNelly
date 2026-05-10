<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ⚠️ PENTING: Jalankan `php artisan images:export` SEBELUM menjalankan migration ini!
 * Migration ini menghapus kolom image_data (base64 BLOB) dari tabel
 * product_variants dan product_images karena gambar sekarang disimpan di filesystem.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('image_data');
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn('image_data');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->longText('image_data')->nullable()->after('image_mime');
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->longText('image_data')->nullable()->after('image_mime');
        });
    }
};
