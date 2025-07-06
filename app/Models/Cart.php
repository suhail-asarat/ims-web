<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'customer_id',
        'book_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    // Relationship to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship to Book
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    // Calculate total price for this cart item
    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    // Static method to get cart items for a customer
    public static function getCartItems($customerId)
    {
        return static::with('book')
            ->where('customer_id', $customerId)
            ->get();
    }

    // Static method to get cart total for a customer
    public static function getCartTotal($customerId)
    {
        return static::where('customer_id', $customerId)
            ->sum(\DB::raw('quantity * price'));
    }

    // Static method to get cart count for a customer
    public static function getCartCount($customerId)
    {
        return static::where('customer_id', $customerId)
            ->sum('quantity');
    }
}
