@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Simple Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $category->name }}</h1>
        <div class="flex items-center justify-between">
            <p class="text-gray-600">{{ $category->description ?: 'Sin descripción disponible' }}</p>
            <div class="flex gap-3">
                <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-all duration-300">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Listado
                </a>
            </div>
        </div>
    </div>
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Productos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $category->products_count ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Productos Activos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $category->products->where('active', true)->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Valor Promedio</p>
                    <p class="text-2xl font-bold text-gray-900">${{ $category->products->avg('price') ? number_format($category->products->avg('price'), 2) : '0.00' }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <i class="fas fa-warehouse text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Stock Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $category->products->sum('quantity') ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-1">
            <!-- Category Information -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                    Información de la Categoría
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <span class="font-semibold text-gray-700 w-24">ID:</span>
                            <span class="text-gray-900 bg-gray-100 px-2 py-1 rounded">#{{ $category->id }}</span>
                        </div>
                        
                        <div class="flex items-start">
                            <span class="font-semibold text-gray-700 w-24">Nombre:</span>
                            <span class="text-gray-900">{{ $category->name }}</span>
                        </div>
                        
                        <div class="flex items-start">
                            <span class="font-semibold text-gray-700 w-24">Estado:</span>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                Activa
                            </span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <span class="font-semibold text-gray-700 w-24">Creada:</span>
                            <div class="text-gray-900">
                                <div>{{ $category->created_at->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-600">{{ $category->created_at->format('H:i:s') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <span class="font-semibold text-gray-700 w-24">Actualizada:</span>
                            <div class="text-gray-900">
                                <div>{{ $category->updated_at->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-600">{{ $category->updated_at->format('H:i:s') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <span class="font-semibold text-gray-700 w-24">Antigüedad:</span>
                            <span class="text-gray-900">{{ $category->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                @if($category->description)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-700 mb-2">Descripción:</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900 leading-relaxed">{{ $category->description }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Products in Category -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-box text-purple-600 mr-2"></i>
                        Productos en esta Categoría
                        <span class="bg-purple-100 text-purple-800 text-sm font-medium px-2.5 py-0.5 rounded-full ml-2">
                            {{ $category->products_count ?? 0 }}
                        </span>
                    </h2>
                </div>

                @if($category->products && $category->products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto" id="products-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" data-sort="code">
                                    Código <i class="fas fa-sort text-gray-400 ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" data-sort="name">
                                    Nombre <i class="fas fa-sort text-gray-400 ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" data-sort="price">
                                    Precio <i class="fas fa-sort text-gray-400 ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" data-sort="quantity">
                                    Stock <i class="fas fa-sort text-gray-400 ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="products-tbody">
                            @foreach($category->products as $product)
                            <tr class="product-row hover:bg-gray-50 transition-colors duration-200" 
                                data-active="{{ $product->active ? 'true' : 'false' }}"
                                data-code="{{ $product->code }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-quantity="{{ $product->quantity }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-{{ $product->active ? 'green' : 'red' }}-500 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-900">{{ $product->code }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    @if($product->description)
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($product->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-900 mr-2">{{ $product->quantity }}</span>
                                        <span class="text-xs px-2 py-1 rounded-full 
                                            {{ $product->quantity > 10 ? 'bg-green-100 text-green-800' : ($product->quantity > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $product->quantity > 10 ? 'Alto' : ($product->quantity > 0 ? 'Bajo' : 'Agotado') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if(Route::has('products.show'))
                                        <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endif
                                        @if(Route::has('products.edit'))
                                        <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-12">
                    <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay productos en esta categoría</h3>
                    <p class="text-gray-500 mb-4">Agrega productos para comenzar a organizar tu inventario.</p>
                    @if(Route::has('products.create'))
                    <a href="{{ route('products.create') }}?category={{ $category->id }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-300">
                        <i class="fas fa-plus mr-2"></i>
                        Agregar Primer Producto
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeDeleteModal()"></div>
        
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Eliminar Categoría
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            ¿Estás seguro de que deseas eliminar la categoría "<strong>{{ $category->name }}</strong>"? 
                            @if($category->products_count > 0)
                            Esta acción también afectará a los {{ $category->products_count }} productos asociados.
                            @endif
                            Esta acción no se puede deshacer.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar Definitivamente
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productRows = document.querySelectorAll('.product-row');
    const productsTable = document.getElementById('products-table');
    
    // Sorting functionality
    if (productsTable) {
        const sortableHeaders = productsTable.querySelectorAll('th[data-sort]');
        let currentSort = { column: null, direction: 'asc' };
        
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.dataset.sort;
                const tbody = document.getElementById('products-tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                // Update sort direction
                if (currentSort.column === column) {
                    currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSort.direction = 'asc';
                }
                currentSort.column = column;
                
                // Update header icons
                sortableHeaders.forEach(h => {
                    const icon = h.querySelector('i');
                    icon.className = 'fas fa-sort text-gray-400 ml-1';
                });
                
                const currentIcon = this.querySelector('i');
                currentIcon.className = `fas fa-sort-${currentSort.direction === 'asc' ? 'up' : 'down'} text-purple-600 ml-1`;
                
                // Sort rows
                rows.sort((a, b) => {
                    let aValue, bValue;
                    
                    switch(column) {
                        case 'code':
                            aValue = a.dataset.code;
                            bValue = b.dataset.code;
                            break;
                        case 'name':
                            aValue = a.dataset.name;
                            bValue = b.dataset.name;
                            break;
                        case 'price':
                            aValue = parseFloat(a.dataset.price);
                            bValue = parseFloat(b.dataset.price);
                            break;
                        case 'quantity':
                            aValue = parseInt(a.dataset.quantity);
                            bValue = parseInt(b.dataset.quantity);
                            break;
                    }
                    
                    if (typeof aValue === 'string') {
                        return currentSort.direction === 'asc' 
                            ? aValue.localeCompare(bValue)
                            : bValue.localeCompare(aValue);
                    } else {
                        return currentSort.direction === 'asc' 
                            ? aValue - bValue
                            : bValue - aValue;
                    }
                });
                
                // Re-append sorted rows
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    }
});

function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection
