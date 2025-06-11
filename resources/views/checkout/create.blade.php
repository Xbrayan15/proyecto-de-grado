@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-6 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Finalizar Compra
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Revisa tu pedido y selecciona el método de pago
                    </p>
                    <!-- Breadcrumb -->
                    <nav class="flex mt-3" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L9 5.414V17a1 1 0 102 0V5.414l5.293 5.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <a href="{{ route('checkout.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Checkout</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Pagar</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
            @csrf
            <input type="hidden" name="cart_id" value="{{ $cart->id }}">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Summary -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Cart Items -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M8 11v6h8v-6M8 11H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2"/>
                                </svg>
                                Resumen del Pedido
                            </h3>                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Carrito #{{ $cart->id }} - {{ $cart->cartItems ? $cart->cartItems->count() : 0 }} productos
                            </p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($cart->cartItems as $item)
                                    <div class="flex items-center space-x-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" 
                                                     class="w-16 h-16 rounded-lg object-cover">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Product Info -->
                                        <div class="flex-1">
                                            <h4 class="text-base font-medium text-gray-900 dark:text-white">
                                                {{ $item->product->name ?? 'Producto eliminado' }}
                                            </h4>
                                            @if($item->product)
                                                <p class="text-sm text-gray-600 dark:text-gray-400">Código: {{ $item->product->code }}</p>
                                            @endif
                                            <div class="flex items-center mt-2 space-x-4">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    Cantidad: <span class="font-medium">{{ $item->quantity }}</span>
                                                </span>
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    Precio: <span class="font-medium">${{ number_format($item->unit_price, 2) }}</span>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Subtotal -->
                                        <div class="text-right">
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                ${{ number_format($item->quantity * $item->unit_price, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>                    <!-- Payment Method Selection -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Método de Pago
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Selecciona tu tarjeta de crédito para pagar
                            </p>
                        </div>
                        <div class="p-6">
                            @if(auth()->user()->paymentMethods && auth()->user()->paymentMethods->count() > 0)
                                <div class="space-y-3">
                                    @foreach(auth()->user()->paymentMethods as $paymentMethod)
                                        <label class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <input type="radio" name="payment_method_id" value="{{ $paymentMethod->id }}" 
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white flex items-center">
                                                            💳 {{ $paymentMethod->type ?? 'Tarjeta de Crédito' }}
                                                        </p>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                                            {{ $paymentMethod->description ?? 'Pago seguro con Stripe' }}
                                                        </p>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        @if($paymentMethod->is_default)
                                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                                Por defecto
                                                            </span>
                                                        @endif
                                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                
                                <!-- Stripe Security Badge -->
                                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                                Powered by Stripe
                                            </p>
                                            <p class="text-xs text-blue-700 dark:text-blue-300">
                                                Tus datos de pago están protegidos con encriptación de nivel bancario
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">No hay métodos de pago</h3>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Debes agregar una tarjeta de crédito antes de continuar.
                                    </p>
                                    <div class="mt-4">
                                        <a href="{{ route('payment-methods.create') }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                            Agregar Tarjeta de Crédito
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Total & Actions -->
                <div class="space-y-6">
                    <!-- Total Summary -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Resumen Total</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    ${{ number_format($cart->cartItems->sum(function($item) { return $item->quantity * $item->unit_price; }), 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Impuestos:</span>
                                <span class="font-medium text-gray-900 dark:text-white">$0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Envío:</span>
                                <span class="font-medium text-green-600">Gratis</span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                                    <span class="text-lg font-bold text-blue-600">
                                        ${{ number_format($cart->cartItems->sum(function($item) { return $item->quantity * $item->unit_price; }), 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Security Badge -->
                        <div class="mt-6 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-green-700 dark:text-green-300 font-medium">Pago 100% seguro</span>
                            </div>
                        </div>
                    </div>                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <a href="{{ route('checkout.payment-methods', $cart->id) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold text-lg transition duration-200 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Seleccionar Método de Pago</span>
                        </a>
                        
                        <a href="{{ route('checkout.index') }}" 
                           class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium text-center transition duration-200 block">
                            Volver al Checkout
                        </a>
                        
                        <a href="{{ route('carts.show', $cart->id) }}" 
                           class="w-full bg-gray-50 hover:bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-medium text-center transition duration-200 block">
                            Editar Carrito
                        </a>
                    </div>

                    <!-- Help Info -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">
                            ¿Necesitas ayuda?
                        </h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            Si tienes problemas con tu pago o preguntas sobre tu pedido, contacta a nuestro equipo de soporte.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Form submission handling
    form.addEventListener('submit', function() {
        // Add loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Procesando pago...
        `;
    });
});
</script>
@endpush
@endsection
