@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Agregar Item al Carrito</h1>
            <p class="text-gray-600 mt-1">Complete los detalles del nuevo item</p>
        </div>
        <a href="{{ route('cart-items.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Volver a Lista
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('cart-items.store') }}" method="POST">
            @csrf
            
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
                            <option value="{{ $cart->id }}" {{ old('cart_id') == $cart->id ? 'selected' : '' }}>
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
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
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
                           value="{{ old('quantity', 1) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('quantity') border-red-500 @enderror" 
                           required>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Stock disponible: <span id="available-stock">-</span></p>
                </div>

                <!-- Precio Unitario -->
                <div>
                    <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign text-yellow-500 mr-1"></i>
                        Precio Unitario *
                    </label>
                    <input type="number" name="unit_price" id="unit_price" min="0" step="0.01"
                           value="{{ old('unit_price') }}"
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
                        $0.00
                    </div>
                </div>

                <!-- Información del Producto Seleccionado -->
                <div class="md:col-span-2" id="product-info" style="display: none;">
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">Información del Producto</h3>
                        <div class="grid md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-blue-600 font-medium">Precio actual:</span>
                                <span id="product-price" class="text-blue-900">-</span>
                            </div>
                            <div>
                                <span class="text-blue-600 font-medium">Stock disponible:</span>
                                <span id="product-stock" class="text-blue-900">-</span>
                            </div>
                            <div>
                                <span class="text-blue-600 font-medium">Estado:</span>
                                <span id="product-status" class="text-blue-900">-</span>
                            </div>
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
                    <i class="fas fa-shopping-cart"></i>
                    Agregar al Carrito
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
    const productInfo = document.getElementById('product-info');
    const productPrice = document.getElementById('product-price');
    const productStock = document.getElementById('product-stock');
    const productStatus = document.getElementById('product-status');

    // Auto-fill price and show product info when product is selected
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const price = selectedOption.getAttribute('data-price');
            const stock = selectedOption.getAttribute('data-stock');
            
            unitPriceInput.value = price;
            availableStock.textContent = stock;
            
            // Update product info panel
            productPrice.textContent = '$' + parseFloat(price).toFixed(2);
            productStock.textContent = stock;
            productStatus.textContent = stock > 0 ? 'Disponible' : 'Sin stock';
            productStatus.className = stock > 0 ? 'text-green-600 font-medium' : 'text-red-600 font-medium';
            
            // Update quantity max
            quantityInput.max = stock;
            
            productInfo.style.display = 'block';
            calculateTotal();
        } else {
            unitPriceInput.value = '';
            availableStock.textContent = '-';
            productInfo.style.display = 'none';
            totalDisplay.textContent = '$0.00';
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

    // Initial calculation
    calculateTotal();
});
</script>
@endsection