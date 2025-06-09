@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-6 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Seleccionar Método de Pago
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Elige el tipo de tarjeta para proceder con el pago
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
                                    <a href="{{ route('checkout.create', ['cart_id' => $cart->id]) }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Checkout</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Método de Pago</span>
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

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Payment Method Selection -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        Selecciona tu Método de Pago
                    </h3>
                    
                    <form action="{{ route('checkout.select-payment-type') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                        
                        <div class="space-y-4">
                            <!-- Credit Card Option -->
                            <div class="relative">
                                <input type="radio" id="credit_card" name="payment_type" value="credit_card" class="sr-only" checked>
                                <label for="credit_card" class="flex items-center p-6 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-300 dark:hover:border-blue-500 transition-colors duration-200 group">
                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-md flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Tarjeta de Crédito</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Visa, Mastercard, American Express</p>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded-full group-hover:border-blue-500 transition-colors duration-200">
                                            <div class="w-3 h-3 bg-blue-600 rounded-full m-0.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Debit Card Option -->
                            <div class="relative">
                                <input type="radio" id="debit_card" name="payment_type" value="debit_card" class="sr-only">
                                <label for="debit_card" class="flex items-center p-6 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-green-300 dark:hover:border-green-500 transition-colors duration-200 group">
                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-8 bg-gradient-to-r from-green-500 to-green-600 rounded-md flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Tarjeta de Débito</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Pago directo desde tu cuenta bancaria</p>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded-full group-hover:border-green-500 transition-colors duration-200">
                                            <div class="w-3 h-3 bg-green-600 rounded-full m-0.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mt-8 flex space-x-4">
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span>Continuar</span>
                            </button>
                            <a href="{{ route('checkout.create', ['cart_id' => $cart->id]) }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium transition duration-200 text-center">
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
                            <span class="text-lg font-bold text-blue-600">
                                ${{ number_format($cart->cartItems->sum(function($item) { return $item->quantity * $item->unit_price; }), 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('input[name="payment_type"]');
    const labels = document.querySelectorAll('label');
    
    radioButtons.forEach((radio, index) => {
        radio.addEventListener('change', function() {
            labels.forEach(label => {
                label.classList.remove('border-blue-500', 'border-green-500', 'bg-blue-50', 'bg-green-50');
                label.classList.add('border-gray-200');
                const dot = label.querySelector('.w-3.h-3');
                if (dot) dot.classList.add('opacity-0');
            });
            
            if (this.checked) {
                const currentLabel = labels[index];
                const colorClass = this.value === 'credit_card' ? 'blue' : 'green';
                currentLabel.classList.remove('border-gray-200');
                currentLabel.classList.add(`border-${colorClass}-500`, `bg-${colorClass}-50`);
                const dot = currentLabel.querySelector('.w-3.h-3');
                if (dot) dot.classList.remove('opacity-0');
            }
        });
    });
    
    // Trigger initial state
    const checkedRadio = document.querySelector('input[name="payment_type"]:checked');
    if (checkedRadio) {
        checkedRadio.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
