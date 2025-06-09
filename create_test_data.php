<?php

// Script para crear datos de prueba para el checkout con tarjetas de crédito
require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

// Cargar Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "💳 Creando datos de prueba para checkout con tarjetas de crédito...\n\n";

// 1. Buscar o crear usuario
$user = User::first();
if (!$user) {
    $user = User::create([
        'name' => 'Usuario de Prueba',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);
    echo "✅ Usuario creado: {$user->email}\n";
} else {
    echo "✅ Usuario encontrado: {$user->email}\n";
}

// 2. Crear métodos de pago para tarjetas de crédito
$creditCardMethods = [
    [
        'user_id' => $user->id,
        'type' => 'credit_card',
        'description' => 'Visa **** 4242',
        'is_default' => true,
        'is_active' => true,
    ],
    [
        'user_id' => $user->id,
        'type' => 'credit_card',
        'description' => 'Mastercard **** 5555',
        'is_default' => false,
        'is_active' => true,
    ]
];

foreach ($creditCardMethods as $methodData) {
    $existingMethod = PaymentMethod::where('user_id', $user->id)
                                  ->where('description', $methodData['description'])
                                  ->first();
    
    if (!$existingMethod) {
        PaymentMethod::create($methodData);
        echo "✅ Tarjeta de crédito creada: {$methodData['description']}\n";
    } else {
        echo "✅ Tarjeta de crédito ya existe: {$methodData['description']}\n";
    }
}

// 3. Crear productos si no existen
$products = [
    [
        'name' => 'Laptop HP Pavilion',
        'code' => 'HP-PAV-001',
        'price' => 899.99,
        'description' => 'Laptop HP Pavilion 15" con procesador Intel i5',
        'stock' => 50,
        'is_active' => true,
    ],
    [
        'name' => 'Mouse Logitech MX',
        'code' => 'LOG-MX-001',
        'price' => 79.99,
        'description' => 'Mouse inalámbrico Logitech MX Master 3',
        'stock' => 25,
        'is_active' => true,
    ],
    [
        'name' => 'Teclado Mecánico RGB',
        'code' => 'KEY-RGB-001',
        'price' => 129.99,
        'description' => 'Teclado mecánico RGB con switches azules',
        'stock' => 15,
        'is_active' => true,
    ]
];

foreach ($products as $productData) {
    $existingProduct = Product::where('code', $productData['code'])->first();
    
    if (!$existingProduct) {
        Product::create($productData);
        echo "✅ Producto creado: {$productData['name']}\n";
    } else {
        echo "✅ Producto ya existe: {$productData['name']}\n";
    }
}

// 4. Crear carrito de prueba
$cart = Cart::where('user_id', $user->id)->where('status', 'active')->first();

if (!$cart) {
    $cart = Cart::create([
        'user_id' => $user->id,
        'status' => 'active',
    ]);
    echo "✅ Carrito creado: #{$cart->id}\n";
} else {
    echo "✅ Carrito encontrado: #{$cart->id}\n";
}

// 5. Agregar productos al carrito
$products = Product::take(3)->get();

foreach ($products as $product) {
    $existingItem = CartItem::where('cart_id', $cart->id)
                           ->where('product_id', $product->id)
                           ->first();
    
    if (!$existingItem) {
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => rand(1, 3),
            'unit_price' => $product->price,
        ]);
        echo "✅ Producto agregado al carrito: {$product->name}\n";
    } else {
        echo "✅ Producto ya está en el carrito: {$product->name}\n";
    }
}

$total = $cart->cartItems()->sum(\DB::raw('quantity * unit_price'));

echo "\n🎉 ¡Datos de prueba creados exitosamente!\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "👤 Email: test@example.com\n";
echo "🔐 Password: password\n";
echo "🛒 Carrito ID: {$cart->id}\n";
echo "💳 Tarjetas disponibles: " . PaymentMethod::where('user_id', $user->id)->count() . "\n";
echo "📦 Productos en carrito: " . CartItem::where('cart_id', $cart->id)->count() . "\n";
echo "💰 Total del carrito: $" . number_format($total, 2) . "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "🔗 URL de prueba: http://localhost:8000/checkout/create?cart_id={$cart->id}\n";
echo "🌐 URL login: http://localhost:8000/login\n";
