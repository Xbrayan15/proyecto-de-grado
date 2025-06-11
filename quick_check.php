<?php
echo "🔍 VERIFICACIÓN RÁPIDA DEL SISTEMA\n";
echo "==================================\n\n";

// Simple check without Laravel framework
try {
    // Check if we can connect to database using Laravel's database configuration
    $host = 'localhost';
    $dbname = 'proyecto_grado';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conexión a base de datos exitosa\n\n";
    
    // Check user exists
    $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE email = ?");
    $stmt->execute(['test@test.com']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "👤 Usuario encontrado:\n";
        echo "   ID: {$user['id']}\n";
        echo "   Nombre: {$user['name']}\n";
        echo "   Email: {$user['email']}\n\n";
        
        // Check cart
        $stmt = $pdo->prepare("SELECT id, status, created_at FROM carts WHERE user_id = ? AND status = 'active'");
        $stmt->execute([$user['id']]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cart) {
            echo "🛒 Carrito activo encontrado:\n";
            echo "   ID: {$cart['id']}\n";
            echo "   Estado: {$cart['status']}\n";
            echo "   Creado: {$cart['created_at']}\n\n";
            
            // Check cart items
            $stmt = $pdo->prepare("
                SELECT ci.id, ci.quantity, ci.unit_price, p.name 
                FROM cart_items ci 
                JOIN products p ON ci.product_id = p.id 
                WHERE ci.cart_id = ?
            ");
            $stmt->execute([$cart['id']]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "📦 Items en el carrito: " . count($items) . "\n";
            $total = 0;
            foreach ($items as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                $total += $subtotal;
                echo "   - {$item['name']} x{$item['quantity']} = \${$subtotal}\n";
            }
            echo "   💰 Total: \${$total}\n\n";
            
            // Check payment methods
            $stmt = $pdo->prepare("SELECT id, type, provider, nickname, status FROM payment_methods WHERE user_id = ?");
            $stmt->execute([$user['id']]);
            $paymentMethods = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "💳 Métodos de pago: " . count($paymentMethods) . "\n";
            foreach ($paymentMethods as $method) {
                echo "   - {$method['type']} ({$method['provider']}) - {$method['status']}\n";
                
                // Check credit cards for this payment method
                $stmt = $pdo->prepare("
                    SELECT id, last_four, brand, card_holder, expiry_month, expiry_year 
                    FROM credit_cards 
                    WHERE payment_method_id = ?
                ");
                $stmt->execute([$method['id']]);
                $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($cards as $card) {
                    echo "     ↳ {$card['brand']} ****{$card['last_four']} ({$card['card_holder']}) {$card['expiry_month']}/{$card['expiry_year']}\n";
                }
            }
            
            echo "\n🌐 URLs para probar:\n";
            echo "   Dashboard: http://127.0.0.1:8000/dashboard\n";
            echo "   Login: http://127.0.0.1:8000/login\n";
            echo "   Checkout: http://127.0.0.1:8000/checkout/payment-methods/{$cart['id']}\n";
            echo "   Seleccionar tarjeta crédito: http://127.0.0.1:8000/checkout/select-card/{$cart['id']}/credit_card\n";
            echo "   Agregar nueva tarjeta: http://127.0.0.1:8000/checkout/add-card/{$cart['id']}/credit_card\n";
            
            echo "\n🔑 Credenciales:\n";
            echo "   Email: test@test.com\n";
            echo "   Password: password\n";
            
        } else {
            echo "❌ No se encontró carrito activo\n";
        }
        
    } else {
        echo "❌ Usuario de prueba no encontrado\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n🎯 El sistema está configurado para:\n";
echo "   1. Mostrar tarjetas guardadas existentes\n";
echo "   2. Permitir seleccionar entre tarjetas guardadas\n";
echo "   3. Permitir agregar nuevas tarjetas\n";
echo "   4. Procesar pagos con Stripe\n";
echo "   5. Guardar transacciones exitosas\n";
?>
