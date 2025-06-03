@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Editar Item de Orden</h1>
            <p class="text-gray-600 mt-1">Modifique los detalles del item #{{ $orderItem->id }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('order-items.show', $orderItem->id) }}" 
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                <i class="fas fa-eye"></i>
                Ver Item
            </a>
            <a href="{{ route('order-items.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Volver a Lista
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('order-items.update', $orderItem->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Orden -->
                <div class="md:col-span-2">
                    <label for="order_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-shopping-cart text-blue-500 mr-1"></i>
                        Orden *
                    </label>
                    <select name="order_id" id="order_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('order_id') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione una orden</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" 
                                    {{ (old('order_id', $orderItem->order_id) == $order->id) ? 'selected' : '' }}>
                                Orden #{{ $order->id }} - {{ $order->user->name ?? 'N/A' }} - ${{ number_format($order->total, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('order_id')
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
                                    {{ (old('product_id', $orderItem->product_id) == $product->id) ? 'selected' : '' }}>
                                {{ $product->name }} - ${{ number_format($product->price, 2) }} (Stock: {{ $product->stock_quantity }})
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
                           value="{{ old('quantity', $orderItem->quantity) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('quantity') border-red-500 @enderror" 
                           required>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio Unitario -->
                <div>
                    <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign text-yellow-500 mr-1"></i>
                        Precio Unitario *
                    </label>
                    <input type="number" name="unit_price" id="unit_price" min="0" step="0.01"
                           value="{{ old('unit_price', $orderItem->unit_price) }}"
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
                        ${{ number_format($orderItem->total, 2) }}
                    </div>
                </div>

                <!-- Información de timestamps -->
                <div class="md:col-span-2 mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Información del Registro</h3>
                    <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <strong>Creado:</strong> {{ $orderItem->created_at ? $orderItem->created_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </div>
                        <div>
                            <strong>Actualizado:</strong> {{ $orderItem->updated_at ? $orderItem->updated_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('order-items.index') }}" 
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

    // Auto-fill price when product is selected
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const price = selectedOption.getAttribute('data-price');
            unitPriceInput.value = price;
            calculateTotal();
        } else {
            unitPriceInput.value = '';
            totalDisplay.textContent = '$0.00';
        }
    });

    // Calculate total when quantity or price changes
    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalDisplay.textContent = '$' + total.toFixed(2);
    }

    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);

    // Initial calculation
    calculateTotal();
});
</script>
@endsection