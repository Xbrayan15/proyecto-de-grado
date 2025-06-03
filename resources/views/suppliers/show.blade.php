@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detalle del Proveedor #{{ $supplier->id }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('suppliers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información del Proveedor -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Proveedor</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">ID:</span>
                        <span class="text-gray-900">{{ $supplier->id }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Nombre:</span>
                        <span class="text-gray-900">{{ $supplier->name }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Persona de Contacto:</span>
                        <span class="text-gray-900">{{ $supplier->contact_person ?? 'No especificado' }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Email:</span>
                        @if($supplier->email)
                            <a href="mailto:{{ $supplier->email }}" class="text-blue-600 hover:text-blue-800">{{ $supplier->email }}</a>
                        @else
                            <span class="text-gray-500">No especificado</span>
                        @endif
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Teléfono:</span>
                        @if($supplier->phone)
                            <a href="tel:{{ $supplier->phone }}" class="text-blue-600 hover:text-blue-800">{{ $supplier->phone }}</a>
                        @else
                            <span class="text-gray-500">No especificado</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de Contacto</h3>
                
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Dirección:</span>
                        <div class="mt-1">
                            @if($supplier->address)
                                <p class="text-gray-900 bg-white p-3 rounded border">{{ $supplier->address }}</p>
                            @else
                                <span class="text-gray-500">No especificada</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="mt-6 bg-blue-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <span class="font-medium text-gray-700">Productos Asociados:</span>
                    <div class="mt-1">
                        <span class="text-2xl font-bold text-blue-600">{{ $supplier->products_count ?? 0 }}</span>
                    </div>
                </div>
                
                <div class="text-center">
                    <span class="font-medium text-gray-700">Fecha de Registro:</span>
                    <div class="mt-1">
                        <span class="text-gray-900">{{ $supplier->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
                
                <div class="text-center">
                    <span class="font-medium text-gray-700">Última Actualización:</span>
                    <div class="mt-1">
                        <span class="text-gray-900">{{ $supplier->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos del Proveedor -->
        @if($supplier->products && $supplier->products->count() > 0)
        <div class="mt-6 bg-white border rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Productos del Proveedor</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($supplier->products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('products.show', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Acciones -->
        <div class="mt-6 flex justify-end gap-2">
            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300" 
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este proveedor?')">
                    <i class="fas fa-trash mr-2"></i>Eliminar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
