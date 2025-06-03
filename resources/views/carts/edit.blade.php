@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('carts.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Carrito #{{ $cart->id }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Modifica la información del carrito</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('carts.show', $cart->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>Ver Detalles</span>
            </a>
        </div>
    </div>

    <!-- Current Status Banner -->
    <div class="mb-6">
        @if($cart->status === 'active')
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-green-800 dark:text-green-200 font-medium">Carrito Activo</p>
                        <p class="text-green-600 dark:text-green-300 text-sm">Este carrito está actualmente activo y puede recibir nuevos productos.</p>
                    </div>
                </div>
            </div>
        @elseif($cart->status === 'purchased')
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-blue-800 dark:text-blue-200 font-medium">Carrito Comprado</p>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Este carrito ha sido procesado y comprado.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-red-800 dark:text-red-200 font-medium">Carrito Abandonado</p>
                        <p class="text-red-600 dark:text-red-300 text-sm">Este carrito ha sido abandonado por el usuario.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Información del Carrito</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Modifica los campos necesarios</p>
                </div>
                
                <form method="POST" action="{{ route('carts.update', $cart->id) }}" class="p-6" id="cartEditForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- User Selection -->
                    <div class="mb-6">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Usuario <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="user_id" id="user_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('user_id') border-red-500 @enderror">
                                <option value="">Seleccionar usuario...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (old('user_id', $cart->user_id) == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Selection -->
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado del Carrito
                        </label>
                        <div class="relative">
                            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('status') border-red-500 @enderror">
                                <option value="active" {{ old('status', $cart->status) == 'active' ? 'selected' : '' }}>
                                    🟢 Activo - El carrito está listo para recibir productos
                                </option>
                                <option value="purchased" {{ old('status', $cart->status) == 'purchased' ? 'selected' : '' }}>
                                    🔵 Comprado - El carrito ha sido procesado y pagado
                                </option>
                                <option value="abandoned" {{ old('status', $cart->status) == 'abandoned' ? 'selected' : '' }}>
                                    🔴 Abandonado - El carrito fue abandonado por el usuario
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
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            <span id="status-description">
                                @if($cart->status === 'active')
                                    Estado actual: El carrito está activo y puede recibir productos
                                @elseif($cart->status === 'purchased')
                                    Estado actual: El carrito ha sido comprado
                                @else
                                    Estado actual: El carrito está abandonado
                                @endif
                            </span>
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('carts.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200 flex items-center space-x-2">
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
                                <span>Actualizar Carrito</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Cart Info Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Cart Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Resumen del Carrito</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">ID del Carrito:</span>
                        <span class="font-medium text-gray-900 dark:text-white">#{{ $cart->id }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Fecha de Creación:</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $cart->created_at ? $cart->created_at->format('d/m/Y') : 'No disponible' }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Artículos:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $cart->items->count() }} productos</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Usuario Actual:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $cart->user->name ?? 'No asignado' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Estado Actual:</span>
                        <span class="font-medium">
                            @if($cart->status === 'active')
                                <span class="text-green-600 dark:text-green-400">🟢 Activo</span>
                            @elseif($cart->status === 'purchased')
                                <span class="text-blue-600 dark:text-blue-400">🔵 Comprado</span>
                            @else
                                <span class="text-red-600 dark:text-red-400">🔴 Abandonado</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones Rápidas</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('cart-items.index') }}?cart_id={{ $cart->id }}" class="w-full flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span>Ver artículos del carrito</span>
                    </a>
                    
                    <a href="{{ route('cart-items.create') }}?cart_id={{ $cart->id }}" class="w-full flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-200 p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Agregar productos</span>
                    </a>
                    
                    <a href="{{ route('users.show', $cart->user_id) }}" class="w-full flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors duration-200 p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Ver perfil del usuario</span>
                    </a>
                </div>
            </div>

            <!-- Change History -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información Importante</h3>
                
                <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Los cambios se aplicarán inmediatamente después de guardar</span>
                    </div>
                    
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 text-yellow-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Cambiar el usuario puede afectar los artículos del carrito</span>
                    </div>
                    
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Los carritos comprados mantienen su historial</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('cartEditForm');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetForm');
    const userSelect = document.getElementById('user_id');
    const statusSelect = document.getElementById('status');
    const statusDescription = document.getElementById('status-description');

    // Store original values
    const originalValues = {
        user_id: userSelect.value,
        status: statusSelect.value
    };

    // Status descriptions
    const statusDescriptions = {
        active: 'El carrito está activo y puede recibir productos',
        purchased: 'El carrito ha sido comprado y procesado',
        abandoned: 'El carrito fue abandonado por el usuario'
    };

    // Form validation
    function validateForm() {
        const isValid = userSelect.value !== '';
        const hasChanges = userSelect.value !== originalValues.user_id || 
                          statusSelect.value !== originalValues.status;
        
        submitBtn.disabled = !isValid || !hasChanges;
        submitBtn.classList.toggle('opacity-50', !isValid || !hasChanges);
        submitBtn.classList.toggle('cursor-not-allowed', !isValid || !hasChanges);
        
        return isValid && hasChanges;
    }

    // Update status description
    function updateStatusDescription() {
        const selectedStatus = statusSelect.value;
        statusDescription.textContent = `Estado seleccionado: ${statusDescriptions[selectedStatus]}`;
    }

    // Real-time validation and updates
    userSelect.addEventListener('change', validateForm);
    statusSelect.addEventListener('change', function() {
        updateStatusDescription();
        validateForm();
    });
    
    // Initial validation
    validateForm();
    updateStatusDescription();

    // Reset form to original values
    resetBtn.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas restaurar los valores originales?')) {
            userSelect.value = originalValues.user_id;
            statusSelect.value = originalValues.status;
            updateStatusDescription();
            validateForm();
        }
    });

    // Enhanced user selection
    userSelect.addEventListener('focus', function() {
        this.size = Math.min(this.options.length, 8);
    });

    userSelect.addEventListener('blur', function() {
        this.size = 1;
    });

    // Form submission with confirmation for critical changes
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }

        // Confirm status changes
        if (statusSelect.value !== originalValues.status) {
            const statusNames = {
                active: 'Activo',
                purchased: 'Comprado',
                abandoned: 'Abandonado'
            };
            
            if (!confirm(`¿Estás seguro de cambiar el estado del carrito a "${statusNames[statusSelect.value]}"?`)) {
                e.preventDefault();
                return false;
            }
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
        // Ctrl+S to save
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            if (validateForm()) {
                form.submit();
            }
        }
        
        // Escape to cancel
        if (e.key === 'Escape') {
            window.location.href = "{{ route('carts.index') }}";
        }
    });
});
</script>
@endpush
