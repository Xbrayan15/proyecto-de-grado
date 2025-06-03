@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Registrar Nueva Tarjeta de Crédito</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Registra una nueva tarjeta de crédito en el sistema</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Información de la Tarjeta</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Complete todos los campos obligatorios para registrar la tarjeta</p>
        </div>
        
        <form method="POST" action="{{ route('credit-cards.store') }}" class="p-6" id="creditCardForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Payment Method Selection -->
                <div class="col-span-1 md:col-span-2">
                    <label for="payment_method_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Método de Pago Asociado *
                        </span>
                    </label>
                    <div class="relative">
                        <select name="payment_method_id" id="payment_method_id" required 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('payment_method_id') border-red-500 @enderror">
                            <option value="">Seleccionar método de pago</option>
                            @foreach($paymentMethods as $method)
                                @if($method->type === 'credit_card')
                                <option value="{{ $method->id }}" data-user="{{ $method->user->name ?? 'Sin usuario' }}">
                                    {{ $method->user->name ?? 'Sin usuario' }} - {{ $method->nickname ?? 'Sin alias' }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('payment_method_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Solo se muestran métodos de pago tipo "Tarjeta de Crédito"</p>
                </div>

                <!-- Last Four Digits -->
                <div class="col-span-1">
                    <label for="last_four" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Últimos 4 Dígitos *
                        </span>
                    </label>
                    <input type="text" name="last_four" id="last_four" required maxlength="4" pattern="[0-9]{4}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('last_four') border-red-500 @enderror"
                           placeholder="1234" value="{{ old('last_four') }}">
                    @error('last_four')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Solo los últimos 4 dígitos de la tarjeta</p>
                </div>

                <!-- Card Brand -->
                <div class="col-span-1">
                    <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Marca de la Tarjeta *
                        </span>
                    </label>
                    <select name="brand" id="brand" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('brand') border-red-500 @enderror">
                        <option value="">Seleccionar marca</option>
                        <option value="visa" {{ old('brand') === 'visa' ? 'selected' : '' }}>Visa</option>
                        <option value="mastercard" {{ old('brand') === 'mastercard' ? 'selected' : '' }}>MasterCard</option>
                        <option value="amex" {{ old('brand') === 'amex' ? 'selected' : '' }}>American Express</option>
                        <option value="diners" {{ old('brand') === 'diners' ? 'selected' : '' }}>Diners Club</option>
                        <option value="discover" {{ old('brand') === 'discover' ? 'selected' : '' }}>Discover</option>
                    </select>
                    @error('brand')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expiry Month -->
                <div class="col-span-1">
                    <label for="expiry_month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Mes de Expiración *
                        </span>
                    </label>
                    <select name="expiry_month" id="expiry_month" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('expiry_month') border-red-500 @enderror">
                        <option value="">Mes</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ old('expiry_month') === sprintf('%02d', $i) ? 'selected' : '' }}>
                                {{ sprintf('%02d', $i) }} - {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    @error('expiry_month')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expiry Year -->
                <div class="col-span-1">
                    <label for="expiry_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Año de Expiración *
                        </span>
                    </label>
                    <select name="expiry_year" id="expiry_year" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('expiry_year') border-red-500 @enderror">
                        <option value="">Año</option>
                        @for($year = date('Y'); $year <= date('Y') + 20; $year++)
                            <option value="{{ $year }}" {{ old('expiry_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                    @error('expiry_year')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Card Holder Name -->
                <div class="col-span-1 md:col-span-2">
                    <label for="card_holder" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Nombre del Titular
                        </span>
                    </label>
                    <input type="text" name="card_holder" id="card_holder" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('card_holder') border-red-500 @enderror"
                           placeholder="Nombre tal como aparece en la tarjeta" value="{{ old('card_holder') }}">
                    @error('card_holder')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nombre del titular tal como aparece en la tarjeta (opcional)</p>
                </div>

                <!-- Token ID (Optional) -->
                <div class="col-span-1 md:col-span-2">
                    <label for="token_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            Token de Seguridad
                        </span>
                    </label>
                    <input type="text" name="token_id" id="token_id" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('token_id') border-red-500 @enderror"
                           placeholder="Token del gateway de pago" value="{{ old('token_id') }}">
                    @error('token_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Token de seguridad proporcionado por el gateway de pago (opcional)</p>
                </div>
            </div>

            <!-- Information Card -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">Información de Seguridad</h3>
                        <div class="text-sm text-blue-600 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Solo se almacenan los últimos 4 dígitos por seguridad</li>
                                <li>El número completo de la tarjeta nunca se guarda</li>
                                <li>La información está encriptada y protegida</li>
                                <li>Solo personal autorizado puede acceder a estos datos</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                <a href="{{ route('credit-cards.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200 flex items-center space-x-2">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Registrar Tarjeta</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Acciones Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <a href="{{ route('payment-methods.index') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Métodos de Pago</span>
            </a>
            <a href="{{ route('users.index') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <span>Gestionar Usuarios</span>
            </a>
            <a href="{{ route('transactions.index') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <span>Transacciones</span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('creditCardForm');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetForm');
    const lastFourInput = document.getElementById('last_four');
    const brandSelect = document.getElementById('brand');
    const paymentMethodSelect = document.getElementById('payment_method_id');

    // Form validation
    function validateForm() {
        const isValid = paymentMethodSelect.value !== '' && 
                       lastFourInput.value.length === 4 && 
                       brandSelect.value !== '' &&
                       document.getElementById('expiry_month').value !== '' &&
                       document.getElementById('expiry_year').value !== '';
        
        submitBtn.disabled = !isValid;
        submitBtn.classList.toggle('opacity-50', !isValid);
        submitBtn.classList.toggle('cursor-not-allowed', !isValid);
        
        return isValid;
    }

    // Auto-format last four digits
    lastFourInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 4) {
            this.value = this.value.substring(0, 4);
        }
        validateForm();
    });

    // Real-time validation
    const requiredFields = ['payment_method_id', 'last_four', 'brand', 'expiry_month', 'expiry_year'];
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('change', validateForm);
            field.addEventListener('input', validateForm);
        }
    });
    
    // Initial validation
    validateForm();

    // Reset form
    resetBtn.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas limpiar el formulario?')) {
            form.reset();
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

        // Validate expiry date
        const month = parseInt(document.getElementById('expiry_month').value);
        const year = parseInt(document.getElementById('expiry_year').value);
        const now = new Date();
        const currentMonth = now.getMonth() + 1;
        const currentYear = now.getFullYear();

        if (year < currentYear || (year === currentYear && month < currentMonth)) {
            e.preventDefault();
            alert('La fecha de expiración no puede ser en el pasado.');
            return false;
        }

        if (!confirm('¿Estás seguro de que deseas registrar esta tarjeta de crédito?')) {
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
            Registrando...
        `;
    });

    // Auto-detect card brand based on first digits (if implementing auto-detection)
    lastFourInput.addEventListener('blur', function() {
        // This is just a placeholder for potential brand auto-detection
        // In a real implementation, you might want to auto-detect based on BIN ranges
    });
});
</script>
@endpush
