<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductFrontController extends Controller
{
    /**
     * Tampilkan halaman Detail Produk secara lengkap
     */
    public function show($id)
    {
        // Eager-load variants & images so they are available in the view
        $product = Product::with(['variants', 'images'])->findOrFail($id);
        
        // Ambil produk terkait (opsional, bisa produk lain yang mirip)
        $relatedProducts = Product::with(['variants', 'images'])
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('product.show', compact('product', 'relatedProducts'));
    }
}
