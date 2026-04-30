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
        Schema::table('product_images', function (Blueprint $table) {
            $table->longText('image_data')->nullable();
            $table->string('image_mime')->nullable();
        });

        // 2. Migrate existing files to base64 in chunks to prevent memory exhaustion
        \Illuminate\Support\Facades\DB::table('product_images')
            ->whereNotNull('image_path')
            ->chunkById(50, function ($images) {
                foreach ($images as $image) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($image->image_path)) {
                        $path = \Illuminate\Support\Facades\Storage::disk('public')->path($image->image_path);
                        
                        if (filesize($path) < 10485760) { // skip if > 10MB
                            $mime = mime_content_type($path);
                            $data = base64_encode(file_get_contents($path));
            
                            \Illuminate\Support\Facades\DB::table('product_images')
                                ->where('id', $image->id)
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
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->string('image_path')->nullable();
            $table->dropColumn(['image_data', 'image_mime']);
        });
    }
};
