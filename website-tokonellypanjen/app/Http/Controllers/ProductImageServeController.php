<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;

/**
 * Serves product images with a filesystem-first strategy:
 * 1. Check if the image file exists on disk (fast)
 * 2. If not, fall back to database BLOB + auto-export to disk for next time
 * 3. Aggressive browser caching via Cache-Control headers
 */
class ProductImageServeController extends Controller
{
    /**
     * Serve a product variant image.
     */
    public function variant(ProductVariant $variant)
    {
        $extension = $this->mimeToExtension($variant->image_mime);
        $path = "products/variants/{$variant->id}.{$extension}";

        // 1. Try filesystem first (fastest path)
        if (Storage::disk('public')->exists($path)) {
            return $this->respondFromFile($path, $variant->image_mime);
        }

        // 2. Fallback: read from database
        if (!$variant->image_data) {
            abort(404);
        }

        $imageBytes = base64_decode($variant->image_data);

        // Auto-export to disk for next time
        try {
            Storage::disk('public')->put($path, $imageBytes);
        } catch (\Throwable $e) {
            // Silently fail – the image will still be served from DB
        }

        return response($imageBytes)
            ->header('Content-Type', $variant->image_mime ?? 'image/jpeg')
            ->header('Cache-Control', 'public, max-age=31536000, immutable');
    }

    /**
     * Serve a product gallery image.
     */
    public function gallery(ProductImage $image)
    {
        $extension = $this->mimeToExtension($image->image_mime);
        $path = "products/gallery/{$image->id}.{$extension}";

        // 1. Try filesystem first (fastest path)
        if (Storage::disk('public')->exists($path)) {
            return $this->respondFromFile($path, $image->image_mime);
        }

        // 2. Fallback: read from database
        if (!$image->image_data) {
            abort(404);
        }

        $imageBytes = base64_decode($image->image_data);

        // Auto-export to disk for next time
        try {
            Storage::disk('public')->put($path, $imageBytes);
        } catch (\Throwable $e) {
            // Silently fail
        }

        return response($imageBytes)
            ->header('Content-Type', $image->image_mime ?? 'image/jpeg')
            ->header('Cache-Control', 'public, max-age=31536000, immutable');
    }

    /**
     * Respond with a file from the public disk, setting aggressive cache headers.
     */
    private function respondFromFile(string $path, ?string $mime): \Symfony\Component\HttpFoundation\Response
    {
        $fullPath = Storage::disk('public')->path($path);

        return response()->file($fullPath, [
            'Content-Type' => $mime ?? 'image/jpeg',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
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
