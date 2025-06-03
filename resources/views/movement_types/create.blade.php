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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500">Nuevo Tipo</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Crear Tipo de Movimiento</h1>
            <p class="text-gray-600">Configure un nuevo tipo de movimiento para el inventario</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('movement-types.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Volver a Lista
            </a>
        </div>
    </div>

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Información del Nuevo Tipo
                    </h2>
                </div>

                <form action="{{ route('movement-types.store') }}" method="POST" id="createForm">
                    @csrf
                    
                    <div class="p-6 space-y-6">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Tipo de Movimiento <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
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
                                <span id="nameCount">0</span>/255 caracteres
                            </p>
                        </div>

                        <!-- Effect Field -->
                        <div>
                            <label for="effect" class="block text-sm font-medium text-gray-700 mb-2">
                                Efecto en el Inventario <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" name="effect" id="effect_in" value="in" 
                                        {{ old('effect') === 'in' ? 'checked' : '' }}
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
                                        {{ old('effect') === 'out' ? 'checked' : '' }}
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

                        <!-- Additional Options -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-cog mr-2 text-gray-500"></i>
                                Opciones Adicionales
                            </h4>
                            
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" id="createMovement" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Crear movimiento de prueba después de guardar</span>
                                </label>

                                <label class="flex items-center">
                                    <input type="checkbox" id="sendNotification" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Notificar a administradores sobre el nuevo tipo</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                        <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center disabled:opacity-50"
                            id="submitBtn">
                            <i class="fas fa-save mr-2"></i>Crear Tipo de Movimiento
                        </button>
                        <button type="button" onclick="saveDraft()" 
                            class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-file-alt mr-2"></i>Guardar Borrador
                        </button>
                        <a href="{{ route('movement-types.index') }}" 
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Live Preview -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-2 text-blue-500"></i>
                        Vista Previa
                    </h3>
                </div>
                <div class="p-6">
                    <div id="preview" class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-eye-slash text-2xl mb-2"></i>
                            <p class="text-sm">Completa el formulario para ver la vista previa</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Templates -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-magic mr-2 text-purple-500"></i>
                        Plantillas Rápidas
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <button onclick="useTemplate('Compra de productos', 'in')" 
                        class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-shopping-cart text-green-600 mr-3"></i>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Compra de productos</div>
                                <div class="text-xs text-gray-500">Entrada de inventario</div>
                            </div>
                        </div>
                    </button>

                    <button onclick="useTemplate('Venta de productos', 'out')" 
                        class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-cash-register text-red-600 mr-3"></i>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Venta de productos</div>
                                <div class="text-xs text-gray-500">Salida de inventario</div>
                            </div>
                        </div>
                    </button>

                    <button onclick="useTemplate('Devolución de cliente', 'in')" 
                        class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-undo text-green-600 mr-3"></i>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Devolución de cliente</div>
                                <div class="text-xs text-gray-500">Entrada de inventario</div>
                            </div>
                        </div>
                    </button>

                    <button onclick="useTemplate('Productos dañados', 'out')" 
                        class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Productos dañados</div>
                                <div class="text-xs text-gray-500">Salida de inventario</div>
                            </div>
                        </div>
                    </button>

                    <button onclick="useTemplate('Transferencia de almacén', 'out')" 
                        class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-exchange-alt text-red-600 mr-3"></i>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Transferencia de almacén</div>
                                <div class="text-xs text-gray-500">Salida de inventario</div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Help and Tips -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>
                        Consejos y Ayuda
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-700">
                                <strong>Nombre descriptivo:</strong> Use nombres claros como "Compra de productos" o "Venta al cliente".
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <i class="fas fa-plus text-green-500 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-700">
                                <strong>Entrada (+):</strong> Para aumentar el inventario (compras, devoluciones, ajustes positivos).
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <i class="fas fa-minus text-red-500 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-700">
                                <strong>Salida (-):</strong> Para reducir el inventario (ventas, productos dañados, transferencias).
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <i class="fas fa-shield-alt text-purple-500 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-700">
                                <strong>Consistencia:</strong> Mantenga un sistema consistente de nomenclatura para facilitar la organización.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const nameCount = document.getElementById('nameCount');
    const effectRadios = document.querySelectorAll('input[name="effect"]');
    const preview = document.getElementById('preview');
    const submitBtn = document.getElementById('submitBtn');

    // Character counter
    nameInput.addEventListener('input', function() {
        nameCount.textContent = this.value.length;
        updatePreview();
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

            updatePreview();
            validateForm();
        });
    });

    function updatePreview() {
        const name = nameInput.value.trim();
        const selectedEffect = document.querySelector('input[name="effect"]:checked');

        if (name && selectedEffect) {
            const effectText = selectedEffect.value === 'in' ? 'Entrada (+)' : 'Salida (-)';
            const effectClass = selectedEffect.value === 'in' ? 'text-green-600' : 'text-red-600';
            const iconClass = selectedEffect.value === 'in' ? 'fa-arrow-up' : 'fa-arrow-down';
            const bgClass = selectedEffect.value === 'in' ? 'bg-green-100' : 'bg-red-100';

            preview.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full ${bgClass} flex items-center justify-center">
                            <i class="fas ${iconClass} ${effectClass}"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-900">${name}</div>
                        <div class="text-xs ${effectClass}">${effectText}</div>
                    </div>
                </div>
            `;
        } else {
            preview.innerHTML = `
                <div class="text-center text-gray-500">
                    <i class="fas fa-eye-slash text-2xl mb-2"></i>
                    <p class="text-sm">Completa el formulario para ver la vista previa</p>
                </div>
            `;
        }
    }

    function validateForm() {
        const name = nameInput.value.trim();
        const selectedEffect = document.querySelector('input[name="effect"]:checked');
        
        const isValid = name && selectedEffect;
        submitBtn.disabled = !isValid;
        
        if (isValid) {
            submitBtn.classList.remove('opacity-50');
        } else {
            submitBtn.classList.add('opacity-50');
        }
    }

    // Initialize form validation
    validateForm();
});

function useTemplate(name, effect) {
    document.getElementById('name').value = name;
    document.getElementById(`effect_${effect}`).checked = true;
    
    // Trigger change events
    document.getElementById('name').dispatchEvent(new Event('input'));
    document.getElementById(`effect_${effect}`).dispatchEvent(new Event('change'));
}

function saveDraft() {
    const name = document.getElementById('name').value.trim();
    const selectedEffect = document.querySelector('input[name="effect"]:checked');
    
    if (name || selectedEffect) {
        const draft = {
            name: name,
            effect: selectedEffect ? selectedEffect.value : null,
            timestamp: new Date().toISOString()
        };
        
        localStorage.setItem('movement_type_draft', JSON.stringify(draft));
        
        // Show success message
        const alertDiv = document.createElement('div');
        alertDiv.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50';
        alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                Borrador guardado correctamente
            </div>
        `;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    } else {
        alert('Completa al menos un campo para guardar el borrador.');
    }
}

// Load draft on page load
document.addEventListener('DOMContentLoaded', function() {
    const draft = localStorage.getItem('movement_type_draft');
    if (draft) {
        const draftData = JSON.parse(draft);
        
        if (confirm('Se encontró un borrador guardado. ¿Deseas cargarlo?')) {
            if (draftData.name) {
                document.getElementById('name').value = draftData.name;
            }
            if (draftData.effect) {
                document.getElementById(`effect_${draftData.effect}`).checked = true;
            }
            
            // Trigger events to update preview
            document.getElementById('name').dispatchEvent(new Event('input'));
            if (draftData.effect) {
                document.getElementById(`effect_${draftData.effect}`).dispatchEvent(new Event('change'));
            }
        }
    }
});

// Clear draft on successful form submission
document.getElementById('createForm').addEventListener('submit', function() {
    localStorage.removeItem('movement_type_draft');
});
</script>

<style>
.effect-radio:checked + .effect-option {
    @apply border-blue-500 bg-blue-50;
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
