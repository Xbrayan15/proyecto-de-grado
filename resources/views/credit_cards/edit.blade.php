@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Tarjeta de Crédito</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Actualiza la información de la tarjeta de crédito</p>
        </div>
    </div>

    <!-- Warning Alert for Sensitive Data -->
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <p class="text-yellow-800 dark:text-yellow-200 font-medium">Datos Sensibles</p>
                <p class="text-yellow-600 dark:text-yellow-300 text-sm">Esta información es sensible. Solo modifica los datos necesarios y asegúrate de que sean correctos.</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Información de la Tarjeta</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Actualiza los campos necesarios</p>
        </div>
        
        <form method="POST" action="{{ route('credit-cards.update', $creditCard) }}" class="p-6" id="creditCardEditForm">
            @csrf
            @method('PUT')
            
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
                                <option value="{{ $method->id }}" data-user="{{ $method->user->name ?? 'Sin usuario' }}"
                                        {{ $creditCard->payment_method_id == $method->id ? 'selected' : '' }}>
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
                           placeholder="1234" value="{{ old('last_four', $creditCard->last_four) }}">
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
                        <option value="visa" {{ old('brand', $creditCard->brand) === 'visa' ? 'selected' : '' }}>Visa</option>
                        <option value="mastercard" {{ old('brand', $creditCard->brand) === 'mastercard' ? 'selected' : '' }}>MasterCard</option>
                        <option value="amex" {{ old('brand', $creditCard->brand) === 'amex' ? 'selected' : '' }}>American Express</option>
                        <option value="diners" {{ old('brand', $creditCard->brand) === 'diners' ? 'selected' : '' }}>Diners Club</option>
                        <option value="discover" {{ old('brand', $creditCard->brand) === 'discover' ? 'selected' : '' }}>Discover</option>
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
                            <option value="{{ sprintf('%02d', $i) }}" {{ old('expiry_month', $creditCard->expiry_month) === sprintf('%02d', $i) ? 'selected' : '' }}>
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
                            <option value="{{ $year }}" {{ old('expiry_year', $creditCard->expiry_year) == $year ? 'selected' : '' }}>{{ $year }}</option>
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
                           placeholder="Nombre tal como aparece en la tarjeta" value="{{ old('card_holder', $creditCard->card_holder) }}">
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
                           placeholder="Token del gateway de pago" value="{{ old('token_id', $creditCard->token_id) }}">
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
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">Información de Actualización</h3>
                        <div class="text-sm text-blue-600 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Solo actualiza la información que sea necesaria</li>
                                <li>Verifica que los datos de expiración sean correctos</li>
                                <li>Los cambios pueden afectar transacciones futuras</li>
                                <li>El token de seguridad solo debe actualizarse por personal autorizado</li>
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
                    <span>Cancelar</span>
                </a>
                
                <div class="flex items-center space-x-3">
                    <button type="button" id="resetForm" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                        Restaurar
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-200 flex items-center space-x-2" id="submitBtn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Actualizar Tarjeta</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Card History/Activity Sidebar -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Información de la Tarjeta</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="font-medium text-gray-600 dark:text-gray-400">Fecha de registro:</span>
                    <span class="text-gray-900 dark:text-white">{{ $creditCard->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600 dark:text-gray-400">Última actualización:</span>
                    <span class="text-gray-900 dark:text-white">{{ $creditCard->updated_at->format('d/m/Y H:i:s') }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600 dark:text-gray-400">Usuario asociado:</span>
                    <span class="text-gray-900 dark:text-white">{{ $creditCard->paymentMethod?->user?->name ?? 'Sin usuario' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600 dark:text-gray-400">Estado del método:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $creditCard->paymentMethod?->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 
                           ($creditCard->paymentMethod?->status === 'inactive' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100' : 
                           'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100') }}">
                        {{ ucfirst($creditCard->paymentMethod?->status ?? 'Desconocido') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('creditCardEditForm');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetForm');
    const lastFourInput = document.getElementById('last_four');
    const brandSelect = document.getElementById('brand');
    const paymentMethodSelect = document.getElementById('payment_method_id');

    // Store original values
    const originalValues = {
        payment_method_id: paymentMethodSelect.value,
        last_four: lastFourInput.value,
        brand: brandSelect.value,
        expiry_month: document.getElementById('expiry_month').value,
        expiry_year: document.getElementById('expiry_year').value,
        card_holder: document.getElementById('card_holder').value,
        token_id: document.getElementById('token_id').value
    };

    // Form validation
    function validateForm() {
        const isValid = paymentMethodSelect.value !== '' && 
                       lastFourInput.value.length === 4 && 
                       brandSelect.value !== '' &&
                       document.getElementById('expiry_month').value !== '' &&
                       document.getElementById('expiry_year').value !== '';
        
        const hasChanges = Object.keys(originalValues).some(key => {
            const element = document.getElementById(key);
            return element && element.value !== originalValues[key];
        });
        
        submitBtn.disabled = !isValid || !hasChanges;
        submitBtn.classList.toggle('opacity-50', !isValid || !hasChanges);
        submitBtn.classList.toggle('cursor-not-allowed', !isValid || !hasChanges);
        
        return isValid && hasChanges;
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
    const allFields = ['payment_method_id', 'last_four', 'brand', 'expiry_month', 'expiry_year', 'card_holder', 'token_id'];
    allFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('change', validateForm);
            field.addEventListener('input', validateForm);
        }
    });
    
    // Initial validation
    validateForm();

    // Reset form to original values
    resetBtn.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas restaurar los valores originales?')) {
            Object.keys(originalValues).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.value = originalValues[key];
                }
            });
            validateForm();
        }
    });

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            alert('Por favor, completa todos los campos obligatorios o realiza algún cambio.');
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

        if (!confirm('¿Estás seguro de que deseas actualizar esta tarjeta de crédito?')) {
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

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            if (validateForm()) {
                form.submit();
            }
        }
        
        // Escape to cancel
        if (e.key === 'Escape') {
            window.location.href = "{{ route('credit-cards.index') }}";
        }
    });
});
</script>
@endpush
