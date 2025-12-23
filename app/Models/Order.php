<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'subtotal',
        'shipping_cost',
        'total',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'city',
        'province',
        'postal_code',
        'total_weight',
        'shipping_weight',
        'customer_notes',
        'admin_notes',
        'verified_by',
        'verified_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'total_weight' => 'integer',
        'shipping_weight' => 'integer',
        'verified_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper methods
    public function isPendingPayment(): bool
    {
        return $this->status === 'pending_payment';
    }

    public function isPendingVerification(): bool
    {
        return $this->status === 'pending_verification';
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isShipped(): bool
    {
        return $this->status === 'shipped';
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending_payment', 'pending_verification']);
    }

    public function canBeVerified(): bool
    {
        return $this->status === 'pending_verification' && $this->payment;
    }

    public function getTotalProfit(): float
    {
        return $this->items->sum(function ($item) {
            return ($item->price - $item->cost_price) * $item->quantity;
        });
    }
}