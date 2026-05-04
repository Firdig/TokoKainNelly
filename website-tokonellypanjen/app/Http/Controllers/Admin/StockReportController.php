<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman Laporan Stok (Stock Movement Log).
 * Menampilkan kronologi pergerakan stok beserta filter dan ringkasan.
 */
class StockReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        // ── 1. Ambil parameter filter ──────────────────────────────────────
        $variantId     = $request->input('product_variant_id');
        $dateFrom      = $request->input('date_from');
        $dateTo        = $request->input('date_to');
        $movementType  = $request->input('movement_type');

        // ── 2. Build query dengan filter ──────────────────────────────────
        $query = StockMovement::with([
                'productVariant.product',
                'createdBy',
            ])
            ->orderByDesc('created_at');

        if ($variantId) {
            $query->where('product_variant_id', $variantId);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($movementType) {
            $query->where('movement_type', $movementType);
        }

        // ── 3. Hitung summary (sebelum paginate agar akurat) ──────────────
        $summaryQuery  = clone $query;
        $totalKeluar   = abs((float) $summaryQuery->where('quantity', '<', 0)->sum('quantity'));

        $summaryQuery2 = StockMovement::query();
        if ($variantId)    $summaryQuery2->where('product_variant_id', $variantId);
        if ($dateFrom)     $summaryQuery2->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo)       $summaryQuery2->whereDate('created_at', '<=', $dateTo);
        if ($movementType) $summaryQuery2->where('movement_type', $movementType);
        $totalMasuk  = (float) $summaryQuery2->where('quantity', '>', 0)->sum('quantity');

        $totalCount  = StockMovement::query()
            ->when($variantId,    fn($q) => $q->where('product_variant_id', $variantId))
            ->when($dateFrom,     fn($q) => $q->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo,       fn($q) => $q->whereDate('created_at', '<=', $dateTo))
            ->when($movementType, fn($q) => $q->where('movement_type', $movementType))
            ->count();

        // ── 4. Paginate ───────────────────────────────────────────────────
        $movements = $query->paginate(25)->withQueryString();

        // ── 5. Data untuk dropdown filter ─────────────────────────────────
        // Load semua varian dengan produknya untuk dropdown
        $variants = ProductVariant::with('product')
            ->orderBy('product_id')
            ->get();

        // Daftar tipe movement untuk dropdown
        $movementTypes = [
            'sale_pos'          => 'Penjualan Kasir',
            'sale_online'       => 'Penjualan Online',
            'opname_adjustment' => 'Penyesuaian Audit',
            'manual_addition'   => 'Penambahan Manual',
            'return'            => 'Retur Barang',
        ];

        return view('admin.stock-report.index', compact(
            'movements',
            'variants',
            'movementTypes',
            'totalKeluar',
            'totalMasuk',
            'totalCount',
            'variantId',
            'dateFrom',
            'dateTo',
            'movementType',
        ));
    }
}
