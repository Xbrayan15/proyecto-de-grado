<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🚀 Creando datos de prueba para checkout...\n\n";

try {
    // 1. Crear usuario de prueba si no existe
    $user = App\Models\User::firstOrCreate(
        ['email' => 'test@test.com'],
        [
            'name' => 'Usuario Test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]
    );
    echo "✅ Usuario creado/encontrado: {$user->name} ({$user->email})\n";

    // 2. Crear categoría si no existe
    $category = App\Models\Category::firstOrCreate(
        ['name' => 'Electrónicos'],
        ['description' => 'Productos electrónicos de prueba']
    );
    echo "✅ Categoría creada/encontrada: {$category->name}\n";

    // 3. Crear proveedor si no existe
    $supplier = App\Models\Supplier::firstOrCreate(
        ['name' => 'TechSupplier'],
        [
            'contact_email' => 'supplier@tech.com',
            'phone' => '555-0123',
            'address' => 'Tech Street 123'
        ]
    );
    echo "✅ Proveedor creado/encontrado: {$supplier->name}\n";    // 4. Crear productos de prueba
    $products = [
        [
            'name' => 'Smartphone Premium',
            'code' => 'SPH-001',
            'description' => 'Smartphone de última generación',
            'price' => 899.99,
            'quantity' => 50
        ],
        [
            'name' => 'Laptop Gaming',
            'code' => 'LPT-002',
            'description' => 'Laptop para gaming de alto rendimiento',
            'price' => 1299.99,
            'quantity' => 25
        ],
        [
            'name' => 'Auriculares Bluetooth',
            'code' => 'AUR-003',
            'description' => 'Auriculares inalámbricos con cancelación de ruido',
            'price' => 199.99,
            'quantity' => 100
        ]
    ];

    $productModels = [];
    foreach ($products as $productData) {
        $product = App\Models\Product::firstOrCreate(
            ['code' => $productData['code']],
            [
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'quantity' => $productData['quantity'],
                'category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'active' => true
            ]
        );
        $productModels[] = $product;
        echo "✅ Producto creado/encontrado: {$product->name} - \${$product->price}\n";
    }

    // 5. Crear carrito con productos
    $cart = App\Models\Cart::firstOrCreate(
        [
            'user_id' => $user->id,
            'status' => 'active'
        ]
    );
    echo "✅ Carrito creado/encontrado para usuario: {$user->name}\n";

    // 6. Agregar items al carrito
    foreach ($productModels as $index => $product) {
        $cartItem = App\Models\CartItem::firstOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id
            ],
            [
                'quantity' => $index + 1, // 1, 2, 3 items respectively
                'unit_price' => $product->price
            ]
        );
        echo "✅ Item agregado al carrito: {$product->name} (Cantidad: {$cartItem->quantity})\n";
    }

    // 7. Crear gateway de pago
    $gateway = App\Models\PaymentGateway::firstOrCreate(
        ['provider' => 'stripe'],
        [
            'public_key' => env('STRIPE_KEY', 'pk_test_example'),
            'secret_key' => env('STRIPE_SECRET', 'sk_test_example'),
            'sandbox_mode' => true,
            'status' => 'active'
        ]
    );
    echo "✅ Gateway de pago creado/encontrado: {$gateway->provider}\n";

    // 8. Calcular total del carrito
    $total = $cart->cartItems->sum(function($item) {
        return $item->quantity * $item->unit_price;
    });

    echo "\n📊 RESUMEN DEL CARRITO:\n";
    echo "Usuario: {$user->name}\n";
    echo "Total de items: {$cart->cartItems->count()}\n";
    echo "Total a pagar: \${$total}\n";
    echo "Cart ID: {$cart->id}\n";

    echo "\n🎯 URLs para probar:\n";
    echo "1. Dashboard: http://127.0.0.1:8000/dashboard\n";
    echo "2. Checkout directo: http://127.0.0.1:8000/checkout/create?cart_id={$cart->id}\n";
    echo "3. Métodos de pago: http://127.0.0.1:8000/checkout/payment-methods/{$cart->id}\n";

    echo "\n🔐 Credenciales de login:\n";
    echo "Email: test@test.com\n";
    echo "Password: password\n";

    echo "\n✅ ¡Datos de prueba creados exitosamente!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
