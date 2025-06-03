@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detalles de la Imagen</h1>
                <p class="text-gray-600 mt-1">Información completa de la imagen del producto</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('product-images.edit', $productImage) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                <a href="{{ route('product-images.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al listado
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Image Display (2/3 width) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Vista de la Imagen</h3>
                        <div class="flex space-x-2">
                            <button onclick="openFullscreen()" 
                                    class="text-gray-500 hover:text-gray-700 transition-colors" 
                                    title="Ver en pantalla completa">
                                <i class="fas fa-expand"></i>
                            </button>
                            <a href="{{ $productImage->image_url }}" 
                               target="_blank" 
                               class="text-gray-500 hover:text-gray-700 transition-colors" 
                               title="Abrir en nueva pestaña">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <img id="mainImage" 
                             src="{{ $productImage->image_url }}" 
                             alt="{{ $productImage->alt_text }}" 
                             class="w-full max-h-96 object-contain rounded-lg border bg-gray-50">
                        
                        <!-- Primary Badge -->
                        @if($productImage->is_primary)
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold bg-blue-600 text-white rounded-full">
                                <i class="fas fa-star mr-1"></i>
                                Principal
                            </span>
                        </div>
                        @endif
                        
                        <!-- Display Order Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex px-3 py-1 text-sm font-medium bg-gray-800 text-white rounded-full">
                                Orden: {{ $productImage->display_order }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Image Actions -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <button onclick="downloadImage()" 
                                class="text-sm bg-green-100 text-green-800 px-3 py-1 rounded-lg hover:bg-green-200 transition-colors">
                            <i class="fas fa-download mr-1"></i>
                            Descargar
                        </button>
                        <button onclick="copyImageUrl()" 
                                class="text-sm bg-purple-100 text-purple-800 px-3 py-1 rounded-lg hover:bg-purple-200 transition-colors">
                            <i class="fas fa-copy mr-1"></i>
                            Copiar URL
                        </button>
                        <a href="{{ route('products.show', $productImage->product) }}" 
                           class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors">
                            <i class="fas fa-box mr-1"></i>
                            Ver Producto
                        </a>
                    </div>
                </div>
            </div>

            <!-- Other Images from Product -->
            @if($otherImages->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Otras imágenes del producto</h3>
                    <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
                        @foreach($otherImages as $otherImage)
                        <div class="relative group cursor-pointer" onclick="changeMainImage('{{ $otherImage->image_url }}', '{{ $otherImage->alt_text }}')">
                            <img src="{{ $otherImage->image_url }}" 
                                 alt="{{ $otherImage->alt_text }}" 
                                 class="w-full h-16 object-cover rounded-lg border hover:border-blue-400 transition-colors">
                            @if($otherImage->is_primary)
                            <div class="absolute -top-1 -right-1">
                                <i class="fas fa-star text-blue-600 text-xs"></i>
                            </div>
                            @endif
                            <a href="{{ route('product-images.show', $otherImage) }}" 
                               class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-200 flex items-center justify-center">
                                <i class="fas fa-eye text-white opacity-0 group-hover:opacity-100 transition-opacity"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Image Information (1/3 width) -->
        <div class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Básica</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">ID:</span>
                            <p class="text-gray-900">{{ $productImage->id }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">Producto:</span>
                            <p class="text-gray-900">{{ $productImage->product->name }}</p>
                            <p class="text-xs text-gray-500">SKU: {{ $productImage->product->sku }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">Texto Alternativo:</span>
                            <p class="text-gray-900">{{ $productImage->alt_text ?: 'No especificado' }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">Orden de Visualización:</span>
                            <p class="text-gray-900">{{ $productImage->display_order }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">Estado:</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $productImage->is_primary ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $productImage->is_primary ? 'Principal' : 'Secundaria' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical Information -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Técnica</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">URL:</span>
                            <p class="text-gray-900 text-sm break-all">{{ $productImage->image_url }}</p>
                        </div>
                        
                        @if($productImage->file_size)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Tamaño del archivo:</span>
                            <p class="text-gray-900">{{ number_format($productImage->file_size / 1024, 1) }} KB</p>
                        </div>
                        @endif
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">Fecha de subida:</span>
                            <p class="text-gray-900">{{ $productImage->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">Última actualización:</span>
                            <p class="text-gray-900">{{ $productImage->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Statistics -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas del Producto</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Total de imágenes:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $productImage->product->images->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Imagen principal:</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ $productImage->product->images->where('is_primary', true)->count() > 0 ? 'Sí' : 'No' }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Precio del producto:</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($productImage->product->price, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Stock disponible:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $productImage->product->stock_quantity }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
                    <div class="space-y-3">
                        <a href="{{ route('product-images.edit', $productImage) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>
                            Editar imagen
                        </a>
                        
                        @if(!$productImage->is_primary)
                        <form action="{{ route('product-images.update', $productImage) }}" method="POST" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $productImage->product_id }}">
                            <input type="hidden" name="alt_text" value="{{ $productImage->alt_text }}">
                            <input type="hidden" name="display_order" value="{{ $productImage->display_order }}">
                            <input type="hidden" name="is_primary" value="1">
                            <button type="submit" 
                                    onclick="return confirm('¿Marcar esta imagen como principal?')"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                <i class="fas fa-star mr-2"></i>
                                Marcar como principal
                            </button>
                        </form>
                        @endif
                        
                        <form action="{{ route('product-images.destroy', $productImage) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta imagen?')"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                <i class="fas fa-trash mr-2"></i>
                                Eliminar imagen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Modal -->
<div id="fullscreenModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center">
    <div class="relative max-w-full max-h-full">
        <button onclick="closeFullscreen()" 
                class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300 z-10">
            <i class="fas fa-times"></i>
        </button>
        <img id="fullscreenImage" 
             src="{{ $productImage->image_url }}" 
             alt="{{ $productImage->alt_text }}" 
             class="max-w-full max-h-full object-contain">
    </div>
</div>

<script>
function changeMainImage(imageUrl, altText) {
    document.getElementById('mainImage').src = imageUrl;
    document.getElementById('mainImage').alt = altText;
}

function openFullscreen() {
    document.getElementById('fullscreenModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeFullscreen() {
    document.getElementById('fullscreenModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function downloadImage() {
    const link = document.createElement('a');
    link.href = '{{ $productImage->image_url }}';
    link.download = '{{ basename($productImage->image_url) }}';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function copyImageUrl() {
    navigator.clipboard.writeText('{{ $productImage->image_url }}').then(() => {
        // Show a temporary success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check mr-1"></i>Copiado';
        button.classList.remove('bg-purple-100', 'text-purple-800');
        button.classList.add('bg-green-100', 'text-green-800');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-100', 'text-green-800');
            button.classList.add('bg-purple-100', 'text-purple-800');
        }, 2000);
    });
}

// Close fullscreen on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeFullscreen();
    }
});
</script>
@endsection