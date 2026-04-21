<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * StockAudit model for recording physical stock opname results.
 * Now supports variant-level auditing for precise inventory control.
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $product_variant_id
 * @property int $auditor_id
 * @property float $system_stock
 * @property float $physical_stock
 * @property float $difference
 * @property string|null $notes
 * @property string $status
 */
class StockAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'auditor_id',
        'system_stock',
        'physical_stock',
        'difference',
        'notes',
        'status',
    ];

    /**
     * Get the parent product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the specific variant audited (nullable for legacy records).
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Get the staff member who performed the audit.
     */
    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }
}
