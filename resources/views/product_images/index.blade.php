@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Imágenes de Productos</h1>
            <p class="text-gray-600 mt-1">Gestión de galería de imágenes de productos</p>
        </div>
        <a href="{{ route('product-images.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Nueva Imagen
        </a>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('product-images.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-64">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" 
                       name="search" 
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Buscar por producto, alt text..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="min-w-32">
                <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                <select name="product_id" id="product_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-32">
                <label for="is_primary" class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <select name="is_primary" id="is_primary" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todas</option>
                    <option value="1" {{ request('is_primary') === '1' ? 'selected' : '' }}>Principales</option>
                    <option value="0" {{ request('is_primary') === '0' ? 'selected' : '' }}>Secundarias</option>
                </select>
            </div>
            <button type="submit" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                <i class="fas fa-search"></i>
                Buscar
            </button>
            @if(request()->hasAny(['search', 'product_id', 'is_primary']))
                <a href="{{ route('product-images.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Imágenes</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $productImages->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-images text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Imágenes Principales</p>
                    <p class="text-2xl font-bold text-green-600">{{ $productImages->where('is_primary', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Productos con Imágenes</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $products->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Orden Promedio</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $productImages->count() > 0 ? round($productImages->avg('sort_order'), 1) : 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-sort-numeric-up text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista de Galería -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">Galería de Imágenes</h2>
            <div class="flex gap-2">
                <button onclick="toggleView('grid')" id="grid-btn" 
                        class="px-3 py-2 text-sm bg-blue-500 text-white rounded-lg transition duration-200">
                    <i class="fas fa-th"></i> Vista Cuadrícula
                </button>
                <button onclick="toggleView('list')" id="list-btn" 
                        class="px-3 py-2 text-sm bg-gray-300 text-gray-700 rounded-lg transition duration-200">
                    <i class="fas fa-list"></i> Vista Lista
                </button>
            </div>
        </div>

        <!-- Vista de Cuadrícula -->
        <div id="grid-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($productImages as $image)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <!-- Imagen -->
                    <div class="relative aspect-square bg-gray-100">
                        @if($image->image_url)
                            <img src="{{ $image->image_url }}" 
                                 alt="{{ $image->alt_text }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        
                        <!-- Badges -->
                        <div class="absolute top-2 left-2">
                            @if($image->is_primary)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-star mr-1"></i>Principal
                                </span>
                            @endif
                        </div>
                        
                        <div class="absolute top-2 right-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                #{{ $image->sort_order }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Información -->
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-box text-green-500"></i>
                            <h3 class="font-semibold text-gray-900 truncate">
                                {{ $image->product->name ?? 'Producto eliminado' }}
                            </h3>
                        </div>
                        
                        @if($image->alt_text)
                            <p class="text-sm text-gray-600 mb-3">{{ $image->alt_text }}</p>
                        @endif
                        
                        <div class="text-xs text-gray-500 mb-3">
                            ID: #{{ $image->id }} | 
                            {{ $image->created_at ? $image->created_at->format('d/m/Y') : 'N/A' }}
                        </div>
                        
                        <!-- Acciones -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('product-images.show', $image->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('product-images.edit', $image->id) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('product-images.destroy', $image->id) }}" 
                                      method="POST" 
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                            title="Eliminar"
                                            onclick="return confirm('¿Está seguro de que desea eliminar esta imagen?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @if($image->product)
                                <a href="{{ route('products.show', $image->product->id) }}" 
                                   class="text-green-600 hover:text-green-900 transition-colors duration-200 text-sm"
                                   title="Ver producto">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-12">
                    <i class="fas fa-images text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay imágenes</h3>
                    <p class="text-gray-500 mb-4">Comience agregando imágenes a sus productos</p>
                    <a href="{{ route('product-images.create') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                        <i class="fas fa-plus"></i>
                        Agregar Primera Imagen
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Vista de Lista (oculta por defecto) -->
        <div id="list-view" class="hidden overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Imagen
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Producto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Alt Text
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Orden
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($productImages as $image)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden">
                                    @if($image->image_url)
                                        <img src="{{ $image->image_url }}" 
                                             alt="{{ $image->alt_text }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $image->product->name ?? 'Producto eliminado' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    ID: {{ $image->product_id }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                    {{ $image->alt_text ?? 'Sin descripción' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($image->is_primary)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-star mr-1"></i>Principal
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Secundaria
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $image->sort_order }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $image->created_at ? $image->created_at->format('d/m/Y') : 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $image->created_at ? $image->created_at->format('H:i') : '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('product-images.show', $image->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('product-images.edit', $image->id) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('product-images.destroy', $image->id) }}" 
                                          method="POST" 
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                title="Eliminar"
                                                onclick="return confirm('¿Está seguro de que desea eliminar esta imagen?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($productImages->hasPages())
            <div class="mt-6 border-t border-gray-200 pt-4">
                {{ $productImages->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleView(view) {
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const gridBtn = document.getElementById('grid-btn');
    const listBtn = document.getElementById('list-btn');
    
    if (view === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.remove('bg-gray-300', 'text-gray-700');
        gridBtn.classList.add('bg-blue-500', 'text-white');
        listBtn.classList.remove('bg-blue-500', 'text-white');
        listBtn.classList.add('bg-gray-300', 'text-gray-700');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listBtn.classList.remove('bg-gray-300', 'text-gray-700');
        listBtn.classList.add('bg-blue-500', 'text-white');
        gridBtn.classList.remove('bg-blue-500', 'text-white');
        gridBtn.classList.add('bg-gray-300', 'text-gray-700');
    }
}
</script>
@endsection