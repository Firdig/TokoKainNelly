<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * CartItem model: a single item in a shopping cart.
 *
 * @property int $id
 * @property int $cart_id
 * @property int $product_variant_id
 * @property float $quantity
 * @property float $price
 */
class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_variant_id',
        'quantity',
        'price',
    ];

    /**
     * Get the parent cart.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product variant for this cart item.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
