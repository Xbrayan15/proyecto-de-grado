<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'provider',
        'public_key',
        'secret_key',
        'sandbox_mode',
        'webhook_config',
        'status',
    ];

    protected $casts = [
        'webhook_config' => 'array',
        'sandbox_mode' => 'boolean',
    ];
}
