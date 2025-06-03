<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $fillable = [
        'movement_date',
        'movement_type_id',
        'product_id',
        'quantity',
        'unit_price',
        'order_id',
        'user_id',
        'notes',
    ];

    public function movementType(): BelongsTo
    {
        return $this->belongsTo(MovementType::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
