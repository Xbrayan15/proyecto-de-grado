@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detalle de la Orden #{{ $order->id }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('orders.edit', $order->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Information -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información de la Orden</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ID de Orden</label>
                        <p class="mt-1 text-lg text-gray-900 font-mono">#{{ $order->id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <p class="mt-1">
                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                                {{ $order->status === 'completado' ? 'bg-green-100 text-green-800' : 
                                   ($order->status === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total</label>
                        <p class="mt-1 text-2xl font-bold text-green-600">${{ number_format($order->total, 2) }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de creación</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Última actualización</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Cliente</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $order->user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $order->user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">ID de Usuario</label>
                        <p class="mt-1 text-lg text-gray-900 font-mono">#{{ $order->user->id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cliente desde</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $order->user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        @if($order->items && $order->items->count() > 0)
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Items de la Orden</h3>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($item->product)
                                            <a href="{{ route('products.show', $item->product->id) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $item->product->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-500">Producto no disponible</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($item->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">${{ number_format($item->quantity * $item->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="mt-8 bg-gray-50 rounded-lg p-6 text-center">
                <i class="fas fa-shopping-cart text-gray-400 text-3xl mb-2"></i>
                <p class="text-gray-500">Esta orden no tiene items asociados</p>
            </div>
        @endif
    </div>
</div>
@endsection
