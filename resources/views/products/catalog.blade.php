@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Catálogo de Productos</h1>
            <p class="text-xl md:text-2xl opacity-90 mb-8">Descubre nuestra amplia selección de productos</p>
            
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Buscar productos..." 
                           class="w-full px-6 py-4 rounded-full text-gray-800 text-lg focus:outline-none focus:ring-4 focus:ring-purple-300 transition duration-300">
                    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-purple-600 hover:text-purple-800 transition duration-300">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-wrap gap-4 items-center">
                <h3 class="text-lg font-semibold text-gray-800">Filtros:</h3>
                
                <select id="categoryFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                
                <select id="priceFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Cualquier precio</option>
                    <option value="0-50">$0 - $50</option>
                    <option value="50-100">$50 - $100</option>
                    <option value="100-200">$100 - $200</option>
                    <option value="200+">$200+</option>
                </select>
                
                <select id="sortFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="name">Nombre A-Z</option>
                    <option value="price-asc">Precio: Menor a Mayor</option>
                    <option value="price-desc">Precio: Mayor a Menor</option>
                    <option value="newest">Más Recientes</option>
                </select>
                
                <button id="clearFilters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                    <i class="fas fa-times mr-2"></i>Limpiar
                </button>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" id="productsGrid">
            @foreach($products as $product)
                <div class="product-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2" 
                     data-category="{{ $product->category_id }}" 
                     data-price="{{ $product->price }}" 
                     data-name="{{ strtolower($product->name) }}"
                     data-created="{{ $product->created_at }}">
                    
                    <!-- Product Image -->
                    <div class="relative">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        
                        <!-- Stock Badge -->
                        @if($product->quantity > 0)
                            <span class="absolute top-3 right-3 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                En Stock
                            </span>
                        @else
                            <span class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                Agotado
                            </span>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="mb-3">
                            @if($product->category)
                                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                        
                        @if($product->description)
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-2xl font-bold text-purple-600">
                                ${{ number_format($product->price, 2) }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Stock: {{ $product->quantity }}
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-center text-sm font-medium transition duration-300">
                                <i class="fas fa-eye mr-1"></i>Ver
                            </a>
                            
                            @if($product->active && $product->quantity > 0)
                                <button onclick="addToCart({{ $product->id }})" 
                                        class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                                    <i class="fas fa-cart-plus mr-1"></i>Agregar
                                </button>
                            @else
                                <button disabled 
                                        class="flex-1 bg-gray-300 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed">
                                    <i class="fas fa-ban mr-1"></i>No Disponible
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden text-center py-12">
            <div class="max-w-md mx-auto">
                <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No se encontraron productos</h3>
                <p class="text-gray-500 mb-4">Intenta ajustar tus filtros o buscar algo diferente</p>
                <button onclick="clearAllFilters()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition duration-300">
                    Ver Todos los Productos
                </button>
            </div>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
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
</div>

<script>
let selectedProduct = null;
let allProducts = [];

// Load data when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadActiveCarts();
    initializeProductsArray();
    setupEventListeners();
});

function initializeProductsArray() {
    const productCards = document.querySelectorAll('.product-card');
    allProducts = Array.from(productCards);
}

function setupEventListeners() {
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', debounce(filterProducts, 300));
    
    // Filter functionality
    document.getElementById('categoryFilter').addEventListener('change', filterProducts);
    document.getElementById('priceFilter').addEventListener('change', filterProducts);
    document.getElementById('sortFilter').addEventListener('change', filterProducts);
    document.getElementById('clearFilters').addEventListener('click', clearAllFilters);
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function filterProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const categoryFilter = document.getElementById('categoryFilter').value;
    const priceFilter = document.getElementById('priceFilter').value;
    const sortFilter = document.getElementById('sortFilter').value;

    let filteredProducts = allProducts.filter(product => {
        // Search filter
        const productName = product.dataset.name;
        const matchesSearch = productName.includes(searchTerm);

        // Category filter
        const productCategory = product.dataset.category;
        const matchesCategory = !categoryFilter || productCategory === categoryFilter;

        // Price filter
        const productPrice = parseFloat(product.dataset.price);
        let matchesPrice = true;
        if (priceFilter) {
            const [min, max] = priceFilter.split('-');
            if (max === '+') {
                matchesPrice = productPrice >= parseFloat(min);
            } else {
                matchesPrice = productPrice >= parseFloat(min) && productPrice <= parseFloat(max);
            }
        }

        return matchesSearch && matchesCategory && matchesPrice;
    });

    // Sort products
    filteredProducts.sort((a, b) => {
        switch (sortFilter) {
            case 'name':
                return a.dataset.name.localeCompare(b.dataset.name);
            case 'price-asc':
                return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            case 'price-desc':
                return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            case 'newest':
                return new Date(b.dataset.created) - new Date(a.dataset.created);
            default:
                return 0;
        }
    });

    // Display results
    const grid = document.getElementById('productsGrid');
    const emptyState = document.getElementById('emptyState');

    // Hide all products first
    allProducts.forEach(product => product.style.display = 'none');

    if (filteredProducts.length === 0) {
        grid.style.display = 'none';
        emptyState.classList.remove('hidden');
    } else {
        grid.style.display = 'grid';
        emptyState.classList.add('hidden');
        
        // Show filtered products in order
        filteredProducts.forEach((product, index) => {
            product.style.display = 'block';
            product.style.order = index;
        });
    }
}

function clearAllFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('priceFilter').value = '';
    document.getElementById('sortFilter').value = 'name';
    filterProducts();
}

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
        const defaultOptions = cartSelect.innerHTML;
        cartSelect.innerHTML = defaultOptions;
        
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
            cartSelect.innerHTML = '<option value="">Inicia sesión para agregar al carrito</option>';
        }
    }
}

function addToCart(productId) {
    selectedProduct = productId;
    
    const productCard = document.querySelector(`[data-product-id="${productId}"], .product-card:has(button[onclick="addToCart(${productId})"])`);
    if (productCard) {
        const productName = productCard.querySelector('h3').textContent.trim();
        const productPrice = productCard.querySelector('.text-2xl').textContent.trim();
        
        document.getElementById('productInfo').textContent = `${productName} - ${productPrice}`;
    }
    
    document.getElementById('selectedProductId').value = productId;
    document.getElementById('addToCartModal').classList.remove('hidden');
}

document.getElementById('confirmAddToCart').addEventListener('click', async function() {
    const cartId = document.getElementById('cartSelect').value;
    const quantity = document.getElementById('quantity').value;
    
    if (!cartId) {
        alert('Por favor seleccione un carrito o inicia sesión');
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
            // Success notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>${result.message || '¡Producto agregado al carrito!'}</span>
                    <a href="/checkout" class="ml-3 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition duration-200">
                        Checkout
                    </a>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => notification.classList.remove('translate-x-full'), 100);
            
            // Auto remove
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
            
            // Close modal and reset
            document.getElementById('addToCartModal').classList.add('hidden');
            document.getElementById('quantity').value = 1;
            document.getElementById('cartSelect').value = '';
            
            loadActiveCarts();
        } else {
            alert('Error: ' + (result.message || 'No se pudo agregar el producto al carrito. Por favor, inicia sesión e intenta de nuevo.'));
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
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
