<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Order model representing a sales transaction.
 * Supports E-Commerce (delivery/BOPS) and POS transactions.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $invoice_number
 * @property string $transaction_type  'pos', 'bops', or 'delivery'
 * @property string $status            'pending', 'ready_for_pickup', 'shipped', 'completed', 'cancelled'
 * @property float $total_amount
 * @property string|null $pickup_code
 * @property \Carbon\Carbon|null $estimated_pickup_at
 * @property string|null $customer_name
 * @property string|null $customer_phone
 * @property string|null $delivery_address
 * @property string|null $payment_method
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'transaction_type',
        'status',
        'total_amount',
        'pickup_code',
        'estimated_pickup_at',
        'customer_name',
        'customer_phone',
        'delivery_address',
        'payment_method',
    ];

    /**
     * Attribute type casting for proper data handling.
     */
    protected $casts = [
        'total_amount'         => 'decimal:2',
        'estimated_pickup_at'  => 'datetime',
    ];

    /**
     * Get the customer who placed this order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the line items for this order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope: filter by transaction type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('transaction_type', $type);
    }

    /**
     * Scope: filter by status.
     */
    public function scopeOfStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}