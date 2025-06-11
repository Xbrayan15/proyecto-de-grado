<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method \App\Models\Cart getActiveCart()
 * @method void ensureSingleActiveCart()
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'stripe_customer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the user's active cart. Creates one if it doesn't exist.
     */
    public function getActiveCart()
    {
        $activeCart = $this->carts()->where('status', 'active')->first();
        
        if (!$activeCart) {
            $activeCart = $this->carts()->create([
                'status' => 'active'
            ]);
        }
        
        return $activeCart;
    }

    /**
     * Ensure user has only one active cart
     */
    public function ensureSingleActiveCart()
    {
        // Mark all active carts as abandoned except the most recent one
        $activeCarts = $this->carts()->where('status', 'active')->orderBy('created_at', 'desc')->get();
        
        if ($activeCarts->count() > 1) {
            // Keep the first (most recent) cart active, abandon the rest
            $activeCarts->skip(1)->each(function ($cart) {
                $cart->update(['status' => 'abandoned']);
            });
        }
        
        // If no active cart exists, create one
        if ($activeCarts->isEmpty()) {
            $this->carts()->create(['status' => 'active']);
        }
    }

    /**
     * Check if user is a customer
     */
    public function isCustomer(): bool
    {
        return $this->user_type === 'cliente';
    }

    /**
     * Check if user is a vendor
     */
    public function isVendor(): bool
    {
        return $this->user_type === 'vendedor';
    }

    /**
     * Check if user has administrative privileges (via roles or user type)
     */
    public function isAdmin(): bool
    {
        return $this->roles()->whereIn('name', ['admin', 'manager', 'employee'])->exists() || 
               $this->isVendor();
    }
}
