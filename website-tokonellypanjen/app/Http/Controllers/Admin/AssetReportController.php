<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class AssetReportController extends Controller
{
    public function index()
    {
        $totalAssets = ProductVariant::join('products', 'product_variants.product_id', '=', 'products.id')
            ->sum(DB::raw('product_variants.stock * products.price'));

        $products = Product::with('variants', 'category')
            ->get()
            ->map(function ($product) {
                $product->total_stock = $product->variants->sum('stock');
                $product->asset_value = $product->total_stock * $product->price;
                return $product;
            })
            ->sortByDesc('asset_value');

        $categoryAssets = $products->groupBy(fn($p) => $p->category?->name ?? 'Tanpa Kategori')
            ->map(function ($items, $categoryName) {
                return [
                    'name' => $categoryName,
                    'product_count' => $items->count(),
                    'total_stock' => $items->sum('total_stock'),
                    'asset_value' => $items->sum('asset_value'),
                ];
            })
            ->sortByDesc('asset_value')
            ->values();

        return view('admin.asset-report.index', compact('totalAssets', 'products', 'categoryAssets'));
    }
}
