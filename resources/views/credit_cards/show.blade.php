@extends('layouts.app')

@section('title', 'Detalles de Tarjeta de Crédito')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Detalles de Tarjeta de Crédito
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Información detallada de la tarjeta **** **** **** {{ $creditCard->last_four }}
            </p>
        </div>
        <div class="flex space-x-3 mt-4 sm:mt-0">
            <a href="{{ route('credit-cards.edit', $creditCard->id) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar Tarjeta
            </a>
            <a href="{{ route('credit-cards.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Listado
            </a>
        </div>
    </div>

    <!-- Status and Security Alerts -->
    @php
        $isExpired = now()->year > $creditCard->expiry_year || 
                    (now()->year == $creditCard->expiry_year && now()->month > $creditCard->expiry_month);
    @endphp

    @if($isExpired)
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Tarjeta Expirada</h3>
                <p class="text-sm text-red-700 dark:text-red-400 mt-1">Esta tarjeta de crédito ha expirado y no puede ser utilizada para pagos.</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Información Sensible</h3>
                <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">Por seguridad, solo se muestran los últimos 4 dígitos de la tarjeta.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Card Information -->
        <div class="lg:col-span-2">
            <!-- Credit Card Visual -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Tarjeta de Crédito</h2>
                
                <div class="relative">
                    <!-- Card Design -->
                    <div class="bg-gradient-to-r from-gray-700 via-gray-800 to-gray-900 rounded-xl p-6 text-white shadow-xl transform hover:scale-105 transition-transform duration-200" style="aspect-ratio: 1.586/1;">
                        <!-- Brand Logo -->
                        <div class="flex justify-between items-start mb-8">
                            <div class="text-2xl font-bold">
                                @switch(strtolower($creditCard->brand))
                                    @case('visa')
                                        <span class="bg-blue-600 px-3 py-1 rounded text-white text-lg">VISA</span>
                                        @break
                                    @case('mastercard')
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 bg-red-500 rounded-full mr-1"></div>
                                            <div class="w-6 h-6 bg-yellow-400 rounded-full -ml-3"></div>
                                        </div>
                                        @break
                                    @case('amex')
                                        <span class="bg-green-600 px-3 py-1 rounded text-white text-lg">AMEX</span>
                                        @break
                                    @case('discover')
                                        <span class="bg-orange-600 px-3 py-1 rounded text-white text-lg">DISCOVER</span>
                                        @break
                                    @default
                                        <span class="bg-gray-600 px-3 py-1 rounded text-white text-lg">{{ strtoupper($creditCard->brand) }}</span>
                                @endswitch
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-300">Tipo</div>
                                <div class="text-sm font-medium">Crédito</div>
                            </div>
                        </div>
                        
                        <!-- Card Number -->
                        <div class="mb-6">
                            <div class="text-2xl font-mono tracking-wider">
                                •••• •••• •••• {{ $creditCard->last_four }}
                            </div>
                        </div>
                        
                        <!-- Card Details -->
                        <div class="flex justify-between items-end">
                            <div>
                                <div class="text-xs text-gray-300 mb-1">TITULAR</div>
                                <div class="text-sm font-medium uppercase">
                                    {{ $creditCard->card_holder ?: 'No especificado' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-300 mb-1">VENCE</div>
                                <div class="text-sm font-medium">
                                    {{ sprintf('%02d', $creditCard->expiry_month) }}/{{ substr($creditCard->expiry_year, -2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Información Detallada</h2>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Últimos 4 Dígitos
                            </label>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <span class="text-lg font-mono">•••• {{ $creditCard->last_four }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Marca
                            </label>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @switch(strtolower($creditCard->brand))
                                        @case('visa')
                                            bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @break
                                        @case('mastercard')
                                            bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @break
                                        @case('amex')
                                            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @break
                                        @case('discover')
                                            bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                            @break
                                        @default
                                            bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @endswitch
                                ">
                                    {{ ucfirst($creditCard->brand) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Mes de Expiración
                            </label>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <span class="font-mono">{{ sprintf('%02d', $creditCard->expiry_month) }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Año de Expiración
                            </label>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 {{ $isExpired ? 'border border-red-300' : '' }}">
                                <span class="font-mono {{ $isExpired ? 'text-red-600 dark:text-red-400' : '' }}">
                                    {{ $creditCard->expiry_year }}
                                </span>
                                @if($isExpired)
                                    <span class="text-red-600 dark:text-red-400 text-xs ml-2">(Expirada)</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Titular de la Tarjeta
                            </label>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <span>{{ $creditCard->card_holder ?: 'No especificado' }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Token ID
                            </label>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <span class="font-mono text-sm">{{ $creditCard->token_id ?: 'No disponible' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">
            <!-- Payment Method Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Método de Pago</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Usuario
                        </label>
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $creditCard->paymentMethod->user->name ?? 'Usuario no encontrado' }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $creditCard->paymentMethod->user->email ?? '' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tipo
                        </label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                            {{ ucfirst($creditCard->paymentMethod->type ?? 'N/A') }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Proveedor
                        </label>
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $creditCard->paymentMethod->provider ?? 'No especificado' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Apodo
                        </label>
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $creditCard->paymentMethod->nickname ?? 'Sin apodo' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Estado
                        </label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($creditCard->paymentMethod->status === 'active')
                                bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @else
                                bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @endif
                        ">
                            {{ ucfirst($creditCard->paymentMethod->status ?? 'N/A') }}
                        </span>
                    </div>
                    @if($creditCard->paymentMethod->is_default)
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Método Predeterminado
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('payment-methods.show', $creditCard->paymentMethod->id) }}" 
                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-sm font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M10 6V5a2 2 0 012-2h2a2 2 0 012 2v1M10 6h4"></path>
                        </svg>
                        Ver Método de Pago
                    </a>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información del Sistema</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fecha de Registro
                        </label>
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $creditCard->created_at->format('d/m/Y H:i:s') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $creditCard->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Última Actualización
                        </label>
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $creditCard->updated_at->format('d/m/Y H:i:s') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $creditCard->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones Rápidas</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('payment-methods.index') }}" 
                       class="flex items-center justify-between p-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition duration-200">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Ver Métodos de Pago
                        </span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('users.show', $creditCard->paymentMethod->user->id ?? '#') }}" 
                       class="flex items-center justify-between p-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition duration-200">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Ver Perfil de Usuario
                        </span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('transactions.index') }}?payment_method={{ $creditCard->paymentMethod->id }}" 
                       class="flex items-center justify-between p-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition duration-200">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Ver Transacciones
                        </span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Action (Bottom) -->
    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Zona de Peligro</h3>
                    <p class="text-sm text-red-700 dark:text-red-400 mt-1">
                        Esta acción no se puede deshacer. La tarjeta de crédito será eliminada permanentemente del sistema.
                    </p>
                    <button type="button" 
                            onclick="confirmDelete()"
                            class="mt-3 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition duration-200">
                        Eliminar Tarjeta de Crédito
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <div class="mt-2 px-7 py-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center">Confirmar Eliminación</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 text-center">
                    ¿Estás seguro de que deseas eliminar la tarjeta terminada en <strong>{{ $creditCard->last_four }}</strong>?
                </p>
                <p class="text-xs text-red-600 dark:text-red-400 mt-2 text-center">
                    Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="flex gap-4 px-4 py-3">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-200">
                    Cancelar
                </button>
                <form method="POST" action="{{ route('credit-cards.destroy', $creditCard->id) }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection