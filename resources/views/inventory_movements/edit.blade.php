@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Editar Movimiento de Inventario</h1>
            <a href="{{ route('inventory-movements.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
        </div>

        <form action="{{ route('inventory-movements.update', $movement->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="movement_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha del Movimiento</label>
                    <input type="date" name="movement_date" id="movement_date" value="{{ old('movement_date', $movement->movement_date->format('Y-m-d')) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('movement_date') border-red-500 @enderror">
                    @error('movement_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="movement_type_id" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Movimiento</label>
                    <select name="movement_type_id" id="movement_type_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('movement_type_id') border-red-500 @enderror">
                        <option value="">Seleccionar tipo</option>
                        @foreach($movementTypes as $type)
                            <option value="{{ $type->id }}" {{ old('movement_type_id', $movement->movement_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} ({{ $type->effect === 'in' ? 'Entrada' : 'Salida' }})
                            </option>
                        @endforeach
                    </select>
                    @error('movement_type_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Producto</label>
                    <select name="product_id" id="product_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('product_id') border-red-500 @enderror">
                        <option value="">Seleccionar producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $movement->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} ({{ $product->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $movement->quantity) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('quantity') border-red-500 @enderror">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">Precio Unitario (opcional)</label>
                    <input type="number" step="0.01" name="unit_price" id="unit_price" value="{{ old('unit_price', $movement->unit_price) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('unit_price') border-red-500 @enderror">
                    @error('unit_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Usuario Responsable</label>
                    <select name="user_id" id="user_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror">
                        <option value="">Seleccionar usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $movement->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="order_id" class="block text-sm font-medium text-gray-700 mb-2">Orden Asociada (opcional)</label>
                <select name="order_id" id="order_id" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('order_id') border-red-500 @enderror">
                    <option value="">Sin orden asociada</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id', $movement->order_id) == $order->id ? 'selected' : '' }}>
                            Orden #{{ $order->id }} - {{ $order->user->name ?? 'Sin usuario' }}
                        </option>
                    @endforeach
                </select>
                @error('order_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notas (opcional)</label>
                <textarea name="notes" id="notes" rows="3" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes', $movement->notes) }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-save mr-2"></i>Actualizar
                </button>
                <a href="{{ route('inventory-movements.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 text-center">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
