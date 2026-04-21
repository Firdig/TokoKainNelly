<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockOpnameRequest;
use App\Models\Product;
use App\Models\StockAudit;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Auth;

/**
 * Admin controller for Stock Opname (physical stock auditing).
 * Now operates at the variant level for accurate inventory control.
 */
class StockOpnameController extends Controller
{
    public function __construct(
        private readonly InventoryService $inventoryService
    ) {}

    /**
     * Display the stock opname form with all products and their variants.
     */
    public function index()
    {
        $products = Product::with('variants')->orderBy('name')->get();

        $recentAudits = StockAudit::with(['product', 'productVariant', 'auditor'])
            ->latest()
            ->take(20)
            ->get();

        return view('admin.stock-opname.index', compact('products', 'recentAudits'));
    }

    /**
     * Process the stock opname form submission.
     * Delegates to InventoryService for variant-level reconciliation.
     */
    public function store(StockOpnameRequest $request)
    {
        $hasUpdates = $this->inventoryService->performStockOpname(
            audits: $request->validated('audits'),
            auditorId: Auth::id()
        );

        if ($hasUpdates) {
            return redirect()->back()
                ->with('success', 'Stock Opname berhasil! Selisih stok telah dicatat dan diperbarui ke sistem pusat.');
        }

        return redirect()->back()
            ->with('info', 'Tidak ada data stok fisik yang tersubmit atau diubah.');
    }
}
