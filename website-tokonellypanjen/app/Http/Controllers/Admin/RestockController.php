<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestockController extends Controller
{
    /**
     * Tampilkan form penerimaan stok.
     */
    public function index()
    {
        // Load semua produk beserta variannya untuk dropdown
        $products = Product::with('variants')->orderBy('name')->get();
        return view('admin.restock.index', compact('products'));
    }

    /**
     * Proses penerimaan stok.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity'           => 'required|numeric|min:0.1',
            'notes'              => 'nullable|string|max:255',
        ], [
            'product_variant_id.required' => 'Silakan pilih varian produk.',
            'quantity.required'           => 'Jumlah stok wajib diisi.',
            'quantity.min'                => 'Jumlah stok minimal 0.1 meter.',
        ]);

        DB::transaction(function () use ($request) {
            $variant = ProductVariant::where('id', $request->product_variant_id)
                ->lockForUpdate()
                ->firstOrFail();

            $quantityAdded = $request->quantity;
            $stockBefore = $variant->stock;
            $stockAfter = $stockBefore + $quantityAdded;

            // 1. Update jumlah stok varian
            $variant->update(['stock' => $stockAfter]);

            // 2. Catat pergerakan stok sebagai Penambahan Manual
            StockMovement::create([
                'product_variant_id' => $variant->id,
                'movement_type'      => 'manual_addition',
                'quantity'           => $quantityAdded,
                'stock_before'       => $stockBefore,
                'stock_after'        => $stockAfter,
                'notes'              => $request->notes,
                'created_by'         => Auth::id(),
            ]);
        });

        return redirect()->back()
            ->with('success', 'Stok berhasil ditambahkan. Laporan pergerakan stok telah diperbarui.');
    }
}
