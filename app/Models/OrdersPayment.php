<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdersPayment extends Model
{
    protected $table = 'orders_payments';
    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }

    // Get the payment method from the first transaction
    public function getPaymentMethodAttribute()
    {
        return $this->transactions->first()?->paymentMethod;
    }
}
