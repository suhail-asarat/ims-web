<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'transaction_id',
        'customer_id',
        'total_amount',
        'currency',
        'status',
        'products',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'auth_token',
        'payment_method',
        'bank_tran_id',
        'card_type',
        'store_amount',
        'admin_notes',
        'confirmed_by',
        'confirmed_at'
    ];

    protected $casts = [
        'products' => 'array',
        'total_amount' => 'decimal:2',
        'confirmed_at' => 'datetime'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getFormattedAmountAttribute()
    {
        return '৳' . number_format($this->total_amount, 2);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'confirmed_by');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'paid' => 'blue',
            'confirmed' => 'green',
            'processing' => 'indigo',
            'completed' => 'green',
            'failed' => 'red',
            'cancelled' => 'gray',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending Payment',
            'paid' => 'Payment Received',
            'confirmed' => 'Order Confirmed',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Payment Failed',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status)
        };
    }
}
