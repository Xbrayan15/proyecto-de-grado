@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header Section -->
    <div class="mb-8 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 rounded-xl p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Gestión de Productos</h1>
                <p class="text-gray-200">Administra tu catálogo de productos</p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white/20 rounded-lg p-4">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                        <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Productos</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $products->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm-.75-7.25a.75.75 0 000 1.5h2.5a.75.75 0 000-1.5h-2.5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Productos Activos</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $products->where('active', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Stock Total</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $products->sum('quantity') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sin Stock</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $products->where('quantity', 0)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex flex-col sm:flex-row gap-4 flex-1">
                <!-- Search -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" id="product-search" placeholder="Buscar productos..." 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Category Filter -->
                <div class="relative w-48">
                    <select id="categoryFilter" class="block w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Stock Filter -->
                <div class="relative w-40">
                    <select id="stockFilter" class="block w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Stock</option>
                        <option value="in_stock">En stock</option>
                        <option value="low_stock">Stock bajo</option>
                        <option value="out_of_stock">Sin stock</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="relative w-40">
                    <select id="statusFilter" class="block w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Estado</option>
                        <option value="active">Activos</option>
                        <option value="inactive">Inactivos</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button onclick="clearFilters()" class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Limpiar
                </button>
                <a href="{{ route('products.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nuevo Producto
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6" id="successMessage">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Lista de Productos</h3>
                <div class="text-sm text-gray-500">
                    Mostrando <span id="showingCount">{{ $products->count() }}</span> productos en total
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable('id')">
                            <div class="flex items-center space-x-1">
                                <span>Imagen</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable('code')">
                            <div class="flex items-center space-x-1">
                                <span>Código</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable('name')">
                            <div class="flex items-center space-x-1">
                                <span>Nombre</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="productsTableBody">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition duration-200 product-row">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-12 w-12 rounded-lg object-cover">
                                @else
                                    <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $product->category->name ?? 'Sin categoría' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->quantity > 10 ? 'bg-green-100 text-green-800' : ($product->quantity > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($product->active && $product->quantity > 0)
                                        <button onclick="addToCart({{ $product->id }})" class="text-green-600 hover:text-green-900" title="Agregar al carrito">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </button>
                                    @else
                                        <span class="text-gray-400" title="No disponible">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </span>
                                    @endif
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar este producto?')" title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No hay productos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add to Cart Modal -->
<div id="addToCartModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <i class="fas fa-cart-plus text-green-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Agregar al Carrito</h3>
            <div class="mt-4 px-7 py-3">
                <p class="text-sm text-gray-500" id="productInfo"></p>
                
                <form id="addToCartForm" class="mt-4 space-y-4">
                    @csrf
                    <input type="hidden" id="selectedProductId" name="product_id">
                    
                    <div>
                        <label for="cartSelect" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Carrito</label>
                        <select id="cartSelect" name="cart_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Seleccione un carrito...</option>
                            <option value="new">+ Crear nuevo carrito</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </form>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmAddToCart" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-200">
                    Agregar al Carrito
                </button>
                <button id="cancelAddToCart" class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none transition duration-200">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedProduct = null;

// Load active carts when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadActiveCarts();
});

async function loadActiveCarts() {
    try {
        const response = await fetch('/api/carts/active', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('Unauthorized');
            }
            throw new Error('Failed to load carts');
        }
        
        const carts = await response.json();
        
        const cartSelect = document.getElementById('cartSelect');
        // Keep the default options
        const defaultOptions = cartSelect.innerHTML;
        cartSelect.innerHTML = defaultOptions;
        
        // Add active carts
        if (carts && carts.length > 0) {
            carts.forEach(cart => {
                const option = document.createElement('option');
                option.value = cart.id;
                option.textContent = `Carrito #${cart.id} (${cart.items_count || 0} items)`;
                cartSelect.insertBefore(option, cartSelect.lastElementChild);
            });
        }
    } catch (error) {
        console.error('Error loading carts:', error);
        // Show user-friendly message if not authenticated
        if (error.message.includes('Unauthorized')) {
            const cartSelect = document.getElementById('cartSelect');
            cartSelect.innerHTML = '<option value="">Inicia sesión para ver tus carritos</option>';
        }
    }
}

function addToCart(productId) {
    selectedProduct = productId;
    
    // Find product info from the table
    const productRow = document.querySelector(`tr:has(button[onclick="addToCart(${productId})"])`);
    if (productRow) {
        const productName = productRow.cells[2].textContent.trim();
        const productPrice = productRow.cells[4].textContent.trim();
        const productStock = productRow.cells[5].textContent.trim();
        
        document.getElementById('productInfo').textContent = 
            `${productName} - ${productPrice} (Stock: ${productStock})`;
    }
    
    document.getElementById('selectedProductId').value = productId;
    document.getElementById('addToCartModal').classList.remove('hidden');
}

document.getElementById('confirmAddToCart').addEventListener('click', async function() {
    const cartId = document.getElementById('cartSelect').value;
    const quantity = document.getElementById('quantity').value;
    
    if (!cartId) {
        alert('Por favor seleccione un carrito');
        return;
    }
    
    try {
        // Show loading state
        const confirmButton = document.getElementById('confirmAddToCart');
        const originalText = confirmButton.textContent;
        confirmButton.textContent = 'Agregando...';
        confirmButton.disabled = true;
        
        // Use the new secure API endpoint
        const response = await fetch('/api/carts/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                cart_id: cartId === 'new' ? null : cartId,
                product_id: selectedProduct,
                quantity: parseInt(quantity),
                create_new_cart: cartId === 'new'
            })
        });
        
        const result = await response.json();
        
        if (response.ok) {
            // Show success message
            const successDiv = document.createElement('div');
            successDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4';
            successDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>${result.message || 'Producto agregado al carrito exitosamente'}</span>
                    <a href="/checkout" class="ml-3 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition duration-200">
                        Checkout
                    </a>
                </div>
            `;
            document.querySelector('.container').insertBefore(successDiv, document.querySelector('.bg-white'));
            
            // Auto remove success message
            setTimeout(() => successDiv.remove(), 4000);
            
            // Close modal
            document.getElementById('addToCartModal').classList.add('hidden');
            
            // Reset form
            document.getElementById('quantity').value = 1;
            document.getElementById('cartSelect').value = '';
            
            // Reload carts
            loadActiveCarts();
        } else {
            alert('Error: ' + (result.message || 'No se pudo agregar el producto al carrito'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar la solicitud. Por favor, inicia sesión e intenta de nuevo.');
    } finally {
        // Reset button state
        const confirmButton = document.getElementById('confirmAddToCart');
        confirmButton.textContent = originalText;
        confirmButton.disabled = false;
    }
});

document.getElementById('cancelAddToCart').addEventListener('click', function() {
    document.getElementById('addToCartModal').classList.add('hidden');
    document.getElementById('quantity').value = 1;
    document.getElementById('cartSelect').value = '';
});

// Close modal when clicking outside
document.getElementById('addToCartModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('product-search');
    const categoryFilter = document.getElementById('categoryFilter');
    const stockFilter = document.getElementById('stockFilter');
    const statusFilter = document.getElementById('statusFilter');
    const tableBody = document.getElementById('productsTableBody');
    const showingCount = document.getElementById('showingCount');
    
    let products = Array.from(document.querySelectorAll('.product-row')).map(row => ({
        element: row,
        code: row.querySelector('td:nth-child(2)').textContent,
        name: row.querySelector('td:nth-child(3)').textContent,
        category: row.querySelector('td:nth-child(4)').textContent,
        price: parseFloat(row.querySelector('td:nth-child(5)').textContent.replace('$', '').replace(',', '')),
        quantity: parseInt(row.querySelector('td:nth-child(6)').textContent),
        status: row.querySelector('td:nth-child(7)').textContent.trim()
    }));

    const originalProducts = [...products];

    function filterProducts() {
        let filtered = [...originalProducts];
        
        // Apply search filter
        const searchTerm = searchInput.value.toLowerCase();
        if (searchTerm) {
            filtered = filtered.filter(product => 
                product.name.toLowerCase().includes(searchTerm) ||
                product.code.toLowerCase().includes(searchTerm) ||
                product.category.toLowerCase().includes(searchTerm)
            );
        }

        // Apply category filter
        if (categoryFilter.value) {
            filtered = filtered.filter(product => 
                product.category === categoryFilter.options[categoryFilter.selectedIndex].text
            );
        }

        // Apply stock filter
        switch (stockFilter.value) {
            case 'in_stock':
                filtered = filtered.filter(p => p.quantity > 10);
                break;
            case 'low_stock':
                filtered = filtered.filter(p => p.quantity > 0 && p.quantity <= 10);
                break;
            case 'out_of_stock':
                filtered = filtered.filter(p => p.quantity === 0);
                break;
        }

        // Apply status filter
        switch (statusFilter.value) {
            case 'active':
                filtered = filtered.filter(p => p.status === 'Activo');
                break;
            case 'inactive':
                filtered = filtered.filter(p => p.status === 'Inactivo');
                break;
        }

        // Update table
        tableBody.innerHTML = '';
        if (filtered.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">No se encontraron productos</td>
                </tr>
            `;
        } else {
            filtered.forEach(product => {
                tableBody.appendChild(product.element);
            });
        }

        // Update counter
        showingCount.textContent = filtered.length + ' productos filtrados';
    }

    // Event listeners
    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);
    stockFilter.addEventListener('change', filterProducts);
    statusFilter.addEventListener('change', filterProducts);
    
    // Clear filters
    window.clearFilters = function() {
        searchInput.value = '';
        categoryFilter.value = '';
        stockFilter.value = '';
        statusFilter.value = '';
        filterProducts();
    }

    // Sort table by column
    window.sortTable = function(column) {
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const direction = tableBody.dataset.sortDirection === 'asc' ? -1 : 1;
        
        rows.sort((a, b) => {
            let aValue, bValue;
            
            switch (column) {
                case 'code':
                    aValue = a.cells[1].textContent;
                    bValue = b.cells[1].textContent;
                    break;
                case 'name':
                    aValue = a.cells[2].querySelector('.text-gray-900').textContent;
                    bValue = b.cells[2].querySelector('.text-gray-900').textContent;
                    break;
                default:
                    return 0;
            }
            
            return aValue.localeCompare(bValue) * direction;
        });
        
        tableBody.dataset.sortDirection = direction === 1 ? 'asc' : 'desc';
        
        // Reattach sorted rows
        rows.forEach(row => tableBody.appendChild(row));
    }

    // Initial setup
    updateFilters();
});

// Auto-hide success message
if (document.getElementById('successMessage')) {
    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        successMessage.style.transition = 'opacity 0.5s ease-in-out';
        successMessage.style.opacity = '0';
        setTimeout(() => successMessage.remove(), 500);
    }, 3000);
}
</script>
@endpush
