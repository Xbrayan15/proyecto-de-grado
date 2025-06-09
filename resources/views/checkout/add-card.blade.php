@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-6 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Agregar {{ $type === 'credit_card' ? 'Tarjeta de Crédito' : 'Tarjeta de Débito' }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Ingresa los datos de tu tarjeta para completar el pago
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
                                    <a href="{{ route('checkout.payment-methods', $cart->id) }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Método de Pago</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Agregar Tarjeta</span>
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
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Card Form -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6">
                    <div class="mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-8 bg-gradient-to-r from-{{ $type === 'credit_card' ? 'blue' : 'green' }}-500 to-{{ $type === 'credit_card' ? 'blue' : 'green' }}-600 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $type === 'credit_card' ? 'Tarjeta de Crédito' : 'Tarjeta de Débito' }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Información segura y encriptada</p>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('checkout.process-payment') }}" method="POST" id="paymentForm">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                        <input type="hidden" name="payment_type" value="{{ $type }}">
                        <input type="hidden" name="brand" id="cardBrand" value="">
                        
                        <div class="space-y-6">
                            <!-- Card Number -->
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Número de Tarjeta
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="card_number" 
                                           name="card_number" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                           placeholder="1234 5678 9012 3456"
                                           maxlength="19"
                                           required>
                                    <div id="cardBrandIcon" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-8 h-5 hidden">
                                        <!-- Card brand icons will be inserted here -->
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cardholder Name -->
                            <div>
                                <label for="card_holder" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre del Titular
                                </label>
                                <input type="text" 
                                       id="card_holder" 
                                       name="card_holder" 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                       placeholder="Juan Pérez"
                                       required>
                            </div>
                            
                            <!-- Expiry Date and CVV -->
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="expiry_month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Mes
                                    </label>
                                    <select id="expiry_month" 
                                            name="expiry_month" 
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                            required>
                                        <option value="">MM</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="expiry_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Año
                                    </label>
                                    <select id="expiry_year" 
                                            name="expiry_year" 
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                            required>
                                        <option value="">YYYY</option>
                                        @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="cvv" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        CVV
                                    </label>
                                    <input type="text" 
                                           id="cvv" 
                                           name="cvv" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                           placeholder="123"
                                           maxlength="4"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Security Notice -->
                        <div class="mt-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-green-700 dark:text-green-300 font-medium">
                                    Tus datos están protegidos con encriptación SSL de 256 bits
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex space-x-4">
                            <button type="submit" 
                                    class="flex-1 bg-{{ $type === 'credit_card' ? 'blue' : 'green' }}-600 hover:bg-{{ $type === 'credit_card' ? 'blue' : 'green' }}-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center justify-center space-x-2"
                                    id="submitBtn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Procesar Pago</span>
                            </button>
                            <a href="{{ route('checkout.payment-methods', $cart->id) }}" 
                               class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium transition duration-200 text-center">
                                Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Resumen del Pedido
                    </h3>
                    
                    <div class="space-y-3">
                        @foreach($cart->cartItems as $item)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Cantidad: {{ $item->quantity }}</p>
                                </div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    ${{ number_format($item->quantity * $item->unit_price, 2) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                            <span class="text-lg font-bold text-{{ $type === 'credit_card' ? 'blue' : 'green' }}-600">
                                ${{ number_format($cart->cartItems->sum(function($item) { return $item->quantity * $item->unit_price; }), 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Payment Method Info -->
                    <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Método de Pago</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $type === 'credit_card' ? 'Tarjeta de Crédito' : 'Tarjeta de Débito' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardNumberInput = document.getElementById('card_number');
    const cardBrandInput = document.getElementById('cardBrand');
    const cardBrandIcon = document.getElementById('cardBrandIcon');
    const cvvInput = document.getElementById('cvv');
    
    // Card number formatting and brand detection
    cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        
        if (formattedValue.length <= 19) {
            e.target.value = formattedValue;
        }
        
        // Detect card brand
        const brand = detectCardBrand(value);
        cardBrandInput.value = brand;
        updateCardBrandIcon(brand);
        
        // Update CVV max length based on card type
        if (brand === 'amex') {
            cvvInput.maxLength = 4;
            cvvInput.placeholder = '1234';
        } else {
            cvvInput.maxLength = 3;
            cvvInput.placeholder = '123';
        }
    });
    
    // CVV formatting
    cvvInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^0-9]/gi, '');
    });
    
    function detectCardBrand(number) {
        const patterns = {
            visa: /^4/,
            mastercard: /^5[1-5]/,
            amex: /^3[47]/,
            discover: /^6(?:011|5)/
        };
        
        for (const [brand, pattern] of Object.entries(patterns)) {
            if (pattern.test(number)) {
                return brand;
            }
        }
        return 'other';
    }
    
    function updateCardBrandIcon(brand) {
        const icons = {
            visa: '<svg class="w-8 h-5" viewBox="0 0 48 32"><rect width="48" height="32" fill="#1A73E8" rx="4"/><text x="24" y="20" text-anchor="middle" fill="white" font-size="12" font-weight="bold">VISA</text></svg>',
            mastercard: '<svg class="w-8 h-5" viewBox="0 0 48 32"><rect width="48" height="32" fill="#FF5F00" rx="4"/><circle cx="18" cy="16" r="8" fill="#EB001B"/><circle cx="30" cy="16" r="8" fill="#F79E1B"/></svg>',
            amex: '<svg class="w-8 h-5" viewBox="0 0 48 32"><rect width="48" height="32" fill="#006FCF" rx="4"/><text x="24" y="20" text-anchor="middle" fill="white" font-size="10" font-weight="bold">AMEX</text></svg>',
            discover: '<svg class="w-8 h-5" viewBox="0 0 48 32"><rect width="48" height="32" fill="#FF6000" rx="4"/><text x="24" y="20" text-anchor="middle" fill="white" font-size="9" font-weight="bold">DISCOVER</text></svg>'
        };
        
        if (icons[brand]) {
            cardBrandIcon.innerHTML = icons[brand];
            cardBrandIcon.classList.remove('hidden');
        } else {
            cardBrandIcon.classList.add('hidden');
        }
    }
    
    // Form validation
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        const cardNumber = cardNumberInput.value.replace(/\s/g, '');
        if (cardNumber.length < 13) {
            e.preventDefault();
            alert('Por favor ingresa un número de tarjeta válido');
            return;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Procesando...';
    });
});
</script>
@endsection
