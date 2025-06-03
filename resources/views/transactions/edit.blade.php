@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Transacción #{{ $transaction->id }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Modifica los detalles de la transacción</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('transactions.show', $transaction) }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md font-medium transition duration-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>Ver Detalle</span>
            </a>
        </div>
    </div>

    <!-- Transaction Status Alert -->
    @if($transaction->status === 'success')
    <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                    Transacción Exitosa
                </h3>
                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                    <p>Esta transacción fue procesada exitosamente. Ten cuidado al modificar los datos ya que esto podría afectar los registros financieros.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Información de la Transacción</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Modifica los campos necesarios</p>
        </div>
        
        <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="p-6" id="transactionForm">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order Selection -->
                <div class="col-span-1 md:col-span-2">
                    <label for="order_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Orden de Pago *
                        </span>
                    </label>
                    <div class="relative">
                        <select name="order_id" id="order_id" required 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('order_id') border-red-500 @enderror">
                            <option value="">Seleccionar orden de pago</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" 
                                        {{ old('order_id', $transaction->order_id) == $order->id ? 'selected' : '' }}
                                        data-total="{{ $order->total }}" data-user="{{ $order->user->name ?? 'Sin usuario' }}">
                                    Orden #{{ $order->id }} - ${{ number_format($order->total, 2) }} - {{ $order->user->name ?? 'Sin usuario' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('order_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Orden de pago asociada a esta transacción</p>
                </div>

                <!-- Gateway Selection -->
                <div class="col-span-1">
                    <label for="gateway_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Gateway de Pago *
                        </span>
                    </label>
                    <select name="gateway_id" id="gateway_id" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('gateway_id') border-red-500 @enderror">
                        <option value="">Seleccionar gateway</option>
                        @foreach($gateways as $gateway)
                            <option value="{{ $gateway->id }}" {{ old('gateway_id', $transaction->gateway_id) == $gateway->id ? 'selected' : '' }}>
                                {{ $gateway->name }} ({{ $gateway->provider }})
                            </option>
                        @endforeach
                    </select>
                    @error('gateway_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Selection -->
                <div class="col-span-1">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Usuario (Opcional)
                        </span>
                    </label>
                    <select name="user_id" id="user_id" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('user_id') border-red-500 @enderror">
                        <option value="">Sin usuario específico</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $transaction->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div class="col-span-1">
                    <label for="payment_method_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Método de Pago (Opcional)
                        </span>
                    </label>
                    <select name="payment_method_id" id="payment_method_id" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('payment_method_id') border-red-500 @enderror">
                        <option value="">Seleccionar método</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}" {{ old('payment_method_id', $transaction->payment_method_id) == $method->id ? 'selected' : '' }}>
                                {{ $method->type }} - {{ $method->provider }} ({{ $method->nickname }})
                            </option>
                        @endforeach
                    </select>
                    @error('payment_method_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div class="col-span-1">
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Monto *
                        </span>
                    </label>
                    <input type="number" name="amount" id="amount" step="0.01" min="0" required
                           value="{{ old('amount', $transaction->amount) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('amount') border-red-500 @enderror"
                           placeholder="0.00">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
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
                        <option value="USD" {{ old('currency', $transaction->currency) == 'USD' ? 'selected' : '' }}>USD - Dólar Estadounidense</option>
                        <option value="EUR" {{ old('currency', $transaction->currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="COP" {{ old('currency', $transaction->currency) == 'COP' ? 'selected' : '' }}>COP - Peso Colombiano</option>
                    </select>
                    @error('currency')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-span-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Estado de la Transacción *
                    </label>
                    <div class="relative">
                        <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('status') border-red-500 @enderror">
                            <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>
                                🕐 Pendiente
                            </option>
                            <option value="success" {{ old('status', $transaction->status) == 'success' ? 'selected' : '' }}>
                                ✅ Exitosa
                            </option>
                            <option value="failed" {{ old('status', $transaction->status) == 'failed' ? 'selected' : '' }}>
                                ❌ Fallida
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
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Estado actual de la transacción</p>
                </div>

                <!-- Gateway Reference -->
                <div class="col-span-1">
                    <label for="gateway_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Referencia del Gateway *
                        </span>
                    </label>
                    <input type="text" name="gateway_reference" id="gateway_reference" required
                           value="{{ old('gateway_reference', $transaction->gateway_reference) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('gateway_reference') border-red-500 @enderror"
                           placeholder="Ej: TXN_123456789">
                    @error('gateway_reference')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">ID único de la transacción en el gateway</p>
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
                                        <li>Los cambios en transacciones exitosas pueden afectar los registros financieros</li>
                                        <li>La referencia del gateway debe ser única en el sistema</li>
                                        <li>Verifica que los datos sean correctos antes de guardar</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Volver a lista</span>
                </a>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('transactions.show', $transaction) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-200 flex items-center space-x-2" id="submitBtn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Actualizar Transacción</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Transaction History Card -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Historial de la Transacción</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600 dark:text-gray-400">Creado:</span>
                    <span class="text-gray-900 dark:text-white">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600 dark:text-gray-400">Última actualización:</span>
                    <span class="text-gray-900 dark:text-white">{{ $transaction->updated_at->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('transactionForm');
    const submitBtn = document.getElementById('submitBtn');
    const orderSelect = document.getElementById('order_id');
    const userSelect = document.getElementById('user_id');
    const amountInput = document.getElementById('amount');

    // Form validation
    function validateForm() {
        const isValid = orderSelect.value !== '' && 
                       document.getElementById('gateway_id').value !== '' && 
                       amountInput.value !== '' &&
                       document.getElementById('currency').value !== '' &&
                       document.getElementById('gateway_reference').value !== '' &&
                       document.getElementById('status').value !== '';
        
        submitBtn.disabled = !isValid;
        submitBtn.classList.toggle('opacity-50', !isValid);
        submitBtn.classList.toggle('cursor-not-allowed', !isValid);
        
        return isValid;
    }

    // Auto-fill amount when order is selected (optional in edit mode)
    orderSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value && confirm('¿Deseas actualizar el monto con el total de la orden seleccionada?')) {
            const total = selectedOption.getAttribute('data-total');
            amountInput.value = parseFloat(total).toFixed(2);
        }
        validateForm();
    });

    // Real-time validation
    const requiredFields = ['order_id', 'gateway_id', 'amount', 'currency', 'gateway_reference', 'status'];
    requiredFields.forEach(fieldId => {
        document.getElementById(fieldId).addEventListener('change', validateForm);
        document.getElementById(fieldId).addEventListener('input', validateForm);
    });
    
    // Initial validation
    validateForm();

    // Enhanced user selection with search
    userSelect.addEventListener('focus', function() {
        this.size = Math.min(this.options.length, 8);
    });

    userSelect.addEventListener('blur', function() {
        this.size = 1;
    });

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            alert('Por favor, completa todos los campos obligatorios.');
            return false;
        }

        if (!confirm('¿Estás seguro de que deseas actualizar esta transacción?')) {
            e.preventDefault();
            return false;
        }

        // Add loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Actualizando...
        `;
    });

    // Status change warnings
    document.getElementById('status').addEventListener('change', function() {
        const currentStatus = '{{ $transaction->status }}';
        const newStatus = this.value;
        
        if (currentStatus === 'success' && newStatus !== 'success') {
            if (!confirm('Estás cambiando el estado de una transacción exitosa. Esto puede afectar los registros financieros. ¿Continuar?')) {
                this.value = currentStatus;
                return;
            }
        }
        
        if (newStatus === 'success' && currentStatus !== 'success') {
            if (!confirm('Estás marcando esta transacción como exitosa. ¿Confirmas que el pago fue procesado correctamente?')) {
                this.value = currentStatus;
                return;
            }
        }
        
        validateForm();
    });
});
</script>
@endpush
