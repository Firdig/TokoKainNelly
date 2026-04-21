<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * OrderItem model: a single line item within an Order.
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_variant_id
 * @property float $quantity
 * @property float $price  Price snapshot at time of purchase
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_variant_id', 'quantity', 'price'];

    /**
     * Get the product variant for this line item.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get the parent order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}