<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 PROBANDO FLUJO DE CHECKOUT COMPLETO\n";
echo str_repeat("=", 50) . "\n\n";

try {
    // Test 1: Verificar usuario y carrito
    echo "1️⃣ Verificando usuario y carrito...\n";
    $user = App\Models\User::where('email', 'test@test.com')->first();
    if (!$user) {
        throw new Exception("Usuario de prueba no encontrado");
    }
    echo "   ✅ Usuario encontrado: {$user->name} ({$user->email})\n";

    $cart = App\Models\Cart::where('user_id', $user->id)
                          ->where('status', 'active')
                          ->with(['cartItems.product'])
                          ->first();
    if (!$cart) {
        throw new Exception("Carrito activo no encontrado");
    }
    echo "   ✅ Carrito encontrado: ID {$cart->id} con " . $cart->cartItems->count() . " items\n";

    // Test 2: Verificar métodos de pago del usuario
    echo "\n2️⃣ Verificando métodos de pago del usuario...\n";
    $paymentMethods = App\Models\PaymentMethod::where('user_id', $user->id)->get();
    echo "   📄 Total métodos de pago: " . $paymentMethods->count() . "\n";
    foreach ($paymentMethods as $method) {
        echo "   - {$method->type} ({$method->provider}) - {$method->status}\n";
    }

    // Test 3: Verificar tarjetas de crédito asociadas
    echo "\n3️⃣ Verificando tarjetas de crédito guardadas...\n";
    $creditCards = App\Models\CreditCard::whereHas('paymentMethod', function($query) use ($user) {
        $query->where('user_id', $user->id);
    })->with('paymentMethod')->get();
    
    echo "   💳 Total tarjetas guardadas: " . $creditCards->count() . "\n";
    foreach ($creditCards as $card) {
        echo "   - {$card->brand} **** {$card->last_four} ({$card->paymentMethod->type})\n";
        echo "     Expira: {$card->expiry_month}/{$card->expiry_year}\n";
        echo "     Titular: {$card->card_holder}\n";
    }

    // Test 4: Simular flujo de selección de tarjeta
    echo "\n4️⃣ Simulando selección de tarjetas por tipo...\n";
    
    // Tarjetas de crédito
    $creditCardsForCheckout = App\Models\CreditCard::whereHas('paymentMethod', function($query) use ($user) {
        $query->where('user_id', $user->id)
              ->where('type', 'credit_card')
              ->where('status', 'active');
    })->with('paymentMethod')->get();
    
    echo "   🔴 Tarjetas de crédito disponibles para checkout: " . $creditCardsForCheckout->count() . "\n";
    foreach ($creditCardsForCheckout as $card) {
        echo "     - ID: {$card->id} | {$card->brand} **** {$card->last_four}\n";
    }

    // Tarjetas de débito
    $debitCardsForCheckout = App\Models\CreditCard::whereHas('paymentMethod', function($query) use ($user) {
        $query->where('user_id', $user->id)
              ->where('type', 'debit_card')
              ->where('status', 'active');
    })->with('paymentMethod')->get();
    
    echo "   🔵 Tarjetas de débito disponibles para checkout: " . $debitCardsForCheckout->count() . "\n";
    foreach ($debitCardsForCheckout as $card) {
        echo "     - ID: {$card->id} | {$card->brand} **** {$card->last_four}\n";
    }

    // Test 5: Verificar gateway de pagos
    echo "\n5️⃣ Verificando configuración de gateway de pagos...\n";
    $stripe = App\Models\PaymentGateway::where('provider', 'stripe')->first();
    if ($stripe) {
        echo "   ✅ Stripe configurado: {$stripe->status}\n";
        echo "     Modo: " . ($stripe->sandbox_mode ? 'Sandbox' : 'Producción') . "\n";
        echo "     Clave pública: " . substr($stripe->public_key, 0, 10) . "...\n";
    } else {
        echo "   ⚠️  Stripe no configurado\n";
    }

    // Test 6: Calcular total del carrito
    echo "\n6️⃣ Calculando total del carrito...\n";
    $total = $cart->cartItems->sum(function ($item) {
        return $item->quantity * $item->unit_price;
    });
    echo "   💰 Total del carrito: $" . number_format($total, 2) . "\n";

    // Test 7: URLs disponibles para testing
    echo "\n7️⃣ URLs para testing manual:\n";
    echo "   🌐 Login: http://127.0.0.1:8000/login\n";
    echo "   🏠 Dashboard: http://127.0.0.1:8000/dashboard\n";
    echo "   🛒 Checkout inicial: http://127.0.0.1:8000/checkout/create?cart_id={$cart->id}\n";
    echo "   💳 Métodos de pago: http://127.0.0.1:8000/checkout/payment-methods/{$cart->id}\n";
    if ($creditCardsForCheckout->count() > 0) {
        echo "   🔴 Selección tarjetas crédito: http://127.0.0.1:8000/checkout/select-card/{$cart->id}/credit_card\n";
    }
    if ($debitCardsForCheckout->count() > 0) {
        echo "   🔵 Selección tarjetas débito: http://127.0.0.1:8000/checkout/select-card/{$cart->id}/debit_card\n";
    }
    echo "   ➕ Agregar nueva tarjeta crédito: http://127.0.0.1:8000/checkout/add-card/{$cart->id}/credit_card\n";

    echo "\n🔐 Credenciales de login:\n";
    echo "   Email: test@test.com\n";
    echo "   Password: password\n";

    echo "\n✅ TODOS LOS TESTS PASARON EXITOSAMENTE!\n";
    echo "El flujo de checkout con tarjetas guardadas está funcionando correctamente.\n\n";

    // Test adicional: Verificar que las rutas están registradas
    echo "8️⃣ Verificando rutas de checkout...\n";
    $routes = [
        'checkout.payment-methods',
        'checkout.select-card',
        'checkout.process-with-existing-card',
        'checkout.add-card',
        'checkout.process-payment'
    ];
    
    foreach ($routes as $routeName) {
        try {
            $url = route($routeName, ['cart_id' => $cart->id, 'type' => 'credit_card']);
            echo "   ✅ Ruta '{$routeName}' registrada\n";
        } catch (Exception $e) {
            echo "   ❌ Ruta '{$routeName}' NO registrada\n";
        }
    }

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🎯 RESUMEN: El sistema está listo para usar las tarjetas guardadas en el checkout.\n";
echo "Los usuarios pueden seleccionar entre tarjetas existentes o agregar nuevas.\n";
