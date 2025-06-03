@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('refunds.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Reembolso #{{ $refund->id }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Modifica los detalles del reembolso existente</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('refunds.show', $refund) }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md font-medium transition duration-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>Ver Detalles</span>
            </a>
        </div>
    </div>

    <!-- Status Warning -->
    @if($refund->status === 'completed')
    <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                    Reembolso Completado
                </h3>
                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                    <p>Este reembolso ya fue completado. Los cambios pueden afectar los registros contables. Procede con precaución.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Información del Reembolso</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Actualiza los detalles del reembolso</p>
        </div>
        
        <form method="POST" action="{{ route('refunds.update', $refund) }}" class="p-6" id="refundEditForm">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Transaction Selection -->
                <div class="col-span-1 md:col-span-2">
                    <label for="transaction_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Transacción *
                        </span>
                    </label>
                    <div class="relative">
                        <select name="transaction_id" id="transaction_id" required 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('transaction_id') border-red-500 @enderror">
                            <option value="">Seleccionar transacción</option>
                            @foreach($transactions->where('status', 'success') as $transaction)
                                <option value="{{ $transaction->id }}" 
                                        {{ old('transaction_id', $refund->transaction_id) == $transaction->id ? 'selected' : '' }}
                                        data-amount="{{ $transaction->amount }}" 
                                        data-currency="{{ $transaction->currency }}"
                                        data-user="{{ $transaction->user->name ?? 'Sin usuario' }}"
                                        data-gateway="{{ $transaction->gateway_reference }}">
                                    #{{ $transaction->id }} - {{ $transaction->currency }} ${{ number_format($transaction->amount, 2) }} - {{ $transaction->user->name ?? 'Sin usuario' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('transaction_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Solo se muestran transacciones exitosas</p>
                </div>

                <!-- Amount -->
                <div class="col-span-1">
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Monto a Reembolsar *
                        </span>
                    </label>
                    <input type="number" name="amount" id="amount" step="0.01" min="0" required
                           value="{{ old('amount', $refund->amount) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('amount') border-red-500 @enderror"
                           placeholder="0.00">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" id="amountHelper">Monto máximo disponible</p>
                </div>

                <!-- Currency -->
                <div class="col-span-1">
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Moneda *
                        </span>
                    </label>
                    <select name="currency" id="currency" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('currency') border-red-500 @enderror">
                        <option value="">Seleccionar moneda</option>
                        <option value="USD" {{ old('currency', $refund->currency) == 'USD' ? 'selected' : '' }}>USD - Dólar Estadounidense</option>
                        <option value="EUR" {{ old('currency', $refund->currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="COP" {{ old('currency', $refund->currency) == 'COP' ? 'selected' : '' }}>COP - Peso Colombiano</option>
                    </select>
                    @error('currency')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reason -->
                <div class="col-span-1">
                    <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Razón del Reembolso *
                        </span>
                    </label>
                    <select name="reason" id="reason" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('reason') border-red-500 @enderror">
                        <option value="">Seleccionar razón</option>
                        <option value="customer_request" {{ old('reason', $refund->reason) == 'customer_request' ? 'selected' : '' }}>
                            👤 Solicitud del cliente
                        </option>
                        <option value="duplicate" {{ old('reason', $refund->reason) == 'duplicate' ? 'selected' : '' }}>
                            🔄 Transacción duplicada
                        </option>
                        <option value="fraudulent" {{ old('reason', $refund->reason) == 'fraudulent' ? 'selected' : '' }}>
                            ⚠️ Actividad fraudulenta
                        </option>
                        <option value="product_issue" {{ old('reason', $refund->reason) == 'product_issue' ? 'selected' : '' }}>
                            📦 Problema con el producto
                        </option>
                    </select>
                    @error('reason')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-span-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Estado del Reembolso
                        </span>
                    </label>
                    <div class="relative">
                        <select name="status" id="status" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('status') border-red-500 @enderror">
                            <option value="pending" {{ old('status', $refund->status) == 'pending' ? 'selected' : '' }}>
                                🕐 Pendiente
                            </option>
                            <option value="completed" {{ old('status', $refund->status) == 'completed' ? 'selected' : '' }}>
                                ✅ Completado
                            </option>
                            <option value="failed" {{ old('status', $refund->status) == 'failed' ? 'selected' : '' }}>
                                ❌ Fallido
                            </option>
                        </select>
                    </div>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Processed By -->
                <div class="col-span-1">
                    <label for="processed_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Procesado por
                        </span>
                    </label>
                    <select name="processed_by" id="processed_by" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('processed_by') border-red-500 @enderror">
                        <option value="">Sin asignar</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('processed_by', $refund->processed_by) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('processed_by')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gateway Reference -->
                <div class="col-span-1">
                    <label for="gateway_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Referencia del Gateway
                        </span>
                    </label>
                    <input type="text" name="gateway_reference" id="gateway_reference"
                           value="{{ old('gateway_reference', $refund->gateway_reference) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('gateway_reference') border-red-500 @enderror"
                           placeholder="Ej: REF_123456789">
                    @error('gateway_reference')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Referencia del reembolso en el gateway</p>
                </div>

                <!-- Completed At -->
                <div class="col-span-1">
                    <label for="completed_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Fecha de Completado
                        </span>
                    </label>
                    <input type="datetime-local" name="completed_at" id="completed_at"
                           value="{{ old('completed_at', $refund->completed_at ? $refund->completed_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('completed_at') border-red-500 @enderror">
                    @error('completed_at')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Fecha y hora cuando se completó el reembolso</p>
                </div>

                <!-- Notes -->
                <div class="col-span-1 md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Notas Adicionales
                        </span>
                    </label>
                    <textarea name="notes" id="notes" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('notes') border-red-500 @enderror"
                              placeholder="Añade cualquier información adicional sobre el reembolso...">{{ old('notes', $refund->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Información adicional para el procesamiento</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                <a href="{{ route('refunds.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Volver a lista</span>
                </a>
                
                <div class="flex items-center space-x-3">
                    <button type="button" onclick="location.reload()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                        Restablecer
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-200 flex items-center space-x-2" id="submitBtn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        <span>Actualizar Reembolso</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Transaction History -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Historial del Reembolso</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-blue-400 rounded-full mt-2"></div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">Reembolso creado</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $refund->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
                
                @if($refund->updated_at != $refund->created_at)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">Última actualización</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $refund->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
                @endif
                
                @if($refund->completed_at)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-green-400 rounded-full mt-2"></div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">Reembolso completado</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $refund->completed_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Acciones Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <a href="{{ route('transactions.show', $refund->transaction) }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span>Ver Transacción</span>
            </a>
            <a href="{{ route('refunds.show', $refund) }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Ver Detalles</span>
            </a>
            <a href="{{ route('refunds.create') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Nuevo Reembolso</span>
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const transactionSelect = document.getElementById('transaction_id');
    const amountInput = document.getElementById('amount');
    const currencySelect = document.getElementById('currency');
    const amountHelper = document.getElementById('amountHelper');
    const statusSelect = document.getElementById('status');
    const completedAtInput = document.getElementById('completed_at');
    const form = document.getElementById('refundEditForm');
    
    // Handle transaction selection change
    transactionSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const maxAmount = selectedOption.dataset.amount;
            const currency = selectedOption.dataset.currency;
            
            amountInput.max = maxAmount;
            currencySelect.value = currency;
            amountHelper.textContent = `Monto máximo disponible: ${currency} $${parseFloat(maxAmount).toFixed(2)}`;
        } else {
            amountInput.max = '';
            amountHelper.textContent = 'Monto máximo disponible';
        }
    });

    // Handle status change to auto-set completed_at
    statusSelect.addEventListener('change', function() {
        if (this.value === 'completed' && !completedAtInput.value) {
            const now = new Date();
            const formattedDate = now.toISOString().slice(0, 16);
            completedAtInput.value = formattedDate;
        }
    });

    // Validation for amount vs transaction amount
    amountInput.addEventListener('input', function() {
        const selectedTransaction = transactionSelect.options[transactionSelect.selectedIndex];
        if (selectedTransaction.value) {
            const maxAmount = parseFloat(selectedTransaction.dataset.amount);
            const currentAmount = parseFloat(this.value);
            
            if (currentAmount > maxAmount) {
                this.setCustomValidity(`El monto no puede ser mayor a ${selectedTransaction.dataset.currency} $${maxAmount.toFixed(2)}`);
            } else {
                this.setCustomValidity('');
            }
        }
    });

    // Confirmation for completed refunds
    if (document.querySelector('.bg-yellow-50')) {
        form.addEventListener('submit', function(e) {
            if (!confirm('¿Estás seguro de que deseas modificar este reembolso completado? Los cambios pueden afectar los registros contables.')) {
                e.preventDefault();
            }
        });
    }

    // Initialize on page load
    transactionSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection
