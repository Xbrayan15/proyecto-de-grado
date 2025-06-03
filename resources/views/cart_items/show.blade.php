@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detalles del Item del Carrito</h1>
            <p class="text-gray-600 mt-1">Item #{{ $cartItem->id }} en Carrito #{{ $cartItem->cart_id }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('cart-items.edit', $cartItem->id) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                <i class="fas fa-edit"></i>
                Editar
            </a>
            <form action="{{ route('cart-items.destroy', $cartItem->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('¿Está seguro de que desea eliminar este item del carrito?')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    Eliminar
                </button>
            </form>
            <a href="{{ route('cart-items.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Volver a Lista
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Información Principal del Item -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-basket text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Información del Item</h2>
                        <p class="text-gray-600">Detalles completos del item del carrito</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- ID -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-hashtag text-gray-500"></i>
                            <span class="text-sm font-medium text-gray-700">ID del Item</span>
                        </div>
                        <p class="text-lg font-semibold text-gray-900">#{{ $cartItem->id }}</p>
                    </div>

                    <!-- Cantidad -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-sort-numeric-up text-purple-500"></i>
                            <span class="text-sm font-medium text-gray-700">Cantidad</span>
                        </div>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($cartItem->quantity) }}</p>
                    </div>

                    <!-- Precio Unitario -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-dollar-sign text-yellow-500"></i>
                            <span class="text-sm font-medium text-gray-700">Precio Unitario</span>
                        </div>
                        <p class="text-lg font-semibold text-green-600">${{ number_format($cartItem->unit_price, 2) }}</p>
                    </div>

                    <!-- Total -->
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-calculator text-green-500"></i>
                            <span class="text-sm font-medium text-gray-700">Total</span>
                        </div>
                        <p class="text-xl font-bold text-green-600">${{ number_format($cartItem->quantity * $cartItem->unit_price, 2) }}</p>
                    </div>
                </div>

                <!-- Comparación de Precios -->
                @if($cartItem->product && $cartItem->unit_price != $cartItem->product->price)
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h3 class="text-sm font-medium text-yellow-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            Comparación de Precios
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-yellow-700">Precio en carrito:</p>
                                <p class="text-lg font-semibold text-yellow-900">${{ number_format($cartItem->unit_price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-yellow-700">Precio actual del producto:</p>
                                <p class="text-lg font-semibold text-yellow-900">${{ number_format($cartItem->product->price, 2) }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-yellow-700 mt-2">
                            @if($cartItem->unit_price > $cartItem->product->price)
                                El precio ha bajado desde que se agregó al carrito.
                            @else
                                El precio ha subido desde que se agregó al carrito.
                            @endif
                        </p>
                    </div>
                @endif

                <!-- Timestamps -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de Registro</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-calendar-plus text-blue-500"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Fecha de Agregado</p>
                                <p class="text-gray-900">{{ $cartItem->created_at ? $cartItem->created_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-calendar-alt text-green-500"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Última Actualización</p>
                                <p class="text-gray-900">{{ $cartItem->updated_at ? $cartItem->updated_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Información del Carrito -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Carrito</h3>
                </div>
                
                @if($cartItem->cart)
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID:</span>
                            <span class="font-semibold">#{{ $cartItem->cart->id }}</span>
                        </div>
                        @if($cartItem->cart->user)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Usuario:</span>
                                <span class="font-semibold">{{ $cartItem->cart->user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-semibold text-sm">{{ $cartItem->cart->user->email }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Items:</span>
                            <span class="font-semibold">{{ $cartItem->cart->cartItems->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Valor Total:</span>
                            <span class="font-semibold text-green-600">
                                ${{ number_format($cartItem->cart->cartItems->sum(function($item) { return $item->quantity * $item->unit_price; }), 2) }}
                            </span>
                        </div>
                        <a href="{{ route('carts.show', $cartItem->cart->id) }}" 
                           class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition duration-200 mt-4">
                            Ver Carrito Completo
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 italic">No hay información del carrito disponible</p>
                @endif
            </div>

            <!-- Información del Producto -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Producto</h3>
                </div>
                
                @if($cartItem->product)
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nombre:</span>
                            <span class="font-semibold">{{ $cartItem->product->name }}</span>
                        </div>
                        @if($cartItem->product->sku)
                            <div class="flex justify-between">
                                <span class="text-gray-600">SKU:</span>
                                <span class="font-semibold">{{ $cartItem->product->sku }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Precio Actual:</span>
                            <span class="font-semibold text-green-600">${{ number_format($cartItem->product->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Stock:</span>
                            <span class="font-semibold {{ $cartItem->product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $cartItem->product->stock_quantity }}
                            </span>
                        </div>
                        @if($cartItem->product->category)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Categoría:</span>
                                <span class="font-semibold">{{ $cartItem->product->category->name }}</span>
                            </div>
                        @endif
                        <a href="{{ route('products.show', $cartItem->product->id) }}" 
                           class="block w-full text-center bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg transition duration-200 mt-4">
                            Ver Producto
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 italic">Producto no disponible (posiblemente eliminado)</p>
                @endif
            </div>

            <!-- Estado del Stock -->
            @if($cartItem->product)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-warehouse text-purple-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Estado del Stock</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Stock Disponible:</span>
                            <span class="font-semibold {{ $cartItem->product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $cartItem->product->stock_quantity }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Cantidad en Carrito:</span>
                            <span class="font-semibold">{{ $cartItem->quantity }}</span>
                        </div>
                        @if($cartItem->quantity > $cartItem->product->stock_quantity)
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-red-800 text-sm">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    La cantidad en carrito excede el stock disponible
                                </p>
                            </div>
                        @elseif($cartItem->product->stock_quantity > 0)
                            <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                                <p class="text-green-800 text-sm">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Stock suficiente disponible
                                </p>
                            </div>
                        @else
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-red-800 text-sm">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Producto sin stock
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-orange-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Acciones Rápidas</h3>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('cart-items.create') }}" 
                       class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Nuevo Item
                    </a>
                    <a href="{{ route('cart-items.edit', $cartItem->id) }}" 
                       class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Editar Item
                    </a>
                    @if($cartItem->product && $cartItem->unit_price != $cartItem->product->price)
                        <button onclick="updatePrice()" 
                                class="block w-full text-center bg-purple-500 hover:bg-purple-600 text-white py-2 rounded-lg transition duration-200">
                            <i class="fas fa-sync mr-2"></i>Actualizar Precio
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($cartItem->product && $cartItem->unit_price != $cartItem->product->price)
<script>
function updatePrice() {
    if (confirm('¿Desea actualizar el precio de este item al precio actual del producto (${{ number_format($cartItem->product->price, 2) }})?')) {
        // Create a form to update the price
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("cart-items.update", $cartItem->id) }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        
        const priceInput = document.createElement('input');
        priceInput.type = 'hidden';
        priceInput.name = 'unit_price';
        priceInput.value = '{{ $cartItem->product->price }}';
        
        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = '{{ $cartItem->quantity }}';
        
        const cartInput = document.createElement('input');
        cartInput.type = 'hidden';
        cartInput.name = 'cart_id';
        cartInput.value = '{{ $cartItem->cart_id }}';
        
        const productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = '{{ $cartItem->product_id }}';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        form.appendChild(priceInput);
        form.appendChild(quantityInput);
        form.appendChild(cartInput);
        form.appendChild(productInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endif
@endsection