@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Editar Item del Carrito</h1>
            <p class="text-gray-600 mt-1">Modifique los detalles del item #{{ $cartItem->id }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('cart-items.show', $cartItem->id) }}" 
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                <i class="fas fa-eye"></i>
                Ver Item
            </a>
            <a href="{{ route('cart-items.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Volver a Lista
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('cart-items.update', $cartItem->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Carrito -->
                <div class="md:col-span-2">
                    <label for="cart_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-shopping-cart text-blue-500 mr-1"></i>
                        Carrito *
                    </label>
                    <select name="cart_id" id="cart_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('cart_id') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione un carrito</option>
                        @foreach($carts as $cart)
                            <option value="{{ $cart->id }}" 
                                    {{ (old('cart_id', $cartItem->cart_id) == $cart->id) ? 'selected' : '' }}>
                                Carrito #{{ $cart->id }} 
                                @if($cart->user)
                                    - {{ $cart->user->name }}
                                @endif
                                ({{ $cart->cartItems->count() }} items)
                            </option>
                        @endforeach
                    </select>
                    @error('cart_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Producto -->
                <div class="md:col-span-2">
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-box text-green-500 mr-1"></i>
                        Producto *
                    </label>
                    <select name="product_id" id="product_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('product_id') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione un producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $product->stock_quantity }}"
                                    {{ (old('product_id', $cartItem->product_id) == $product->id) ? 'selected' : '' }}>
                                {{ $product->name }} - ${{ number_format($product->price, 2) }} 
                                @if($product->stock_quantity > 0)
                                    (Stock: {{ $product->stock_quantity }})
                                @else
                                    <span class="text-red-500">(Sin stock)</span>
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cantidad -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-sort-numeric-up text-purple-500 mr-1"></i>
                        Cantidad *
                    </label>
                    <input type="number" name="quantity" id="quantity" min="1" step="1"
                           value="{{ old('quantity', $cartItem->quantity) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('quantity') border-red-500 @enderror" 
                           required>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Stock disponible: <span id="available-stock">{{ $cartItem->product ? $cartItem->product->stock_quantity : '-' }}</span></p>
                </div>

                <!-- Precio Unitario -->
                <div>
                    <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign text-yellow-500 mr-1"></i>
                        Precio Unitario *
                    </label>
                    <input type="number" name="unit_price" id="unit_price" min="0" step="0.01"
                           value="{{ old('unit_price', $cartItem->unit_price) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('unit_price') border-red-500 @enderror" 
                           required>
                    @error('unit_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total (calculado automáticamente) -->
                <div class="md:col-span-2">
                    <label for="total_display" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calculator text-red-500 mr-1"></i>
                        Total Calculado
                    </label>
                    <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-lg font-semibold text-green-600" 
                         id="total_display">
                        ${{ number_format($cartItem->quantity * $cartItem->unit_price, 2) }}
                    </div>
                </div>

                <!-- Información del Producto Seleccionado -->
                <div class="md:col-span-2" id="product-info">
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">Información del Producto</h3>
                        <div class="grid md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-blue-600 font-medium">Precio actual:</span>
                                <span id="product-price" class="text-blue-900">
                                    @if($cartItem->product)
                                        ${{ number_format($cartItem->product->price, 2) }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="text-blue-600 font-medium">Stock disponible:</span>
                                <span id="product-stock" class="text-blue-900">
                                    {{ $cartItem->product ? $cartItem->product->stock_quantity : '-' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-blue-600 font-medium">Estado:</span>
                                <span id="product-status" class="text-blue-900">
                                    @if($cartItem->product)
                                        @if($cartItem->product->stock_quantity > 0)
                                            <span class="text-green-600 font-medium">Disponible</span>
                                        @else
                                            <span class="text-red-600 font-medium">Sin stock</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                        @if($cartItem->product && $cartItem->unit_price != $cartItem->product->price)
                            <div class="mt-3 p-2 bg-yellow-100 border border-yellow-300 rounded">
                                <p class="text-yellow-800 text-sm">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    El precio del item ({{ number_format($cartItem->unit_price, 2) }}) difiere del precio actual del producto ({{ number_format($cartItem->product->price, 2) }})
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Información de timestamps -->
                <div class="md:col-span-2 mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Información del Registro</h3>
                    <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <strong>Creado:</strong> {{ $cartItem->created_at ? $cartItem->created_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </div>
                        <div>
                            <strong>Actualizado:</strong> {{ $cartItem->updated_at ? $cartItem->updated_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('cart-items.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Actualizar Item
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const totalDisplay = document.getElementById('total_display');
    const availableStock = document.getElementById('available-stock');
    const productPrice = document.getElementById('product-price');
    const productStock = document.getElementById('product-stock');
    const productStatus = document.getElementById('product-status');

    // Auto-fill price and show product info when product is selected
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const price = selectedOption.getAttribute('data-price');
            const stock = selectedOption.getAttribute('data-stock');
            
            availableStock.textContent = stock;
            
            // Update product info panel
            productPrice.textContent = '$' + parseFloat(price).toFixed(2);
            productStock.textContent = stock;
            productStatus.innerHTML = stock > 0 ? 
                '<span class="text-green-600 font-medium">Disponible</span>' : 
                '<span class="text-red-600 font-medium">Sin stock</span>';
            
            // Update quantity max
            quantityInput.max = stock;
            
            calculateTotal();
        } else {
            availableStock.textContent = '-';
            productPrice.textContent = '-';
            productStock.textContent = '-';
            productStatus.textContent = '-';
            quantityInput.removeAttribute('max');
        }
    });

    // Calculate total when quantity or price changes
    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalDisplay.textContent = '$' + total.toFixed(2);
    }

    // Validate quantity against stock
    quantityInput.addEventListener('input', function() {
        const stock = parseInt(availableStock.textContent) || 0;
        const quantity = parseInt(this.value) || 0;
        
        if (quantity > stock && stock > 0) {
            this.setCustomValidity('La cantidad no puede ser mayor al stock disponible (' + stock + ')');
        } else {
            this.setCustomValidity('');
        }
        
        calculateTotal();
    });

    unitPriceInput.addEventListener('input', calculateTotal);

    // Initial setup
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    if (selectedOption.value) {
        const stock = selectedOption.getAttribute('data-stock');
        quantityInput.max = stock;
    }

    // Initial calculation
    calculateTotal();
});
</script>
@endsection