<?php

namespace App\Console\Commands;

use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Artisan command to export product images from database BLOB storage
 * to the local filesystem for faster serving.
 *
 * Usage: php artisan images:export
 */
class ExportImagesFromDb extends Command
{
    protected $signature = 'images:export {--force : Overwrite existing files}';
    protected $description = 'Export product images from database (base64) to filesystem for faster serving';

    public function handle(): int
    {
        $this->info('Exporting product images from database to filesystem...');

        $variantCount = $this->exportVariantImages();
        $galleryCount = $this->exportGalleryImages();

        $this->newLine();
        $this->info("✅ Done! Exported {$variantCount} variant images and {$galleryCount} gallery images.");
        $this->info('💡 Make sure to run: php artisan storage:link');

        return self::SUCCESS;
    }

    private function exportVariantImages(): int
    {
        $force = $this->option('force');
        $count = 0;

        // Only select records that have image data
        $variants = ProductVariant::whereNotNull('image_data')
            ->where('image_data', '!=', '')
            ->select(['id', 'image_data', 'image_mime'])
            ->cursor(); // Use cursor for memory efficiency

        foreach ($variants as $variant) {
            $extension = $this->mimeToExtension($variant->image_mime);
            $path = "products/variants/{$variant->id}.{$extension}";

            if (!$force && Storage::disk('public')->exists($path)) {
                $this->line("  ⏭  Variant #{$variant->id} already exists, skipping.");
                continue;
            }

            try {
                $imageData = base64_decode($variant->image_data);
                if ($imageData === false) {
                    $this->warn("  ⚠  Variant #{$variant->id}: failed to decode base64 data.");
                    continue;
                }

                Storage::disk('public')->put($path, $imageData);
                $count++;
                $this->line("  ✓  Variant #{$variant->id} exported ({$path})");
            } catch (\Exception $e) {
                $this->error("  ✗  Variant #{$variant->id}: {$e->getMessage()}");
            }
        }

        return $count;
    }

    private function exportGalleryImages(): int
    {
        $force = $this->option('force');
        $count = 0;

        $images = ProductImage::whereNotNull('image_data')
            ->where('image_data', '!=', '')
            ->select(['id', 'image_data', 'image_mime'])
            ->cursor();

        foreach ($images as $image) {
            $extension = $this->mimeToExtension($image->image_mime);
            $path = "products/gallery/{$image->id}.{$extension}";

            if (!$force && Storage::disk('public')->exists($path)) {
                $this->line("  ⏭  Gallery #{$image->id} already exists, skipping.");
                continue;
            }

            try {
                $imageData = base64_decode($image->image_data);
                if ($imageData === false) {
                    $this->warn("  ⚠  Gallery #{$image->id}: failed to decode base64 data.");
                    continue;
                }

                Storage::disk('public')->put($path, $imageData);
                $count++;
                $this->line("  ✓  Gallery #{$image->id} exported ({$path})");
            } catch (\Exception $e) {
                $this->error("  ✗  Gallery #{$image->id}: {$e->getMessage()}");
            }
        }

        return $count;
    }

    private function mimeToExtension(?string $mime): string
    {
        return match ($mime) {
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg',
            default => 'jpg',
        };
    }
}
