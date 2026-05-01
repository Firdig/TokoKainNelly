<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * StockMovement model — log terpusat pergerakan stok.
 *
 * Setiap kali stok berkurang (penjualan) atau bertambah (adjustment),
 * satu record dibuat di sini untuk keperluan audit dan laporan.
 *
 * @property int         $id
 * @property int         $product_variant_id
 * @property string      $movement_type       'sale_pos'|'sale_online'|'opname_adjustment'|'manual_addition'|'return'
 * @property float       $quantity            Negatif = keluar, Positif = masuk
 * @property float       $stock_before
 * @property float       $stock_after
 * @property string|null $reference_type      'order'|'stock_audit'|null
 * @property int|null    $reference_id
 * @property string|null $notes
 * @property int|null    $created_by
 */
class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'movement_type',
        'quantity',
        'stock_before',
        'stock_after',
        'reference_type',
        'reference_id',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity'    => 'double',
        'stock_before' => 'double',
        'stock_after'  => 'double',
    ];

    // ─────────────────────────────────────────────
    // Relasi
    // ─────────────────────────────────────────────

    /**
     * Varian produk yang stoknya bergerak.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * User yang memicu pergerakan stok (bisa null untuk sistem/publik).
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Resolve referensi ke Order jika reference_type = 'order'.
     */
    public function referenceOrder()
    {
        if ($this->reference_type === 'order' && $this->reference_id) {
            return Order::find($this->reference_id);
        }
        return null;
    }

    // ─────────────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────────────

    /** Filter berdasarkan tipe movement. */
    public function scopeOfType($query, string $type)
    {
        return $query->where('movement_type', $type);
    }

    /** Hanya pergerakan stok masuk (quantity positif). */
    public function scopeIncoming($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /** Hanya pergerakan stok keluar (quantity negatif). */
    public function scopeOutgoing($query)
    {
        return $query->where('quantity', '<', 0);
    }

    // ─────────────────────────────────────────────
    // Helper: Label & Warna untuk View
    // ─────────────────────────────────────────────

    /**
     * Label bahasa Indonesia untuk movement_type.
     */
    public function getTypeLabel(): string
    {
        return match($this->movement_type) {
            'sale_pos'          => 'Penjualan Kasir',
            'sale_online'       => 'Penjualan Online',
            'opname_adjustment' => 'Penyesuaian Audit',
            'manual_addition'   => 'Penambahan Manual',
            'return'            => 'Retur Barang',
            default             => ucfirst($this->movement_type),
        };
    }

    /**
     * Warna badge CSS (Tailwind) untuk movement_type.
     */
    public function getTypeBadgeColor(): string
    {
        return match($this->movement_type) {
            'sale_pos'          => 'bg-blue-100 text-blue-700',
            'sale_online'       => 'bg-purple-100 text-purple-700',
            'opname_adjustment' => 'bg-yellow-100 text-yellow-700',
            'manual_addition'   => 'bg-green-100 text-green-700',
            'return'            => 'bg-orange-100 text-orange-700',
            default             => 'bg-slate-100 text-slate-700',
        };
    }
}
