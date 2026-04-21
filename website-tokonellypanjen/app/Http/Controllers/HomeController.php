<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (Home) E-Commerce
     */
    public function index()
    {
        // Ambil 4 produk terbaru untuk bagian "Rekomendasi / Terbaru"
        $featuredProducts = Product::latest()->take(4)->get();
        
        return view('home', compact('featuredProducts'));
    }
}
