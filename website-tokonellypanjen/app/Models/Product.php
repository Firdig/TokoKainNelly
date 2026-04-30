<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product model representing a fabric/textile item.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $fabric_type    Jenis kain (e.g., katun, sutra, polyester)
 * @property float $price
 * @property string|null $texture
 * @property int|null $comfort_level
 * @property int $branch_id
 * @property string|null $width
 * @property string|null $composition
 * @property string|null $fabric_care
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'fabric_type',
        'price',
        'texture',
        'comfort_level',
        'branch_id',
        'width',
        'composition',
        'fabric_care',
    ];

    /**
     * Get the color variants of this product.
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->select(['id', 'product_id', 'color_name', 'hex_code', 'stock', 'image_mime', 'created_at', 'updated_at']);
    }

    /**
     * Get the gallery images for this product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->select(['id', 'product_id', 'image_mime', 'created_at', 'updated_at']);
    }

    /**
     * Computed attribute: total stock across all variants.
     * Accessible via $product->stock
     */
    public function getStockAttribute()
    {
        return $this->variants()->sum('stock');
    }

    /**
     * Scope: filter by fabric type (jenis kain).
     */
    public function scopeFilterByType($query, ?string $type)
    {
        if ($type) {
            return $query->where('fabric_type', $type);
        }
        return $query;
    }

    /**
     * Scope: filter by texture.
     */
    public function scopeFilterByTexture($query, ?string $texture)
    {
        if ($texture) {
            return $query->where('texture', 'like', '%' . $texture . '%');
        }
        return $query;
    }

    /**
     * Scope: filter by variant color name.
     */
    public function scopeFilterByColor($query, ?string $color)
    {
        if ($color) {
            return $query->whereHas('variants', function ($q) use ($color) {
                $q->where('color_name', 'like', '%' . $color . '%');
            });
        }
        return $query;
    }
}