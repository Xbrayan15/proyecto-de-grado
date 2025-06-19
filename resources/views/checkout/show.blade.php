@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-6 py-8">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/20 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent mb-2">
                ¡Orden Creada Exitosamente!
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Tu orden de pago ha sido procesada y está siendo verificada
            </p>
        </div>

        <!-- Breadcrumb -->
        <nav class="flex mb-8 justify-center" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('checkout.index') }}" class="text-gray-500 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Checkout
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-600 font-medium ml-1 md:ml-2">Confirmación</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="max-w-4xl mx-auto">
            <!-- Order Status Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-green-500 to-blue-500 px-6 py-4">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <h3 class="text-lg font-semibold">Orden #{{ $orderPayment->id }}</h3>
                            <p class="text-green-100">{{ $orderPayment->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold">${{ number_format($orderPayment->total, 2) }}</div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($orderPayment->status === 'completed') bg-green-100 text-green-800
                                @elseif($orderPayment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($orderPayment->status === 'failed') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                <div class="w-2 h-2 rounded-full mr-2
                                    @if($orderPayment->status === 'completed') bg-green-400
                                    @elseif($orderPayment->status === 'pending') bg-yellow-400
                                    @elseif($orderPayment->status === 'failed') bg-red-400
                                    @else bg-gray-400 @endif"></div>
                                {{ ucfirst($orderPayment->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Estado de la Orden</h4>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Orden creada <span class="font-medium text-gray-900 dark:text-white">{{ $orderPayment->created_at->format('d/m/Y H:i') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            @if($orderPayment->status === 'pending')
                            <li class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Procesando pago <span class="font-medium text-yellow-600">En progreso...</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @elseif($orderPayment->status === 'completed')
                            <li class="relative">
                                <div class="relative flex space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Pago completado <span class="font-medium text-green-600">{{ $orderPayment->updated_at->format('d/m/Y H:i') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @elseif($orderPayment->status === 'failed')
                            <li class="relative">
                                <div class="relative flex space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Pago falló <span class="font-medium text-red-600">{{ $orderPayment->updated_at->format('d/m/Y H:i') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Payment Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Información de Pago
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Método de Pago</h4>
                                    @if($orderPayment->paymentMethod)
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                @if($orderPayment->paymentMethod->type === 'credit_card')
                                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                    </svg>
                                                @elseif($orderPayment->paymentMethod->type === 'digital_wallet')
                                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">
                                                    {{ $orderPayment->paymentMethod->nickname ?? ucfirst(str_replace('_', ' ', $orderPayment->paymentMethod->type)) }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $orderPayment->paymentMethod->provider ?? 'Proveedor no especificado' }}
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400">Método de pago no disponible</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Detalles de Transacción</h4>
                                    @if($orderPayment->transactions->count() > 0)
                                        @foreach($orderPayment->transactions as $transaction)
                                            <div class="space-y-1">
                                                <p class="text-sm text-gray-900 dark:text-white">
                                                    <span class="font-medium">ID:</span> {{ $transaction->gateway_reference }}
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    <span class="font-medium">Estado:</span> 
                                                    <span class="@if($transaction->status === 'success') text-green-600 @elseif($transaction->status === 'pending') text-yellow-600 @else text-red-600 @endif">
                                                        {{ ucfirst($transaction->status) }}
                                                    </span>
                                                </p>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Transacción en proceso</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    @if($orderPayment->order_details)
                        @php
                            $orderDetails = json_decode($orderPayment->order_details, true);
                        @endphp
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    Productos Pedidos
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ count($orderDetails) }} producto(s) en esta orden
                                </p>
                            </div>
                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($orderDetails as $item)
                                    <div class="p-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            
                                            <div class="flex-grow">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                                            {{ $item['product_name'] }}
                                                        </h4>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                                            Cantidad: {{ $item['quantity'] }} × ${{ number_format($item['unit_price'], 2) }}
                                                        </p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                            ${{ number_format($item['total_price'], 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Resumen de la Orden</h3>
                        
                        <div class="space-y-3">                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                <span class="font-medium text-gray-900 dark:text-white">${{ number_format($orderPayment->total, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Impuestos:</span>
                                <span class="font-medium text-gray-900 dark:text-white">$0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Envío:</span>
                                <span class="font-medium text-gray-900 dark:text-white">Gratis</span>
                            </div>
                            <hr class="border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                                <span class="text-lg font-bold text-green-600">${{ number_format($orderPayment->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">¿Qué sigue?</h3>
                        
                        <div class="space-y-4">
                            @if($orderPayment->status === 'pending')
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Procesando pago</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">Tu pago está siendo verificado</p>
                                    </div>
                                </div>
                            @elseif($orderPayment->status === 'completed')
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-2 h-2 bg-green-400 rounded-full mt-2"></div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Orden confirmada</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">Tu orden está siendo preparada</p>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-gray-300 rounded-full mt-2"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Notificación por email</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Recibirás actualizaciones por correo</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('orders-payments.show', $orderPayment->id) }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-center transition duration-200 block">
                                Ver Detalles Completos
                            </a>
                            
                            <a href="{{ route('checkout.index') }}" 
                               class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-medium text-center transition duration-200 block">
                                Nueva Compra
                            </a>
                            
                            <a href="{{ route('carts.index') }}" 
                               class="w-full bg-gray-50 hover:bg-gray-100 text-gray-600 px-4 py-2 rounded-lg font-medium text-center transition duration-200 block">
                                Ver Mis Carritos
                            </a>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">¿Necesitas ayuda?</h4>
                                <p class="text-xs text-blue-600 dark:text-blue-300 mt-1">
                                    Si tienes problemas con tu orden, contáctanos para asistencia.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($orderPayment->status === 'pending')
<script>
// Auto-refresh for pending orders
setInterval(function() {
    fetch(window.location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(data => {
        // Check if status has changed
        const parser = new DOMParser();
        const doc = parser.parseFromString(data, 'text/html');
        const newStatus = doc.querySelector('[data-order-status]');
        const currentStatus = document.querySelector('[data-order-status]');
        
        if (newStatus && currentStatus && newStatus.textContent !== currentStatus.textContent) {
            location.reload();
        }
    })
    .catch(error => console.error('Auto-refresh error:', error));
}, 10000); // Check every 10 seconds
</script>
@endif
@endsection
