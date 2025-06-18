@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-medium text-gray-800">Nueva Categoría</h1>
                <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>

            <!-- Simple Progress Bar -->
            <div class="mb-6">
                <div class="h-1 w-full bg-gray-100 rounded overflow-hidden">
                    <div id="progress-bar" class="h-1 bg-blue-900 transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <form id="category-form" action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre
                    </label>
                    <input type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}" 
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm
                            focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-blue-900
                            @error('name') border-red-500 @enderror" 
                        placeholder="Nombre de la categoría"
                        required>
                    <div class="flex justify-between items-center mt-1">
                        <div class="text-xs text-gray-500" id="name-counter">0/255</div>
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description Field -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Descripción
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="4" 
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm
                            focus:outline-none focus:ring-1 focus:ring-blue-900 focus:border-blue-900
                            @error('description') border-red-500 @enderror" 
                        placeholder="Descripción">{{ old('description') }}</textarea>
                    <div class="flex justify-between items-center mt-1">
                        <div class="text-xs text-gray-500" id="description-counter">0/500</div>
                        @error('description')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 border-t border-gray-200">
                    <button type="submit" id="submit-btn" 
                        class="w-full bg-gray-900 text-white px-4 py-2 rounded-md hover:bg-gray-800 
                        focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 
                        disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200">
                        Crear Categoría
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('category-form');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const progressBar = document.getElementById('progress-bar');
    const submitBtn = document.getElementById('submit-btn');

    // Character counters
    const nameCounter = document.getElementById('name-counter');
    const descriptionCounter = document.getElementById('description-counter');

    // Real-time updates
    nameInput.addEventListener('input', updateAll);
    descriptionInput.addEventListener('input', updateAll);

    function updateAll() {
        updateProgress();
        updateCounters();
    }

    function updateProgress() {
        const hasName = nameInput.value.trim().length > 0;
        const progress = hasName ? 100 : 0;
        progressBar.style.width = `${progress}%`;
        submitBtn.disabled = !hasName;
    }

    function updateCounters() {
        const nameLength = nameInput.value.length;
        const descriptionLength = descriptionInput.value.length;

        nameCounter.textContent = `${nameLength}/255`;
        descriptionCounter.textContent = `${descriptionLength}/500`;

        // Update counter colors when approaching limits
        nameCounter.classList.toggle('text-red-600', nameLength > 200);
        descriptionCounter.classList.toggle('text-red-600', descriptionLength > 400);
    }

    // Form submission
    form.addEventListener('submit', function() {
        localStorage.removeItem('category_draft');
    });

    // Initial setup
    updateAll();
});
</script>
@endsection
