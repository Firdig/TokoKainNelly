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
        // 1. Add new columns
        Schema::table('product_variants', function (Blueprint $table) {
            $table->longText('image_data')->nullable();
            $table->string('image_mime')->nullable();
        });

        // 2. Migrate existing files to base64 in chunks to prevent memory exhaustion
        \Illuminate\Support\Facades\DB::table('product_variants')
            ->whereNotNull('image_path')
            ->chunkById(50, function ($variants) {
                foreach ($variants as $variant) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($variant->image_path)) {
                        $path = \Illuminate\Support\Facades\Storage::disk('public')->path($variant->image_path);
                        
                        // Check file size to avoid loading massive files (optional safeguard)
                        if (filesize($path) < 10485760) { // skip if > 10MB
                            $mime = mime_content_type($path);
                            $data = base64_encode(file_get_contents($path));
            
                            \Illuminate\Support\Facades\DB::table('product_variants')
                                ->where('id', $variant->id)
                                ->update([
                                    'image_data' => $data,
                                    'image_mime' => $mime,
                                ]);
                            
                            // Free memory explicitly
                            unset($data, $mime, $path);
                        }
                    }
                }
            });

        // 3. Drop old column
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('image_path')->nullable();
            $table->dropColumn(['image_data', 'image_mime']);
        });
    }
};
