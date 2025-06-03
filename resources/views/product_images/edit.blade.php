@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar Imagen</h1>
                <p class="text-gray-600 mt-1">Actualiza la información de la imagen del producto</p>
            </div>
            <a href="{{ route('product-images.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver al listado
            </a>
        </div>
    </div>

    <!-- Current Image Preview -->
    <div class="bg-white rounded-lg shadow-sm border mb-6">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagen Actual</h3>
            <div class="flex items-start space-x-6">
                <div class="flex-shrink-0">
                    <img src="{{ $productImage->image_url }}" 
                         alt="{{ $productImage->alt_text }}" 
                         class="w-32 h-32 object-cover rounded-lg border">
                </div>
                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Producto:</span>
                            <p class="text-gray-900">{{ $productImage->product->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Orden:</span>
                            <p class="text-gray-900">{{ $productImage->display_order }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Estado:</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $productImage->is_primary ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $productImage->is_primary ? 'Principal' : 'Secundaria' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Tamaño:</span>
                            <p class="text-gray-900">{{ $productImage->file_size ? number_format($productImage->file_size / 1024, 1) . ' KB' : 'No disponible' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6">
            <form action="{{ route('product-images.update', $productImage) }}" method="POST" enctype="multipart/form-data" id="editImageForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Product Selection -->
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Producto <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id" id="product_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                    required>
                                <option value="">Seleccionar producto...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', $productImage->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - {{ $product->sku }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alt Text -->
                        <div>
                            <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-2">
                                Texto Alternativo
                            </label>
                            <input type="text" 
                                   name="alt_text" 
                                   id="alt_text" 
                                   value="{{ old('alt_text', $productImage->alt_text) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Descripción de la imagen para accesibilidad">
                            @error('alt_text')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Display Order -->
                        <div>
                            <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Orden de Visualización
                            </label>
                            <input type="number" 
                                   name="display_order" 
                                   id="display_order" 
                                   value="{{ old('display_order', $productImage->display_order) }}"
                                   min="0" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="0">
                            <p class="text-xs text-gray-500 mt-1">Menor número = mayor prioridad</p>
                            @error('display_order')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Primary -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_primary" 
                                       id="is_primary" 
                                       value="1" 
                                       {{ old('is_primary', $productImage->is_primary) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Imagen Principal</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1">Solo puede haber una imagen principal por producto</p>
                            @error('is_primary')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- New Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Reemplazar Imagen (Opcional)
                            </label>
                            <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                                <input type="file" 
                                       name="image" 
                                       id="imageInput" 
                                       accept="image/*" 
                                       class="hidden">
                                <div id="uploadPrompt">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600">Haz clic aquí o arrastra una imagen</p>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG hasta 2MB</p>
                                </div>
                                <div id="imagePreview" class="hidden">
                                    <img id="previewImg" class="mx-auto max-h-32 rounded-lg">
                                    <p id="fileName" class="text-sm text-gray-600 mt-2"></p>
                                    <button type="button" id="removeImage" class="text-red-500 text-sm hover:underline mt-1">
                                        Quitar imagen
                                    </button>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Image Info -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-2">Información Actual</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">URL:</span>
                                    <span class="text-gray-900 truncate ml-2">{{ basename($productImage->image_url) }}</span>
                                </div>
                                @if($productImage->file_size)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tamaño:</span>
                                    <span class="text-gray-900">{{ number_format($productImage->file_size / 1024, 1) }} KB</span>
                                </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Subida:</span>
                                    <span class="text-gray-900">{{ $productImage->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t">
                    <div class="flex space-x-3">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Actualizar Imagen
                        </button>
                        <a href="{{ route('product-images.show', $productImage) }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-eye mr-2"></i>
                            Ver Imagen
                        </a>
                    </div>
                    <form action="{{ route('product-images.destroy', $productImage) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta imagen?')"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const imageInput = document.getElementById('imageInput');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const fileName = document.getElementById('fileName');
    const removeImage = document.getElementById('removeImage');
    const isPrimaryCheckbox = document.getElementById('is_primary');

    // Click to upload
    dropZone.addEventListener('click', () => imageInput.click());

    // Drag and drop functionality
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });

    // File input change
    imageInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });

    // Remove image
    removeImage.addEventListener('click', () => {
        imageInput.value = '';
        uploadPrompt.classList.remove('hidden');
        imagePreview.classList.add('hidden');
    });

    // Handle file preview
    function handleFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('Por favor selecciona un archivo de imagen válido.');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('El archivo debe ser menor a 2MB.');
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            fileName.textContent = file.name;
            uploadPrompt.classList.add('hidden');
            imagePreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    // Primary image validation
    isPrimaryCheckbox.addEventListener('change', function() {
        if (this.checked) {
            const productId = document.getElementById('product_id').value;
            if (productId) {
                // Show warning about changing primary image
                if (!confirm('Esto marcará esta imagen como principal y desmarcará cualquier otra imagen principal del producto. ¿Continuar?')) {
                    this.checked = false;
                }
            }
        }
    });
});
</script>
@endsection