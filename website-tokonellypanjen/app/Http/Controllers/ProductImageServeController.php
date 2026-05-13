<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;

/**
 * Serves product images from the filesystem.
 * Images are stored in storage/app/public/products/{variants|gallery}/.
 */
class ProductImageServeController extends Controller
{
    /**
     * Serve a product variant image from the filesystem.
     */
    public function variant($id)
    {
        $path = $this->findImagePath('products/variants', $id, null);

        if (!$path) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path), [
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    /**
     * Serve a product gallery image from the filesystem.
     */
    public function gallery($id)
    {
        $path = $this->findImagePath('products/gallery', $id, null);

        if (!$path) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path), [
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    /**
     * Find the image file on disk. Tries the expected extension first,
     * then falls back to checking common extensions.
     */
    private function findImagePath(string $directory, int $id, ?string $mime): ?string
    {
        // Try expected extension first
        $ext = $this->mimeToExtension($mime);
        $path = "{$directory}/{$id}.{$ext}";
        if (Storage::disk('public')->exists($path)) {
            return $path;
        }

        // Fallback: try other common extensions
        foreach (['jpg', 'png', 'webp', 'gif'] as $fallbackExt) {
            $fallbackPath = "{$directory}/{$id}.{$fallbackExt}";
            if (Storage::disk('public')->exists($fallbackPath)) {
                return $fallbackPath;
            }
        }

        return null;
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
