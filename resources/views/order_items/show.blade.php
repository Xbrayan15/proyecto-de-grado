@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detalles del Item de Orden</h1>
            <p class="text-gray-600 mt-1">Item #{{ $orderItem->id }} en Orden #{{ $orderItem->order_id }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('order-items.edit', $orderItem->id) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                <i class="fas fa-edit"></i>
                Editar
            </a>
            <form action="{{ route('order-items.destroy', $orderItem->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('¿Está seguro de que desea eliminar este item?')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    Eliminar
                </button>
            </form>
            <a href="{{ route('order-items.index') }}" 
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
                        <p class="text-gray-600">Detalles completos del item de orden</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- ID -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-hashtag text-gray-500"></i>
                            <span class="text-sm font-medium text-gray-700">ID del Item</span>
                        </div>
                        <p class="text-lg font-semibold text-gray-900">#{{ $orderItem->id }}</p>
                    </div>

                    <!-- Cantidad -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-sort-numeric-up text-purple-500"></i>
                            <span class="text-sm font-medium text-gray-700">Cantidad</span>
                        </div>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($orderItem->quantity) }}</p>
                    </div>

                    <!-- Precio Unitario -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-dollar-sign text-yellow-500"></i>
                            <span class="text-sm font-medium text-gray-700">Precio Unitario</span>
                        </div>
                        <p class="text-lg font-semibold text-green-600">${{ number_format($orderItem->unit_price, 2) }}</p>
                    </div>

                    <!-- Total -->
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-calculator text-green-500"></i>
                            <span class="text-sm font-medium text-gray-700">Total</span>
                        </div>
                        <p class="text-xl font-bold text-green-600">${{ number_format($orderItem->total, 2) }}</p>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de Registro</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-calendar-plus text-blue-500"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Fecha de Creación</p>
                                <p class="text-gray-900">{{ $orderItem->created_at ? $orderItem->created_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-calendar-alt text-green-500"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Última Actualización</p>
                                <p class="text-gray-900">{{ $orderItem->updated_at ? $orderItem->updated_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Información de la Orden -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Orden Asociada</h3>
                </div>
                
                @if($orderItem->order)
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID:</span>
                            <span class="font-semibold">#{{ $orderItem->order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Cliente:</span>
                            <span class="font-semibold">{{ $orderItem->order->user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Orden:</span>
                            <span class="font-semibold text-green-600">${{ number_format($orderItem->order->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Estado:</span>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @switch($orderItem->order->status)
                                    @case('pending') bg-yellow-100 text-yellow-800 @break
                                    @case('processing') bg-blue-100 text-blue-800 @break
                                    @case('shipped') bg-purple-100 text-purple-800 @break
                                    @case('delivered') bg-green-100 text-green-800 @break
                                    @case('cancelled') bg-red-100 text-red-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                {{ ucfirst($orderItem->order->status) }}
                            </span>
                        </div>
                        <a href="{{ route('orders.show', $orderItem->order->id) }}" 
                           class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition duration-200 mt-4">
                            Ver Orden Completa
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 italic">No hay información de orden disponible</p>
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
                
                @if($orderItem->product)
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nombre:</span>
                            <span class="font-semibold">{{ $orderItem->product->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">SKU:</span>
                            <span class="font-semibold">{{ $orderItem->product->sku ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Precio Actual:</span>
                            <span class="font-semibold text-green-600">${{ number_format($orderItem->product->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Stock:</span>
                            <span class="font-semibold {{ $orderItem->product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $orderItem->product->stock_quantity }}
                            </span>
                        </div>
                        <a href="{{ route('products.show', $orderItem->product->id) }}" 
                           class="block w-full text-center bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg transition duration-200 mt-4">
                            Ver Producto
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 italic">No hay información del producto disponible</p>
                @endif
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-purple-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Acciones Rápidas</h3>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('order-items.create') }}" 
                       class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Nuevo Item
                    </a>
                    <a href="{{ route('order-items.edit', $orderItem->id) }}" 
                       class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Editar Item
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection