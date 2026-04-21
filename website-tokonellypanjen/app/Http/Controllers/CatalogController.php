<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Public catalog controller with search, filter, sort, and caching.
 * Serves the E-Commerce catalog page.
 */
class CatalogController extends Controller
{
    /**
     * Display the catalog page with search, filters, and sorted results.
     * Results are cached for 10 minutes to reduce DB load under concurrency.
     */
    public function index(Request $request)
    {
        // Build a cache key based on the current filter/sort parameters
        $cacheKey = 'catalog_' . md5($request->fullUrl());

        $products = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $query = Product::with(['variants', 'images']);

            // Search by name or description
            if ($request->filled('q')) {
                $search = $request->q;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Filter by fabric type (jenis kain)
            if ($request->filled('fabric_type')) {
                $query->filterByType($request->fabric_type);
            }

            // Filter by texture
            if ($request->filled('texture')) {
                $query->filterByTexture($request->texture);
            }

            // Filter by variant color
            if ($request->filled('color')) {
                $query->filterByColor($request->color);
            }

            // Sort options
            if ($request->filled('sort')) {
                switch ($request->sort) {
                    case 'price_asc':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderBy('price', 'desc');
                        break;
                    default:
                        $query->latest();
                        break;
                }
            } else {
                $query->latest();
            }

            return $query->paginate(12)->withQueryString();
        });

        // Get distinct fabric types and textures for filter dropdowns
        $fabricTypes = Product::whereNotNull('fabric_type')
            ->distinct()->pluck('fabric_type');
        $textures = Product::whereNotNull('texture')
            ->distinct()->pluck('texture');

        return view('katalog', compact('products', 'fabricTypes', 'textures'));
    }
}
