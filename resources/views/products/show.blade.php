@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detalle del Producto #{{ $product->id }}</h1>
            <div class="flex gap-2">
                @if($product->active && $product->quantity > 0)
                    <button onclick="addToCart({{ $product->id }})" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-cart-plus mr-2"></i>Agregar al Carrito
                    </button>
                @else
                    <button disabled class="bg-gray-400 text-white font-bold py-2 px-4 rounded-lg cursor-not-allowed">
                        <i class="fas fa-ban mr-2"></i>No Disponible
                    </button>
                @endif
                <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Image -->
            <div class="lg:col-span-1">
                <div class="bg-gray-100 rounded-lg p-4">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg">
                    @else
                        <div class="w-full h-64 bg-gray-300 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-4xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Information -->
            <div class="lg:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Código</label>
                            <p class="mt-1 text-lg text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded">{{ $product->code }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $product->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categoría</label>
                            <p class="mt-1 text-lg text-gray-900">
                                @if($product->category)
                                    <a href="{{ route('categories.show', $product->category->id) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $product->category->name }}
                                    </a>
                                @else
                                    <span class="text-gray-500">Sin categoría</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                            <p class="mt-1 text-lg text-gray-900">
                                @if($product->supplier)
                                    <a href="{{ route('suppliers.show', $product->supplier->id) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $product->supplier->name }}
                                    </a>
                                @else
                                    <span class="text-gray-500">Sin proveedor</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio</label>
                            <p class="mt-1 text-2xl font-bold text-green-600">${{ number_format($product->price, 2) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock Disponible</label>
                            <p class="mt-1 text-lg">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $product->quantity > 10 ? 'bg-green-100 text-green-800' : ($product->quantity > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $product->quantity }} unidades
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de creación</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($product->description)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900">{{ $product->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Quick Purchase Section -->
                @if($product->active && $product->quantity > 0)
                    <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-green-800 mb-3">
                            <i class="fas fa-shopping-cart mr-2"></i>Compra Rápida
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <label for="quickQuantity" class="block text-sm font-medium text-green-700 mb-1">Cantidad</label>
                                <input type="number" id="quickQuantity" value="1" min="1" max="{{ $product->quantity }}" 
                                       class="w-full px-3 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-green-700 mb-1">Total</label>
                                <div class="text-2xl font-bold text-green-600" id="quickTotal">
                                    ${{ number_format($product->price, 2) }}
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <button onclick="addToCart({{ $product->id }})" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                    <i class="fas fa-cart-plus mr-2"></i>Agregar
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-green-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Stock disponible: {{ $product->quantity }} unidades
                        </div>
                    </div>
                @else
                    <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-red-800 mb-2">
                            <i class="fas fa-ban mr-2"></i>Producto No Disponible
                        </h3>
                        <p class="text-red-600">
                            @if(!$product->active)
                                Este producto está desactivado actualmente.
                            @elseif($product->quantity <= 0)
                                Este producto está agotado.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Images Gallery -->
        @if($product->images && $product->images->count() > 0)
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Galería de Imágenes</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                        <div class="bg-gray-100 rounded-lg p-2">
                            <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?? $product->name }}" 
                                 class="w-full h-32 object-cover rounded">
                            @if($image->is_primary)
                                <div class="mt-2">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Principal</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
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
                    <div class="bg-gray-50 p-3 rounded-lg mb-4">
                        <div class="flex items-center space-x-3">
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-12 h-12 rounded object-cover">
                            @else
                                <div class="w-12 h-12 bg-gray-300 rounded flex items-center justify-center">
                                    <i class="fas fa-box text-gray-500"></i>
                                </div>
                            @endif
                            <div class="flex-1 text-left">
                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-sm text-gray-600">${{ number_format($product->price, 2) }} c/u</p>
                            </div>
                        </div>
                    </div>
                    
                    <form id="addToCartForm" class="space-y-4">
                        @csrf
                        <input type="hidden" id="selectedProductId" name="product_id" value="{{ $product->id }}">
                        
                        <div>
                            <label for="cartSelect" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Carrito</label>
                            <select id="cartSelect" name="cart_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="">Seleccione un carrito...</option>
                                <option value="new">+ Crear nuevo carrito</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="modalQuantity" class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                            <input type="number" id="modalQuantity" name="quantity" value="1" min="1" max="{{ $product->quantity }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                        
                        <div class="bg-green-50 p-3 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-green-800">Total:</span>
                                <span class="text-lg font-bold text-green-600" id="modalTotal">${{ number_format($product->price, 2) }}</span>
                            </div>
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
const productPrice = {{ $product->price }};
const maxStock = {{ $product->quantity }};

// Load active carts when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadActiveCarts();
    
    // Setup quantity change listeners
    const quickQuantity = document.getElementById('quickQuantity');
    const modalQuantity = document.getElementById('modalQuantity');
    
    if (quickQuantity) {
        quickQuantity.addEventListener('input', updateQuickTotal);
    }
    
    if (modalQuantity) {
        modalQuantity.addEventListener('input', updateModalTotal);
    }
});

function updateQuickTotal() {
    const quantity = parseInt(document.getElementById('quickQuantity').value) || 1;
    const total = quantity * productPrice;
    document.getElementById('quickTotal').textContent = '$' + total.toFixed(2);
}

function updateModalTotal() {
    const quantity = parseInt(document.getElementById('modalQuantity').value) || 1;
    const total = quantity * productPrice;
    document.getElementById('modalTotal').textContent = '$' + total.toFixed(2);
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
    // Set quantity from quick purchase if available
    const quickQuantity = document.getElementById('quickQuantity');
    if (quickQuantity) {
        document.getElementById('modalQuantity').value = quickQuantity.value;
        updateModalTotal();
    }
    
    document.getElementById('addToCartModal').classList.remove('hidden');
}

document.getElementById('confirmAddToCart').addEventListener('click', async function() {
    const cartId = document.getElementById('cartSelect').value;
    const quantity = document.getElementById('modalQuantity').value;
    
    if (!cartId) {
        alert('Por favor seleccione un carrito');
        return;
    }
    
    if (parseInt(quantity) > maxStock) {
        alert(`La cantidad no puede exceder el stock disponible (${maxStock})`);
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
                product_id: {{ $product->id }},
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
                    <a href="/checkout" class="ml-4 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition duration-200">
                        Ir al Checkout
                    </a>
                </div>
            `;
            document.querySelector('.container').insertBefore(successDiv, document.querySelector('.max-w-4xl'));
            
            // Auto remove success message
            setTimeout(() => successDiv.remove(), 5000);
            
            // Close modal
            document.getElementById('addToCartModal').classList.add('hidden');
            
            // Reset form
            document.getElementById('modalQuantity').value = 1;
            document.getElementById('cartSelect').value = '';
            updateModalTotal();
            
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
    document.getElementById('modalQuantity').value = 1;
    document.getElementById('cartSelect').value = '';
    updateModalTotal();
});

// Close modal when clicking outside
document.getElementById('addToCartModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
@endsection
