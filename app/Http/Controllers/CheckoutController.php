<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\OrdersPayment;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\CreditCard;
use App\Models\User;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer as StripeCustomer;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show active carts for checkout
        $carts = Cart::where('status', 'active')
                    ->where('user_id', Auth::id())
                    ->with(['cartItems.product'])
                    ->get();
        
        return view('checkout.index', compact('carts'));
    }    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Get cart_id from request
        $cartId = $request->get('cart_id');
        
        if ($cartId) {
            // Show checkout form for a specific cart
            $cart = Cart::where('id', $cartId)
                       ->where('status', 'active')
                       ->where('user_id', Auth::id())
                       ->with(['cartItems.product'])
                       ->first();
        } else {
            // Fallback to first active cart
            $cart = Cart::where('status', 'active')
                       ->where('user_id', Auth::id())
                       ->with(['cartItems.product'])
                       ->first();
        }
        
        if (!$cart) {
            return redirect()->route('carts.index')->with('error', 'Carrito no encontrado o no tienes permisos para acceder a él.');
        }        if ($cart->cartItems->isEmpty()) {
            return redirect()->route('carts.index')->with('error', 'No tienes productos en tu carrito para proceder al checkout.');
        }
          // Preload user's payment methods to avoid N+1 queries
        Auth::user()->load('paymentMethods');
        
        return view('checkout.create', compact('cart'));
    }

    /**
     * Store a newly created resource in storage.
     */    public function store(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        try {
            DB::beginTransaction();

            // Obtener carrito
            $cart = Cart::where('id', $request->cart_id)
                       ->where('user_id', Auth::id())
                       ->where('status', 'active')
                       ->with('cartItems.product')
                       ->first();

            if (!$cart) {
                throw new \Exception('Carrito no encontrado o no válido');
            }

            if ($cart->cartItems->isEmpty()) {
                throw new \Exception('El carrito está vacío');
            }

            // Calcular total usando unit_price
            $totalAmount = $cart->cartItems->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            });            // Crear orden de pago con el campo correcto
            $orderPayment = OrdersPayment::create([
                'user_id' => Auth::id(),
                'total' => $totalAmount,
                'status' => 'pending',
            ]);

            // Procesar pago con tarjeta de crédito usando Stripe
            $result = $this->processStripePayment($orderPayment, $request, $totalAmount);
            $transactionStatus = $result['status'];
            $paymentStatus = $result['status'] === 'success' ? 'paid' : 'pending';            // Crear registro de transacción
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'order_id' => $orderPayment->id,
                'payment_method_id' => $paymentMethod->id ?? null,
                'gateway_id' => 1, // Por defecto, deberías tener un gateway configurado
                'amount' => $totalAmount,
                'status' => $transactionStatus,
                'currency' => 'USD',
                'gateway_reference' => $result['stripe_payment_intent_id'] ?? 'test_' . time(),
            ]);

            // Actualizar estado del carrito solo si el pago fue exitoso
            if ($paymentStatus === 'paid') {
                $cart->update(['status' => 'purchased']);
                $orderPayment->update(['status' => 'paid']);
            } else {
                $orderPayment->update(['status' => 'pending']);
            }

            DB::commit();

            // Redirigir según el resultado
            if ($transactionStatus === 'success') {
                return redirect()->route('checkout.show', $orderPayment->id)
                               ->with('success', '¡Pago completado exitosamente! Tu orden ha sido procesada.');
            } else {
                return redirect()->route('checkout.show', $orderPayment->id)
                               ->with('info', 'Tu orden está pendiente de confirmación. Te notificaremos cuando sea procesada.');
            }        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error durante el checkout: ' . $e->getMessage())
                        ->withInput();
        }
        }

    /**
     * Display the specified resource.
     */    public function show(string $id)
    {
        // Show checkout details/confirmation
        $orderPayment = OrdersPayment::where('id', $id)
                                   ->where('user_id', Auth::id())
                                   ->with(['transactions.paymentMethod', 'transactions.gateway'])
                                   ->firstOrFail();
        
        return view('checkout.show', compact('orderPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Not typically needed for checkout
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Not typically needed for checkout
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cancel checkout/order if still pending
        $orderPayment = OrdersPayment::where('id', $id)
                                   ->where('user_id', Auth::id())
                                   ->where('status', 'pending')
                                   ->firstOrFail();
        
        $orderPayment->update(['status' => 'cancelled']);
          return redirect()->route('checkout.index')
                       ->with('success', 'Orden de pago cancelada exitosamente.');
    }

    /**
     * Mostrar selección de métodos de pago
     */
    public function paymentMethods($cart_id)
    {
        $cart = Cart::where('id', $cart_id)
                   ->where('status', 'active')
                   ->where('user_id', Auth::id())
                   ->with(['cartItems.product'])
                   ->first();
        
        if (!$cart) {
            return redirect()->route('checkout.index')->with('error', 'Carrito no encontrado.');
        }
        
        if ($cart->cartItems->isEmpty()) {
            return redirect()->route('carts.index')->with('error', 'No tienes productos en tu carrito.');
        }
        
        return view('checkout.payment-methods', compact('cart'));
    }    /**
     * Seleccionar tipo de pago y mostrar tarjetas existentes
     */
    public function selectPaymentType(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'payment_type' => 'required|in:credit_card,debit_card'
        ]);
        
        return redirect()->route('checkout.select-card', [
            'cart_id' => $request->cart_id, 
            'type' => $request->payment_type
        ]);
    }

    /**
     * Mostrar tarjetas existentes para seleccionar
     */
    public function selectCard($cart_id, $type)
    {
        $cart = Cart::where('id', $cart_id)
                   ->where('status', 'active')
                   ->where('user_id', Auth::id())
                   ->with(['cartItems.product'])
                   ->first();
        
        if (!$cart) {
            return redirect()->route('checkout.index')->with('error', 'Carrito no encontrado.');
        }
        
        if (!in_array($type, ['credit_card', 'debit_card'])) {
            return redirect()->route('checkout.payment-methods', $cart_id)
                           ->with('error', 'Tipo de pago no válido.');
        }

        // Obtener tarjetas existentes del usuario para el tipo seleccionado
        $existingCards = CreditCard::whereHas('paymentMethod', function($query) use ($type) {
            $query->where('user_id', Auth::id())
                  ->where('type', $type)
                  ->where('status', 'active');
        })->with('paymentMethod')->get();
        
        return view('checkout.select-card', compact('cart', 'type', 'existingCards'));
    }

    /**
     * Procesar pago con tarjeta existente
     */
    public function processWithExistingCard(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'payment_type' => 'required|in:credit_card,debit_card',
            'credit_card_id' => 'required|exists:credit_cards,id',
        ]);

        try {
            DB::beginTransaction();

            // Obtener carrito
            $cart = Cart::where('id', $request->cart_id)
                       ->where('user_id', Auth::id())
                       ->where('status', 'active')
                       ->with('cartItems.product')
                       ->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                throw new \Exception('Carrito no válido');
            }

            // Obtener tarjeta de crédito
            $creditCard = CreditCard::whereHas('paymentMethod', function($query) {
                $query->where('user_id', Auth::id());
            })->findOrFail($request->credit_card_id);

            // Calcular total
            $totalAmount = $cart->cartItems->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            });

            // Crear orden de pago
            $orderPayment = OrdersPayment::create([
                'user_id' => Auth::id(),
                'total' => $totalAmount,
                'status' => 'pending',
            ]);

            // Procesar pago con tarjeta existente
            $result = $this->processStripePaymentWithExistingCard($orderPayment, $creditCard, $totalAmount);
            $transactionStatus = $result['status'];
            $paymentStatus = $result['status'] === 'success' ? 'paid' : 'pending';

            // Crear transacción
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'order_id' => $orderPayment->id,
                'payment_method_id' => $creditCard->payment_method_id,
                'gateway_id' => 1, // Por defecto, deberías tener un gateway configurado
                'amount' => $totalAmount,
                'currency' => 'USD',
                'status' => $transactionStatus,
                'gateway_reference' => $result['stripe_payment_intent_id'] ?? 'test_' . time(),
            ]);

            // Actualizar estados
            if ($paymentStatus === 'paid') {
                $cart->update(['status' => 'purchased']);
                $orderPayment->update(['status' => 'paid']);
            } else {
                $orderPayment->update(['status' => 'pending']);
            }

            DB::commit();

            if ($transactionStatus === 'success') {
                return redirect()->route('checkout.show', $orderPayment->id)
                               ->with('success', '¡Pago completado exitosamente con tu tarjeta guardada!');
            } else {
                return redirect()->route('checkout.show', $orderPayment->id)
                               ->with('info', 'Tu orden está pendiente de confirmación.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error durante el pago: ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Mostrar formulario para agregar tarjeta
     */
    public function addCard($cart_id, $type)
    {
        $cart = Cart::where('id', $cart_id)
                   ->where('status', 'active')
                   ->where('user_id', Auth::id())
                   ->with(['cartItems.product'])
                   ->first();
        
        if (!$cart) {
            return redirect()->route('checkout.index')->with('error', 'Carrito no encontrado.');
        }
        
        if (!in_array($type, ['credit_card', 'debit_card'])) {
            return redirect()->route('checkout.payment-methods', $cart_id)
                           ->with('error', 'Tipo de pago no válido.');
        }
        
        return view('checkout.add-card', compact('cart', 'type'));
    }

    /**
     * Procesar pago con nueva tarjeta
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'payment_type' => 'required|in:credit_card,debit_card',
            'card_number' => 'required|string|min:13|max:19',
            'card_holder' => 'required|string|max:255',
            'expiry_month' => 'required|integer|min:1|max:12',
            'expiry_year' => 'required|integer|min:' . date('Y'),
            'cvv' => 'required|string|min:3|max:4',
            'brand' => 'required|in:visa,mastercard,amex,discover,other',
        ]);

        try {
            DB::beginTransaction();

            // Obtener carrito
            $cart = Cart::where('id', $request->cart_id)
                       ->where('user_id', Auth::id())
                       ->where('status', 'active')
                       ->with('cartItems.product')
                       ->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                throw new \Exception('Carrito no válido');
            }

            // Calcular total
            $totalAmount = $cart->cartItems->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            });

            // Crear método de pago
            $paymentMethod = PaymentMethod::create([
                'user_id' => Auth::id(),
                'type' => $request->payment_type,
                'provider' => 'stripe',
                'nickname' => substr($request->card_holder, 0, 20) . ' - ****' . substr(str_replace(' ', '', $request->card_number), -4),
                'is_default' => false,
                'status' => 'active',
            ]);

            // Crear tarjeta de crédito
            $creditCard = CreditCard::create([
                'payment_method_id' => $paymentMethod->id,
                'last_four' => substr(str_replace(' ', '', $request->card_number), -4),
                'expiry_month' => str_pad($request->expiry_month, 2, '0', STR_PAD_LEFT),
                'expiry_year' => $request->expiry_year,
                'card_holder' => $request->card_holder,
                'brand' => $request->brand,
                'token_id' => null,
            ]);

            // Crear orden de pago
            $orderPayment = OrdersPayment::create([
                'user_id' => Auth::id(),
                'total' => $totalAmount,
                'status' => 'pending',
            ]);

            // Procesar pago con Stripe
            $result = $this->processStripePaymentWithNewCard($orderPayment, $request, $totalAmount);
            $transactionStatus = $result['status'];
            $paymentStatus = $result['status'] === 'success' ? 'paid' : 'pending';

            // Crear transacción
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'order_id' => $orderPayment->id,
                'payment_method_id' => $paymentMethod->id,
                'gateway_id' => 1, // Por defecto, deberías tener un gateway configurado
                'amount' => $totalAmount,
                'currency' => 'USD',
                'status' => $transactionStatus,
                'gateway_reference' => $result['stripe_payment_intent_id'] ?? 'test_' . time(),
            ]);

            // Actualizar estados
            if ($paymentStatus === 'paid') {
                $cart->update(['status' => 'purchased']);
                $orderPayment->update(['status' => 'paid']);
            } else {
                $orderPayment->update(['status' => 'pending']);
            }

            DB::commit();

            if ($transactionStatus === 'success') {
                return redirect()->route('checkout.show', $orderPayment->id)
                               ->with('success', '¡Pago completado exitosamente!');
            } else {
                return redirect()->route('checkout.show', $orderPayment->id)
                               ->with('info', 'Tu orden está pendiente de confirmación.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error durante el pago: ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * 🔵 Procesar pago con tarjeta de crédito usando Stripe
     */
    private function processStripePaymentWithNewCard($orderPayment, $request, $totalAmount)
    {
        try {
            // Configurar Stripe con las claves del .env
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            $user = User::find(Auth::id());
            
            // Crear o obtener cliente de Stripe
            if (!$user->stripe_customer_id) {
                $stripeCustomer = StripeCustomer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
                $user->update(['stripe_customer_id' => $stripeCustomer->id]);
            }
            
            // En modo de prueba, usamos una tarjeta de prueba
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100, // Stripe usa centavos
                'currency' => 'usd',
                'customer' => $user->stripe_customer_id,
                'payment_method' => 'pm_card_visa', // Tarjeta de prueba
                'confirm' => true,
                'return_url' => route('checkout.show', $orderPayment->id),
                'metadata' => [
                    'order_payment_id' => $orderPayment->id,
                    'user_id' => $user->id,
                    'card_last_four' => substr(str_replace(' ', '', $request->card_number), -4),
                    'card_brand' => $request->brand,
                ],
            ]);
            
            return [
                'status' => 'success',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_status' => $paymentIntent->status,
                'message' => 'Pago procesado exitosamente con nueva tarjeta'
            ];
            
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'message' => 'Error al procesar el pago con nueva tarjeta'
            ];
        }
    }/**
     * 🔵 Procesar pago con tarjeta de crédito usando Stripe
     */
    private function processStripePayment($orderPayment, $request, $totalAmount)
    {
        try {
            // Configurar Stripe
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            $user = Auth::user();
            
            // Crear o obtener cliente de Stripe
            if (!$user->stripe_customer_id) {
                $stripeCustomer = StripeCustomer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
                $user->update(['stripe_customer_id' => $stripeCustomer->id]);
            }
            
            // Obtener el método de pago del usuario
            $paymentMethod = PaymentMethod::find($request->payment_method_id);
            
            // Crear PaymentIntent en Stripe (modo prueba)
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100, // Stripe usa centavos
                'currency' => 'usd',
                'customer' => $user->stripe_customer_id,
                'payment_method' => 'pm_card_visa', // Tarjeta de prueba
                'confirm' => true,
                'return_url' => route('checkout.show', $orderPayment->id),
                'metadata' => [
                    'order_payment_id' => $orderPayment->id,
                    'user_id' => $user->id,
                ],
            ]);
            
            // Actualizar o crear registro de tarjeta de crédito
            CreditCard::updateOrCreate([
                'payment_method_id' => $paymentMethod->id,
            ], [
                'stripe_payment_method_id' => 'pm_card_visa',
                'last_four' => '4242',
                'brand' => 'visa',
                'exp_month' => 12,
                'exp_year' => 2025,
                'is_default' => true,
            ]);
            
            return [
                'status' => 'success',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_status' => $paymentIntent->status,
                'message' => 'Pago procesado exitosamente con Stripe'
            ];
              } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'message' => 'Error al procesar el pago con tarjeta'
            ];
        }
    }

    /**
     * 🔵 Procesar pago con tarjeta existente usando Stripe
     */
    private function processStripePaymentWithExistingCard($orderPayment, $creditCard, $totalAmount)
    {
        try {
            // Configurar Stripe con las claves del .env
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            $user = User::find(Auth::id());
            
            // Crear o obtener cliente de Stripe
            if (!$user->stripe_customer_id) {
                $stripeCustomer = StripeCustomer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
                $user->update(['stripe_customer_id' => $stripeCustomer->id]);
            }
            
            // Crear PaymentIntent con la tarjeta existente (modo prueba)
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100, // Stripe usa centavos
                'currency' => 'usd',
                'customer' => $user->stripe_customer_id,
                'payment_method' => 'pm_card_visa', // En modo prueba, usar tarjeta de prueba
                'confirm' => true,
                'return_url' => route('checkout.show', $orderPayment->id),
                'metadata' => [
                    'order_payment_id' => $orderPayment->id,
                    'user_id' => $user->id,
                    'existing_card_id' => $creditCard->id,
                    'card_last_four' => $creditCard->last_four,
                    'card_brand' => $creditCard->brand,
                ],
            ]);
            
            return [
                'status' => 'success',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_status' => $paymentIntent->status,
                'message' => 'Pago procesado exitosamente con tarjeta existente'
            ];
            
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'message' => 'Error al procesar el pago con tarjeta existente'
            ];
        }
    }
}