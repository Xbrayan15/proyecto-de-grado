@extends('layouts.app')

@section('content')
<!-- Header with gradient background -->
<div class="bg-gradient-to-r from-purple-600 via-purple-700 to-pink-600 shadow-lg">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Editar Categoría</h1>
                <p class="text-purple-100">Modifica la información de "{{ $category->name }}"</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <a href="{{ route('categories.show', $category->id) }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all duration-300 backdrop-blur-sm">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Categoría
                </a>
                <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all duration-300 backdrop-blur-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Listado
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded-lg flex items-center">
    <i class="fas fa-check-circle mr-2"></i>
    {{ session('success') }}
    <button onclick="this.parentElement.style.display='none'" class="ml-auto text-green-700 hover:text-green-900">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <!-- Change Detection Banner -->
                <div id="changes-banner" class="hidden mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                        <span class="text-yellow-800 font-medium">Tienes cambios sin guardar</span>
                        <button id="reset-changes" class="ml-auto text-yellow-600 hover:text-yellow-800 text-sm">
                            <i class="fas fa-undo mr-1"></i>Restablecer
                        </button>
                    </div>
                </div>

                <!-- Original Data (Hidden) -->
                <div id="original-data" class="hidden" 
                     data-name="{{ $category->name }}" 
                     data-description="{{ $category->description }}">
                </div>

                <form id="category-form" action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Name Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag text-purple-600 mr-1"></i>
                            Nombre de la Categoría *
                        </label>
                        <div class="relative">
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                                class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('name') border-red-500 @enderror" 
                                placeholder="Ej: Electrónicos, Ropa, Hogar..." required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <div id="name-counter" class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-gray-500">
                                0/255
                            </div>
                        </div>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-align-left text-purple-600 mr-1"></i>
                            Descripción
                        </label>
                        <div class="relative">
                            <textarea name="description" id="description" rows="4" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('description') border-red-500 @enderror" 
                                placeholder="Describe brevemente esta categoría...">{{ old('description', $category->description) }}</textarea>
                            <div id="description-counter" class="absolute bottom-2 right-2 text-xs text-gray-500 bg-white px-2">
                                0/500
                            </div>
                        </div>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" id="submit-btn" class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-[1.02]">
                            <i class="fas fa-save mr-2"></i>
                            Actualizar Categoría
                        </button>
                        <button type="button" id="reset-form-btn" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300">
                            <i class="fas fa-undo mr-2"></i>
                            Restablecer Cambios
                        </button>
                        <a href="{{ route('categories.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-all duration-300 text-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Live Preview & Changes Sidebar -->
        <div class="lg:col-span-1">
            <!-- Live Preview -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-eye text-purple-600 mr-2"></i>
                    Vista Previa
                </h3>
                
                <div id="preview-content" class="border-2 border-dashed border-gray-300 rounded-lg p-4 min-h-[150px]">
                    <!-- Preview content will be populated by JavaScript -->
                </div>
            </div>

            <!-- Changes Summary -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-list-alt text-purple-600 mr-2"></i>
                    Resumen de Cambios
                </h3>
                
                <div id="changes-summary" class="space-y-2 text-sm">
                    <div class="text-gray-500 text-center py-4">
                        <i class="fas fa-info-circle text-2xl mb-2"></i>
                        <p>No hay cambios pendientes</p>
                    </div>
                </div>
            </div>

            <!-- Category Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                    Información de la Categoría
                </h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID:</span>
                        <span class="font-semibold text-gray-800">#{{ $category->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Productos asociados:</span>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">{{ $category->products_count ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Creada:</span>
                        <span class="text-gray-800">{{ $category->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Actualizada:</span>
                        <span class="text-gray-800">{{ $category->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <h4 class="font-semibold text-gray-700 mb-2">Acciones Rápidas</h4>
                    <div class="space-y-2">
                        <a href="{{ route('categories.show', $category->id) }}" class="block w-full text-center bg-blue-100 hover:bg-blue-200 text-blue-800 py-2 px-3 rounded-lg transition-colors duration-300 text-sm">
                            <i class="fas fa-eye mr-1"></i>Ver Detalles
                        </a>
                        @if($category->products_count > 0)
                        <button class="block w-full text-center bg-green-100 hover:bg-green-200 text-green-800 py-2 px-3 rounded-lg transition-colors duration-300 text-sm">
                            <i class="fas fa-box mr-1"></i>Ver Productos ({{ $category->products_count }})
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('category-form');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const changesBanner = document.getElementById('changes-banner');
    const previewContent = document.getElementById('preview-content');
    const changesSummary = document.getElementById('changes-summary');
    const resetChangesBtn = document.getElementById('reset-changes');
    const resetFormBtn = document.getElementById('reset-form-btn');
    const originalData = document.getElementById('original-data');

    // Character counters
    const nameCounter = document.getElementById('name-counter');
    const descriptionCounter = document.getElementById('description-counter');

    // Original values
    const originalName = originalData.dataset.name;
    const originalDescription = originalData.dataset.description || '';

    // Real-time updates
    nameInput.addEventListener('input', function() {
        updatePreview();
        checkForChanges();
        updateCounters();
    });

    descriptionInput.addEventListener('input', function() {
        updatePreview();
        checkForChanges();
        updateCounters();
    });

    // Reset functionality
    resetChangesBtn.addEventListener('click', resetToOriginal);
    resetFormBtn.addEventListener('click', resetToOriginal);

    function resetToOriginal() {
        nameInput.value = originalName;
        descriptionInput.value = originalDescription;
        updatePreview();
        checkForChanges();
        updateCounters();
    }

    function updatePreview() {
        const name = nameInput.value.trim() || originalName;
        const description = descriptionInput.value.trim() || originalDescription;

        previewContent.innerHTML = `
            <div class="space-y-4">
                <div class="border-l-4 border-purple-500 pl-4">
                    <h4 class="font-semibold text-gray-800">${name}</h4>
                    <p class="text-sm text-gray-600 mt-1">${description || 'Sin descripción'}</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Estado:</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Editando</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-gray-600">Productos:</span>
                        <span class="text-gray-800">{{ $category->products_count ?? 0 }} productos</span>
                    </div>
                </div>
            </div>
        `;
    }

    function checkForChanges() {
        const currentName = nameInput.value.trim();
        const currentDescription = descriptionInput.value.trim();
        
        const hasChanges = currentName !== originalName || currentDescription !== originalDescription;
        
        if (hasChanges) {
            changesBanner.classList.remove('hidden');
            updateChangesSummary(currentName, currentDescription);
        } else {
            changesBanner.classList.add('hidden');
            resetChangesSummary();
        }
    }

    function updateChangesSummary(currentName, currentDescription) {
        let changes = [];
        
        if (currentName !== originalName) {
            changes.push(`
                <div class="bg-yellow-50 border border-yellow-200 rounded p-2">
                    <div class="text-xs text-yellow-700 font-medium">Nombre</div>
                    <div class="text-xs text-gray-600 line-through">${originalName}</div>
                    <div class="text-xs text-green-700">→ ${currentName}</div>
                </div>
            `);
        }
        
        if (currentDescription !== originalDescription) {
            changes.push(`
                <div class="bg-yellow-50 border border-yellow-200 rounded p-2">
                    <div class="text-xs text-yellow-700 font-medium">Descripción</div>
                    <div class="text-xs text-gray-600 line-through">${originalDescription || '(vacío)'}</div>
                    <div class="text-xs text-green-700">→ ${currentDescription || '(vacío)'}</div>
                </div>
            `);
        }
        
        if (changes.length > 0) {
            changesSummary.innerHTML = changes.join('');
        }
    }

    function resetChangesSummary() {
        changesSummary.innerHTML = `
            <div class="text-gray-500 text-center py-4">
                <i class="fas fa-info-circle text-2xl mb-2"></i>
                <p>No hay cambios pendientes</p>
            </div>
        `;
    }

    function updateCounters() {
        const nameLength = nameInput.value.length;
        const descriptionLength = descriptionInput.value.length;

        nameCounter.textContent = `${nameLength}/255`;
        descriptionCounter.textContent = `${descriptionLength}/500`;

        // Update colors based on length
        nameCounter.className = nameLength > 200 ? 'absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-orange-500' : 'absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-gray-500';
        descriptionCounter.className = descriptionLength > 400 ? 'absolute bottom-2 right-2 text-xs text-orange-500 bg-white px-2' : 'absolute bottom-2 right-2 text-xs text-gray-500 bg-white px-2';
    }

    // Prevent accidental navigation if there are unsaved changes
    window.addEventListener('beforeunload', function(e) {
        const hasChanges = nameInput.value.trim() !== originalName || descriptionInput.value.trim() !== originalDescription;
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Remove beforeunload when form is submitted
    form.addEventListener('submit', function() {
        window.removeEventListener('beforeunload', function(){});
    });

    // Auto-hide success message
    const successMessage = document.getElementById('success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
    }

    // Initial setup
    updatePreview();
    checkForChanges();
    updateCounters();
});
</script>
@endsection
@endsection
