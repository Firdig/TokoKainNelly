<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ProductVariant model representing a color variant of a Product.
 *
 * @property int $id
 * @property int $product_id
 * @property string $color_name
 * @property string $hex_code
 * @property float $stock
 * @property string|null $image_path
 */
class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_name',
        'hex_code',
        'stock',
        'image_path',
    ];

    /**
     * Get the parent product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get stock audit records for this variant.
     */
    public function stockAudits()
    {
        return $this->hasMany(StockAudit::class);
    }
}
