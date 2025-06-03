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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Crear Nuevo Reembolso</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Procesa un reembolso para una transacción</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Información del Reembolso</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Complete todos los campos obligatorios</p>
        </div>
        
        <form method="POST" action="{{ route('refunds.store') }}" class="p-6" id="refundForm">
            @csrf
            
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
                                        {{ old('transaction_id', request('transaction_id')) == $transaction->id ? 'selected' : '' }}
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
                           value="{{ old('amount') }}"
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
                        <option value="USD" {{ old('currency', 'USD') == 'USD' ? 'selected' : '' }}>USD - Dólar Estadounidense</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="COP" {{ old('currency') == 'COP' ? 'selected' : '' }}>COP - Peso Colombiano</option>
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
                        <option value="customer_request" {{ old('reason') == 'customer_request' ? 'selected' : '' }}>
                            👤 Solicitud del cliente
                        </option>
                        <option value="duplicate" {{ old('reason') == 'duplicate' ? 'selected' : '' }}>
                            🔄 Transacción duplicada
                        </option>
                        <option value="fraudulent" {{ old('reason') == 'fraudulent' ? 'selected' : '' }}>
                            ⚠️ Actividad fraudulenta
                        </option>
                        <option value="product_issue" {{ old('reason') == 'product_issue' ? 'selected' : '' }}>
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
                        Estado del Reembolso
                    </label>
                    <div class="relative">
                        <select name="status" id="status" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('status') border-red-500 @enderror">
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                                🕐 Pendiente
                            </option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                ✅ Completado
                            </option>
                            <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>
                                ❌ Fallido
                            </option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Estado inicial del reembolso</p>
                </div>

                <!-- Processed By -->
                <div class="col-span-1">
                    <label for="processed_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Procesado por (Opcional)
                        </span>
                    </label>
                    <select name="processed_by" id="processed_by" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('processed_by') border-red-500 @enderror">
                        <option value="">Sin asignar</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('processed_by', auth()->id()) == $user->id ? 'selected' : '' }}>
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
                            Referencia del Gateway (Opcional)
                        </span>
                    </label>
                    <input type="text" name="gateway_reference" id="gateway_reference"
                           value="{{ old('gateway_reference') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('gateway_reference') border-red-500 @enderror"
                           placeholder="Ej: REF_123456789">
                    @error('gateway_reference')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Referencia del reembolso en el gateway</p>
                </div>

                <!-- Notes -->
                <div class="col-span-1 md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Notas Adicionales (Opcional)
                        </span>
                    </label>
                    <textarea name="notes" id="notes" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('notes') border-red-500 @enderror"
                              placeholder="Añade cualquier información adicional sobre el reembolso...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Información adicional para el procesamiento</p>
                </div>

                <!-- Information Card -->
                <div class="col-span-1 md:col-span-2">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                    Información importante
                                </h3>
                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>El monto del reembolso no puede exceder el monto de la transacción original</li>
                                        <li>Solo se pueden procesar reembolsos para transacciones exitosas</li>
                                        <li>Los reembolsos completados no pueden modificarse posteriormente</li>
                                        <li>Se recomienda incluir una referencia del gateway para seguimiento</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <button type="button" id="resetForm" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                        Limpiar
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-200 flex items-center space-x-2" id="submitBtn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Crear Reembolso</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Transaction Details Card -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden" id="transactionDetails" style="display: none;">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detalles de la Transacción Seleccionada</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="transactionInfo">
                <!-- Transaction details will be populated here -->
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Acciones Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <a href="{{ route('transactions.index') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span>Ver Transacciones</span>
            </a>
            <a href="{{ route('payment-gateways.index') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <span>Gestionar Gateways</span>
            </a>
            <a href="{{ route('audit-logs-payments.index') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Logs de Auditoría</span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('refundForm');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetForm');
    const transactionSelect = document.getElementById('transaction_id');
    const amountInput = document.getElementById('amount');
    const currencySelect = document.getElementById('currency');
    const transactionDetails = document.getElementById('transactionDetails');
    const transactionInfo = document.getElementById('transactionInfo');
    const amountHelper = document.getElementById('amountHelper');

    // Form validation
    function validateForm() {
        const isValid = transactionSelect.value !== '' && 
                       amountInput.value !== '' &&
                       currencySelect.value !== '' &&
                       document.getElementById('reason').value !== '';
        
        submitBtn.disabled = !isValid;
        submitBtn.classList.toggle('opacity-50', !isValid);
        submitBtn.classList.toggle('cursor-not-allowed', !isValid);
        
        return isValid;
    }

    // Update transaction details and auto-fill fields
    transactionSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            const amount = selectedOption.getAttribute('data-amount');
            const currency = selectedOption.getAttribute('data-currency');
            const user = selectedOption.getAttribute('data-user');
            const gateway = selectedOption.getAttribute('data-gateway');
            
            // Auto-fill amount and currency
            amountInput.value = parseFloat(amount).toFixed(2);
            currencySelect.value = currency;
            
            // Update amount helper
            amountHelper.textContent = `Monto máximo: ${currency} $${parseFloat(amount).toFixed(2)}`;
            amountInput.setAttribute('max', amount);
            
            // Show transaction details
            transactionInfo.innerHTML = `
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuario</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">${user}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Original</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">${currency} $${parseFloat(amount).toFixed(2)}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Referencia Gateway</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">${gateway}</dd>
                </div>
            `;
            transactionDetails.style.display = 'block';
            
            validateForm();
        } else {
            amountInput.value = '';
            currencySelect.value = '';
            amountHelper.textContent = 'Monto máximo disponible';
            amountInput.removeAttribute('max');
            transactionDetails.style.display = 'none';
            validateForm();
        }
    });

    // Amount validation
    amountInput.addEventListener('input', function() {
        const maxAmount = this.getAttribute('max');
        if (maxAmount && parseFloat(this.value) > parseFloat(maxAmount)) {
            this.value = maxAmount;
        }
        validateForm();
    });

    // Real-time validation
    const requiredFields = ['transaction_id', 'amount', 'currency', 'reason'];
    requiredFields.forEach(fieldId => {
        document.getElementById(fieldId).addEventListener('change', validateForm);
        document.getElementById(fieldId).addEventListener('input', validateForm);
    });
    
    // Initial validation
    validateForm();

    // Reset form
    resetBtn.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas limpiar el formulario?')) {
            form.reset();
            currencySelect.value = 'USD';
            document.getElementById('status').value = 'pending';
            document.getElementById('processed_by').value = '{{ auth()->id() }}';
            transactionDetails.style.display = 'none';
            amountHelper.textContent = 'Monto máximo disponible';
            amountInput.removeAttribute('max');
            validateForm();
        }
    });

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            alert('Por favor, completa todos los campos obligatorios.');
            return false;
        }

        const maxAmount = amountInput.getAttribute('max');
        if (maxAmount && parseFloat(amountInput.value) > parseFloat(maxAmount)) {
            e.preventDefault();
            alert('El monto del reembolso no puede exceder el monto de la transacción original.');
            return false;
        }

        // Add loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Creando...
        `;
    });

    // Auto-generate gateway reference if empty when status is completed
    document.getElementById('status').addEventListener('change', function() {
        const gatewayRefInput = document.getElementById('gateway_reference');
        if (this.value === 'completed' && !gatewayRefInput.value) {
            const timestamp = Date.now();
            const random = Math.floor(Math.random() * 1000);
            gatewayRefInput.value = `REF_${timestamp}_${random}`;
        }
    });

    // Pre-select transaction from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const preselectedTransaction = urlParams.get('transaction_id');
    if (preselectedTransaction && transactionSelect.querySelector(`option[value="${preselectedTransaction}"]`)) {
        transactionSelect.value = preselectedTransaction;
        transactionSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
