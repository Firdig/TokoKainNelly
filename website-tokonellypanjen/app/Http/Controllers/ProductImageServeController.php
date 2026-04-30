<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Response;

class ProductImageServeController extends Controller
{
    /**
     * Serve a product variant image from the database.
     */
    public function variant(ProductVariant $variant)
    {
        if (!$variant->image_data) {
            abort(404);
        }

        $image = \Illuminate\Support\Facades\Cache::remember('img_v_'.$variant->id, 86400, function() use ($variant) {
            return base64_decode($variant->image_data);
        });

        return response($image)
            ->header('Content-Type', $variant->image_mime ?? 'image/jpeg')
            ->header('Cache-Control', 'public, max-age=31536000');
    }

    /**
     * Serve a product gallery image from the database.
     */
    public function gallery(ProductImage $image)
    {
        if (!$image->image_data) {
            abort(404);
        }

        $decodedImage = \Illuminate\Support\Facades\Cache::remember('img_g_'.$image->id, 86400, function() use ($image) {
            return base64_decode($image->image_data);
        });

        return response($decodedImage)
            ->header('Content-Type', $image->image_mime ?? 'image/jpeg')
            ->header('Cache-Control', 'public, max-age=31536000');
    }
}
