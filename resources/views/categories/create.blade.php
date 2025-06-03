@extends('layouts.app')

@section('content')
<!-- Header with gradient background -->
<div class="bg-gradient-to-r from-purple-600 via-purple-700 to-pink-600 shadow-lg">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Crear Nueva Categoría</h1>
                <p class="text-purple-100">Agrega una nueva categoría al sistema</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all duration-300 backdrop-blur-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Listado
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <!-- Form Progress -->
                <div class="mb-6">
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                        <span>Progreso del formulario</span>
                        <span id="progress-text">0% completado</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progress-bar" class="bg-gradient-to-r from-purple-600 to-pink-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>

                <form id="category-form" action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    
                    <!-- Name Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag text-purple-600 mr-1"></i>
                            Nombre de la Categoría *
                        </label>
                        <div class="relative">
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
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
                                placeholder="Describe brevemente esta categoría...">{{ old('description') }}</textarea>
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

                    <!-- Category Templates -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-templates text-purple-600 mr-1"></i>
                            Plantillas de Categorías
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <button type="button" class="template-btn p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all duration-300 text-left group" 
                                data-name="Electrónicos" data-description="Productos tecnológicos como smartphones, laptops, tablets y accesorios electrónicos.">
                                <div class="flex items-center">
                                    <i class="fas fa-laptop text-purple-600 text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Electrónicos</h4>
                                        <p class="text-sm text-gray-600">Tecnología y gadgets</p>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="template-btn p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all duration-300 text-left group" 
                                data-name="Ropa y Moda" data-description="Prendas de vestir, calzado y accesorios de moda para todas las edades.">
                                <div class="flex items-center">
                                    <i class="fas fa-tshirt text-pink-600 text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Ropa y Moda</h4>
                                        <p class="text-sm text-gray-600">Vestimenta y accesorios</p>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="template-btn p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all duration-300 text-left group" 
                                data-name="Hogar y Jardín" data-description="Artículos para el hogar, decoración, muebles y herramientas de jardinería.">
                                <div class="flex items-center">
                                    <i class="fas fa-home text-green-600 text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Hogar y Jardín</h4>
                                        <p class="text-sm text-gray-600">Decoración y utilidades</p>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="template-btn p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all duration-300 text-left group" 
                                data-name="Deportes" data-description="Equipamiento deportivo, ropa deportiva y accesorios para fitness.">
                                <div class="flex items-center">
                                    <i class="fas fa-dumbbell text-blue-600 text-xl mr-3 group-hover:scale-110 transition-transform"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Deportes</h4>
                                        <p class="text-sm text-gray-600">Equipamiento atlético</p>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" id="submit-btn" class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-save mr-2"></i>
                            Crear Categoría
                        </button>
                        <button type="button" id="save-draft-btn" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300">
                            <i class="fas fa-save mr-2"></i>
                            Guardar Borrador
                        </button>
                        <a href="{{ route('categories.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-all duration-300 text-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Live Preview Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-eye text-purple-600 mr-2"></i>
                    Vista Previa
                </h3>
                
                <div id="preview-content" class="border-2 border-dashed border-gray-300 rounded-lg p-4 min-h-[200px]">
                    <div class="text-center text-gray-500">
                        <i class="fas fa-tag text-4xl mb-3"></i>
                        <p>Completa el formulario para ver la vista previa</p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="mt-6 space-y-3">
                    <h4 class="font-semibold text-gray-700 mb-3">Estadísticas Rápidas</h4>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Campos completados:</span>
                        <span id="completed-fields" class="font-semibold text-purple-600">0/2</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Caracteres del nombre:</span>
                        <span id="name-chars" class="font-semibold text-purple-600">0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Caracteres de descripción:</span>
                        <span id="description-chars" class="font-semibold text-purple-600">0</span>
                    </div>
                </div>

                <!-- Tips -->
                <div class="mt-6 bg-purple-50 rounded-lg p-4">
                    <h4 class="font-semibold text-purple-800 mb-2">💡 Consejos</h4>
                    <ul class="text-sm text-purple-700 space-y-1">
                        <li>• Usa nombres descriptivos y únicos</li>
                        <li>• Una buena descripción ayuda a organizar productos</li>
                        <li>• Puedes usar las plantillas como punto de partida</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Message Toast -->
<div id="success-toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>¡Borrador guardado exitosamente!</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('category-form');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const previewContent = document.getElementById('preview-content');
    const submitBtn = document.getElementById('submit-btn');
    const saveDraftBtn = document.getElementById('save-draft-btn');
    const successToast = document.getElementById('success-toast');

    // Character counters
    const nameCounter = document.getElementById('name-counter');
    const descriptionCounter = document.getElementById('description-counter');
    const nameChars = document.getElementById('name-chars');
    const descriptionChars = document.getElementById('description-chars');
    const completedFields = document.getElementById('completed-fields');

    // Load draft if exists
    loadDraft();

    // Template buttons
    document.querySelectorAll('.template-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            nameInput.value = this.dataset.name;
            descriptionInput.value = this.dataset.description;
            updatePreview();
            updateProgress();
            updateCounters();
        });
    });

    // Real-time updates
    nameInput.addEventListener('input', function() {
        updatePreview();
        updateProgress();
        updateCounters();
        saveDraftDebounced();
    });

    descriptionInput.addEventListener('input', function() {
        updatePreview();
        updateProgress();
        updateCounters();
        saveDraftDebounced();
    });

    // Save draft functionality
    let draftTimeout;
    function saveDraftDebounced() {
        clearTimeout(draftTimeout);
        draftTimeout = setTimeout(saveDraft, 1000);
    }

    function saveDraft() {
        const draftData = {
            name: nameInput.value,
            description: descriptionInput.value,
            timestamp: new Date().toISOString()
        };
        localStorage.setItem('category_draft', JSON.stringify(draftData));
    }

    function loadDraft() {
        const draft = localStorage.getItem('category_draft');
        if (draft) {
            const draftData = JSON.parse(draft);
            nameInput.value = draftData.name || '';
            descriptionInput.value = draftData.description || '';
            updatePreview();
            updateProgress();
            updateCounters();
        }
    }

    saveDraftBtn.addEventListener('click', function() {
        saveDraft();
        showSuccessToast();
    });

    function showSuccessToast() {
        successToast.classList.remove('translate-x-full');
        setTimeout(() => {
            successToast.classList.add('translate-x-full');
        }, 3000);
    }

    function updatePreview() {
        const name = nameInput.value.trim();
        const description = descriptionInput.value.trim();

        if (!name && !description) {
            previewContent.innerHTML = `
                <div class="text-center text-gray-500">
                    <i class="fas fa-tag text-4xl mb-3"></i>
                    <p>Completa el formulario para ver la vista previa</p>
                </div>
            `;
            return;
        }

        previewContent.innerHTML = `
            <div class="space-y-4">
                <div class="border-l-4 border-purple-500 pl-4">
                    <h4 class="font-semibold text-gray-800">${name || 'Nombre de la categoría'}</h4>
                    <p class="text-sm text-gray-600 mt-1">${description || 'Sin descripción'}</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Estado:</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Nueva</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-gray-600">Productos:</span>
                        <span class="text-gray-800">0 productos</span>
                    </div>
                </div>
            </div>
        `;
    }

    function updateProgress() {
        let completed = 0;
        const total = 2;

        if (nameInput.value.trim()) completed++;
        if (descriptionInput.value.trim()) completed++;

        const percentage = (completed / total) * 100;
        progressBar.style.width = percentage + '%';
        progressText.textContent = Math.round(percentage) + '% completado';
        completedFields.textContent = `${completed}/${total}`;

        // Enable/disable submit button
        submitBtn.disabled = completed < 1; // At least name is required
    }

    function updateCounters() {
        const nameLength = nameInput.value.length;
        const descriptionLength = descriptionInput.value.length;

        nameCounter.textContent = `${nameLength}/255`;
        descriptionCounter.textContent = `${descriptionLength}/500`;
        nameChars.textContent = nameLength;
        descriptionChars.textContent = descriptionLength;

        // Update colors based on length
        nameCounter.className = nameLength > 200 ? 'absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-orange-500' : 'absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-gray-500';
        descriptionCounter.className = descriptionLength > 400 ? 'absolute bottom-2 right-2 text-xs text-orange-500 bg-white px-2' : 'absolute bottom-2 right-2 text-xs text-gray-500 bg-white px-2';
    }

    // Form submission
    form.addEventListener('submit', function() {
        localStorage.removeItem('category_draft');
    });

    // Initial setup
    updatePreview();
    updateProgress();
    updateCounters();
});
</script>
@endsection
