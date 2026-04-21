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
        // Gunakan findOrFail agar otomatis memunculkan 404 jika produk tidak ada
        $product = Product::findOrFail($id);
        
        // Ambil produk terkait (opsional, bisa produk lain yang mirip)
        $relatedProducts = Product::where('id', '!=', $id)->inRandomOrder()->take(4)->get();

        return view('product.show', compact('product', 'relatedProducts'));
    }
}
