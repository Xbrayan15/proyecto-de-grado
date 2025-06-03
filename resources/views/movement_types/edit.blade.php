@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <nav class="flex mb-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('movement-types.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-list mr-2"></i>Tipos de Movimiento
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('movement-types.show', $movementType->id) }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                            {{ $movementType->name }}
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500">Editar</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Tipo de Movimiento</h1>
            <p class="text-gray-600">Modifique la información del tipo de movimiento de inventario</p>
        </div>
        <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('movement-types.show', $movementType->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-eye mr-2"></i>Ver Detalles
            </a>
            <a href="{{ route('movement-types.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Volver a Lista
            </a>
        </div>
    </div>

    <!-- Warning Banner -->
    @if($movementType->inventoryMovements->count() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong class="font-medium">Atención:</strong> Este tipo de movimiento tiene 
                        <span class="font-medium">{{ $movementType->inventoryMovements->count() }} movimientos</span> asociados. 
                        Los cambios pueden afectar la consistencia de los datos históricos.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-medium">Por favor corrige los siguientes errores:</span>
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Información del Tipo
                    </h2>
                </div>

                <form action="{{ route('movement-types.update', $movementType->id) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 space-y-6">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Tipo de Movimiento <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="name" id="name" value="{{ old('name', $movementType->name) }}" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('name') border-red-500 @enderror"
                                    placeholder="Ej: Compra de productos, Venta, Devolución, etc."
                                    maxlength="255">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                            </div>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">
                                <span id="nameCount">{{ strlen(old('name', $movementType->name)) }}</span>/255 caracteres
                            </p>
                        </div>

                        <!-- Effect Field -->
                        <div>
                            <label for="effect" class="block text-sm font-medium text-gray-700 mb-2">
                                Efecto en el Inventario <span class="text-red-500">*</span>
                            </label>
                            
                            @if($movementType->inventoryMovements->count() > 0)
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                                    <div class="flex items-center text-yellow-700">
                                        <i class="fas fa-lock mr-2"></i>
                                        <span class="text-sm font-medium">
                                            Cambiar el efecto puede afectar {{ $movementType->inventoryMovements->count() }} movimientos existentes
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" name="effect" id="effect_in" value="in" 
                                        {{ old('effect', $movementType->effect) === 'in' ? 'checked' : '' }}
                                        class="sr-only effect-radio">
                                    <label for="effect_in" class="effect-option flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-300 transition duration-200">
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                                                <i class="fas fa-arrow-up text-green-600 text-xl"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Entrada (+)</div>
                                            <div class="text-xs text-gray-500">Incrementa el inventario</div>
                                        </div>
                                    </label>
                                </div>

                                <div class="relative">
                                    <input type="radio" name="effect" id="effect_out" value="out" 
                                        {{ old('effect', $movementType->effect) === 'out' ? 'checked' : '' }}
                                        class="sr-only effect-radio">
                                    <label for="effect_out" class="effect-option flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-300 transition duration-200">
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                                                <i class="fas fa-arrow-down text-red-600 text-xl"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Salida (-)</div>
                                            <div class="text-xs text-gray-500">Reduce el inventario</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('effect')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Change Documentation -->
                        @if($movementType->inventoryMovements->count() > 0)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-red-900 mb-3 flex items-center">
                                    <i class="fas fa-clipboard-list mr-2"></i>
                                    Documentación de Cambios (Requerida)
                                </h4>
                                
                                <div class="space-y-3">
                                    <div>
                                        <label for="change_reason" class="block text-sm font-medium text-red-700 mb-1">
                                            Razón del cambio <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="change_reason" id="change_reason" rows="3" 
                                            class="w-full px-3 py-2 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                            placeholder="Explique por qué es necesario modificar este tipo de movimiento..."></textarea>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" id="understand_impact" class="rounded border-red-300 text-red-600">
                                            <span class="ml-2 text-sm text-red-700">Entiendo que estos cambios pueden afectar los movimientos históricos</span>
                                        </label>

                                        <label class="flex items-center">
                                            <input type="checkbox" id="backup_created" class="rounded border-red-300 text-red-600">
                                            <span class="ml-2 text-sm text-red-700">He creado una copia de seguridad de los datos</span>
                                        </label>

                                        <label class="flex items-center">
                                            <input type="checkbox" id="notify_users" class="rounded border-red-300 text-red-600">
                                            <span class="ml-2 text-sm text-red-700">Notificaré a los usuarios afectados sobre estos cambios</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Additional Options -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-cog mr-2 text-gray-500"></i>
                                Opciones Adicionales
                            </h4>
                            
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" id="sendNotification" class="rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Notificar a administradores sobre la modificación</span>
                                </label>

                                <label class="flex items-center">
                                    <input type="checkbox" id="auditLog" checked disabled class="rounded border-gray-300 text-gray-400">
                                    <span class="ml-2 text-sm text-gray-500">Registrar cambios en el log de auditoría (automático)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                        <button type="button" onclick="previewChanges()" 
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-eye mr-2"></i>Vista Previa de Cambios
                        </button>
                        <button type="submit" 
                            class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center disabled:opacity-50"
                            id="submitBtn">
                            <i class="fas fa-save mr-2"></i>Actualizar Tipo de Movimiento
                        </button>
                        <a href="{{ route('movement-types.show', $movementType->id) }}" 
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Original Values -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-history mr-2 text-gray-500"></i>
                        Valores Originales
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Original</label>
                        <div class="text-sm text-gray-900 p-2 bg-gray-50 rounded">{{ $movementType->name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Efecto Original</label>
                        <div class="text-sm p-2 bg-gray-50 rounded">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $movementType->effect === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas {{ $movementType->effect === 'in' ? 'fa-plus' : 'fa-minus' }} mr-1"></i>
                                {{ $movementType->effect === 'in' ? 'Entrada (+)' : 'Salida (-)' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Creación</label>
                        <div class="text-sm text-gray-900 p-2 bg-gray-50 rounded">{{ $movementType->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Change Detection -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-search mr-2 text-blue-500"></i>
                        Detección de Cambios
                    </h3>
                </div>
                <div class="p-6">
                    <div id="changeDetection" class="text-center text-gray-500">
                        <i class="fas fa-equals text-2xl mb-2"></i>
                        <p class="text-sm">Sin cambios detectados</p>
                    </div>
                </div>
            </div>

            <!-- Usage Impact -->
            @if($movementType->inventoryMovements->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>
                            Impacto de Cambios
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Movimientos Afectados:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $movementType->inventoryMovements->count() }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Último Movimiento:</span>
                            <span class="text-sm text-gray-900">
                                @if($movementType->inventoryMovements->count() > 0)
                                    {{ $movementType->inventoryMovements->sortByDesc('created_at')->first()->created_at->diffForHumans() }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <p class="text-xs text-yellow-700">
                                <i class="fas fa-info-circle mr-1"></i>
                                Los cambios en el efecto pueden requerir recalcular inventarios
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-2 text-purple-500"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <button onclick="resetForm()" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                        <i class="fas fa-undo mr-2"></i>Restablecer Valores
                    </button>

                    <a href="{{ route('movement-types.show', $movementType->id) }}" 
                        class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                        <i class="fas fa-eye mr-2"></i>Ver Detalles
                    </a>

                    <a href="{{ route('inventory-movements.index') }}?movement_type={{ $movementType->id }}" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                        <i class="fas fa-list mr-2"></i>Ver Movimientos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Changes Modal -->
<div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 mb-4">
                <i class="fas fa-eye text-purple-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mb-4">Vista Previa de Cambios</h3>
            
            <div id="previewContent" class="space-y-4 mb-6">
                <!-- Content will be populated by JavaScript -->
            </div>

            <div class="flex gap-4">
                <button onclick="closePreviewModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-300">
                    Cerrar
                </button>
                <button onclick="confirmChanges()" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                    Confirmar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const nameCount = document.getElementById('nameCount');
    const effectRadios = document.querySelectorAll('input[name="effect"]');
    const changeDetection = document.getElementById('changeDetection');
    const submitBtn = document.getElementById('submitBtn');

    // Original values
    const originalName = "{{ $movementType->name }}";
    const originalEffect = "{{ $movementType->effect }}";

    // Character counter
    nameInput.addEventListener('input', function() {
        nameCount.textContent = this.value.length;
        detectChanges();
        validateForm();
    });

    // Effect selection styling
    effectRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove active styling from all options
            document.querySelectorAll('.effect-option').forEach(option => {
                option.classList.remove('border-green-500', 'border-red-500', 'bg-green-50', 'bg-red-50');
                option.classList.add('border-gray-200');
            });

            // Add active styling to selected option
            const selectedLabel = document.querySelector(`label[for="${this.id}"]`);
            if (this.value === 'in') {
                selectedLabel.classList.remove('border-gray-200');
                selectedLabel.classList.add('border-green-500', 'bg-green-50');
            } else {
                selectedLabel.classList.remove('border-gray-200');
                selectedLabel.classList.add('border-red-500', 'bg-red-50');
            }

            detectChanges();
            validateForm();
        });
    });

    // Initialize effect styling
    const checkedEffect = document.querySelector('input[name="effect"]:checked');
    if (checkedEffect) {
        checkedEffect.dispatchEvent(new Event('change'));
    }

    function detectChanges() {
        const currentName = nameInput.value.trim();
        const currentEffect = document.querySelector('input[name="effect"]:checked')?.value;

        const nameChanged = currentName !== originalName;
        const effectChanged = currentEffect !== originalEffect;

        if (nameChanged || effectChanged) {
            let changesHtml = '<div class="space-y-2">';
            
            if (nameChanged) {
                changesHtml += `
                    <div class="flex items-center text-yellow-600">
                        <i class="fas fa-edit mr-2"></i>
                        <span class="text-sm">Nombre modificado</span>
                    </div>
                `;
            }
            
            if (effectChanged) {
                changesHtml += `
                    <div class="flex items-center text-orange-600">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        <span class="text-sm">Efecto modificado</span>
                    </div>
                `;
            }
            
            changesHtml += '</div>';
            changeDetection.innerHTML = changesHtml;
        } else {
            changeDetection.innerHTML = `
                <div class="text-center text-gray-500">
                    <i class="fas fa-equals text-2xl mb-2"></i>
                    <p class="text-sm">Sin cambios detectados</p>
                </div>
            `;
        }
    }

    function validateForm() {
        const name = nameInput.value.trim();
        const selectedEffect = document.querySelector('input[name="effect"]:checked');
        
        @if($movementType->inventoryMovements->count() > 0)
            const understandImpact = document.getElementById('understand_impact').checked;
            const backupCreated = document.getElementById('backup_created').checked;
            const notifyUsers = document.getElementById('notify_users').checked;
            const changeReason = document.getElementById('change_reason').value.trim();
            
            const isValid = name && selectedEffect && understandImpact && backupCreated && notifyUsers && changeReason;
        @else
            const isValid = name && selectedEffect;
        @endif
        
        submitBtn.disabled = !isValid;
        
        if (isValid) {
            submitBtn.classList.remove('opacity-50');
        } else {
            submitBtn.classList.add('opacity-50');
        }
    }

    // Add event listeners for validation checkboxes
    @if($movementType->inventoryMovements->count() > 0)
        ['understand_impact', 'backup_created', 'notify_users'].forEach(id => {
            document.getElementById(id)?.addEventListener('change', validateForm);
        });
        
        document.getElementById('change_reason')?.addEventListener('input', validateForm);
    @endif

    // Initialize form validation
    validateForm();
    detectChanges();
});

function resetForm() {
    document.getElementById('name').value = "{{ $movementType->name }}";
    document.getElementById('effect_{{ $movementType->effect }}').checked = true;
    
    @if($movementType->inventoryMovements->count() > 0)
        document.getElementById('change_reason').value = '';
        document.getElementById('understand_impact').checked = false;
        document.getElementById('backup_created').checked = false;
        document.getElementById('notify_users').checked = false;
    @endif
    
    // Trigger change events
    document.getElementById('name').dispatchEvent(new Event('input'));
    document.getElementById('effect_{{ $movementType->effect }}').dispatchEvent(new Event('change'));
}

function previewChanges() {
    const currentName = document.getElementById('name').value.trim();
    const currentEffect = document.querySelector('input[name="effect"]:checked')?.value;
    
    const originalName = "{{ $movementType->name }}";
    const originalEffect = "{{ $movementType->effect }}";
    
    let previewHtml = '<div class="overflow-x-auto">';
    previewHtml += '<table class="min-w-full divide-y divide-gray-200">';
    previewHtml += `
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor Original</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nuevo Valor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
    `;
    
    // Name comparison
    const nameChanged = currentName !== originalName;
    previewHtml += `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Nombre</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${originalName}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${currentName}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${nameChanged ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'}">
                    ${nameChanged ? 'Modificado' : 'Sin cambios'}
                </span>
            </td>
        </tr>
    `;
    
    // Effect comparison
    const effectChanged = currentEffect !== originalEffect;
    const originalEffectText = originalEffect === 'in' ? 'Entrada (+)' : 'Salida (-)';
    const currentEffectText = currentEffect === 'in' ? 'Entrada (+)' : 'Salida (-)';
    
    previewHtml += `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Efecto</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${originalEffectText}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${currentEffectText}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${effectChanged ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800'}">
                    ${effectChanged ? 'Modificado' : 'Sin cambios'}
                </span>
            </td>
        </tr>
    `;
    
    previewHtml += '</tbody></table></div>';
    
    @if($movementType->inventoryMovements->count() > 0)
        if (effectChanged) {
            previewHtml += `
                <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center text-red-700 mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="font-medium">Advertencia de Impacto</span>
                    </div>
                    <p class="text-sm text-red-600">
                        Cambiar el efecto afectará {{ $movementType->inventoryMovements->count() }} movimientos existentes.
                        Esto puede requerir recalcular los niveles de inventario.
                    </p>
                </div>
            `;
        }
    @endif
    
    document.getElementById('previewContent').innerHTML = previewHtml;
    document.getElementById('previewModal').classList.remove('hidden');
}

function closePreviewModal() {
    document.getElementById('previewModal').classList.add('hidden');
}

function confirmChanges() {
    closePreviewModal();
    document.getElementById('editForm').submit();
}

// Close modal when clicking outside
document.getElementById('previewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePreviewModal();
    }
});
</script>

<style>
.effect-radio:checked + .effect-option {
    @apply border-yellow-500 bg-yellow-50;
}

.effect-option {
    transition: all 0.2s ease-in-out;
}

.effect-option:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}
</style>
@endsection
