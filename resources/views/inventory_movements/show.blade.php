@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detalle del Movimiento de Inventario #{{ $movement->id }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('inventory-movements.edit', $movement->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('inventory-movements.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información del Movimiento -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Movimiento</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">ID:</span>
                        <span class="text-gray-900">{{ $movement->id }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Fecha:</span>
                        <span class="text-gray-900">{{ $movement->movement_date->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Tipo de Movimiento:</span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $movement->movementType->effect === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $movement->movementType->name }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Efecto:</span>
                        <span class="text-gray-900">
                            {{ $movement->movementType->effect === 'in' ? 'Entrada' : 'Salida' }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Usuario Responsable:</span>
                        <span class="text-gray-900">{{ $movement->user->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Producto</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Producto:</span>
                        <span class="text-gray-900">{{ $movement->product->name }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Código:</span>
                        <span class="text-gray-900">{{ $movement->product->code }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Categoría:</span>
                        <span class="text-gray-900">{{ $movement->product->category->name ?? 'Sin categoría' }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Cantidad Movida:</span>
                        <span class="text-gray-900 font-bold">{{ $movement->quantity }}</span>
                    </div>
                    
                    @if($movement->unit_price)
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Precio Unitario:</span>
                        <span class="text-gray-900">${{ number_format($movement->unit_price, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Total:</span>
                        <span class="text-gray-900 font-bold">${{ number_format($movement->unit_price * $movement->quantity, 2) }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Adicional</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($movement->order)
                <div>
                    <span class="font-medium text-gray-700">Orden Asociada:</span>
                    <div class="mt-1">
                        <a href="{{ route('orders.show', $movement->order->id) }}" class="text-blue-600 hover:text-blue-800">
                            Orden #{{ $movement->order->id }}
                        </a>
                        <p class="text-sm text-gray-500">Usuario: {{ $movement->order->user->name ?? 'Sin usuario' }}</p>
                        <p class="text-sm text-gray-500">Total: ${{ number_format($movement->order->total, 2) }}</p>
                    </div>
                </div>
                @endif
                
                <div>
                    <span class="font-medium text-gray-700">Fechas:</span>
                    <div class="mt-1 text-sm text-gray-600">
                        <p>Creado: {{ $movement->created_at->format('d/m/Y H:i') }}</p>
                        @if($movement->updated_at->ne($movement->created_at))
                        <p>Actualizado: {{ $movement->updated_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($movement->notes)
            <div class="mt-4">
                <span class="font-medium text-gray-700">Notas:</span>
                <p class="mt-1 text-gray-900 bg-white p-3 rounded border">{{ $movement->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Acciones -->
        <div class="mt-6 flex justify-end gap-2">
            <form action="{{ route('inventory-movements.destroy', $movement->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300" 
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este movimiento?')">
                    <i class="fas fa-trash mr-2"></i>Eliminar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
