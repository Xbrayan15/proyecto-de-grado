@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Productos</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
            <i class="fas fa-plus mr-2"></i>Crear Producto
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-12 w-12 rounded-full object-cover">
                            @else
                                <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-box text-gray-500"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->category->name ?? 'Sin categoría' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->quantity > 10 ? 'bg-green-100 text-green-800' : ($product->quantity > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('products.show', $product->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($product->active && $product->quantity > 0)
                                    <button onclick="addToCart({{ $product->id }})" class="text-green-600 hover:text-green-900" title="Agregar al carrito">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                @else
                                    <span class="text-gray-400" title="No disponible">
                                        <i class="fas fa-cart-plus"></i>
                                    </span>
                                @endif
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar este producto?')" title="Eliminar">
                                        <i class="fas fa-trash"></i>
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
        if (error.message.includes('401') || error.message.includes('Unauthorized')) {
            const cartSelect = document.getElementById('cartSelect');
            cartSelect.innerHTML = '<option value="">Inicia sesión para ver tus carritos</option>';
        }
    }
}
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
</script>
@endsection
