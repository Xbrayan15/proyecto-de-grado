<?php

use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cart checkout process works correctly', function () {
    // Create a user
    $user = User::factory()->create();
    
    // Create a payment method
    $paymentMethod = PaymentMethod::factory()->create();
    
    // Create a product
    $product = Product::factory()->create([
        'name' => 'Test Product',
        'price' => 100.00,
        'stock_quantity' => 10
    ]);
    
    // Create a cart
    $cart = Cart::create([
        'user_id' => $user->id,
        'status' => 'active'
    ]);
    
    // Add item to cart using the cartItems relationship
    $cartItem = CartItem::create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'quantity' => 2,
        'unit_price' => $product->price
    ]);
    
    // Test that cartItems relationship works
    expect($cart->cartItems)->toHaveCount(1);
    expect($cart->cartItems->first()->product->name)->toBe('Test Product');
    
    // Test that the count() method works on cartItems (this was the original error)
    expect($cart->cartItems->count())->toBe(1);
    
    // Test the backwards compatibility with items relationship
    expect($cart->items)->toHaveCount(1);
    expect($cart->items->count())->toBe(1);
    
    // Test checkout process
    $response = $this->actingAs($user)->get('/checkout');
    $response->assertStatus(200);
    
    // Test cart total calculation
    $total = $cart->cartItems->sum(function ($item) {
        return $item->quantity * $item->unit_price;
    });
    expect($total)->toBe(200.00);
});

test('checkout fails gracefully with empty cart', function () {
    $user = User::factory()->create();
    
    // Create empty cart
    $cart = Cart::create([
        'user_id' => $user->id,
        'status' => 'active'
    ]);
    
    // Test that cartItems count is 0
    expect($cart->cartItems->count())->toBe(0);
    
    // Test checkout with empty cart
    $response = $this->actingAs($user)->get('/checkout/create');
    $response->assertRedirect('/carts')
             ->assertSessionHas('error');
});

test('cart relationships work correctly after fix', function () {
    $user = User::factory()->create();
    
    $cart = Cart::create([
        'user_id' => $user->id,
        'status' => 'active'
    ]);
    
    // Test that both relationship methods exist and work
    expect($cart->cartItems())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    expect($cart->items())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    
    // Test that they return the same results
    expect($cart->cartItems->count())->toBe($cart->items->count());
});
