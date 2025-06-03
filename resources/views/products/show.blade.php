@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detalle del Producto #{{ $product->id }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Image -->
            <div class="lg:col-span-1">
                <div class="bg-gray-100 rounded-lg p-4">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg">
                    @else
                        <div class="w-full h-64 bg-gray-300 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-4xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Information -->
            <div class="lg:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Código</label>
                            <p class="mt-1 text-lg text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded">{{ $product->code }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $product->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categoría</label>
                            <p class="mt-1 text-lg text-gray-900">
                                @if($product->category)
                                    <a href="{{ route('categories.show', $product->category->id) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $product->category->name }}
                                    </a>
                                @else
                                    <span class="text-gray-500">Sin categoría</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                            <p class="mt-1 text-lg text-gray-900">
                                @if($product->supplier)
                                    <a href="{{ route('suppliers.show', $product->supplier->id) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $product->supplier->name }}
                                    </a>
                                @else
                                    <span class="text-gray-500">Sin proveedor</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio</label>
                            <p class="mt-1 text-2xl font-bold text-green-600">${{ number_format($product->price, 2) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock Disponible</label>
                            <p class="mt-1 text-lg">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $product->quantity > 10 ? 'bg-green-100 text-green-800' : ($product->quantity > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $product->quantity }} unidades
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de creación</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($product->description)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900">{{ $product->description }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Images Gallery -->
        @if($product->images && $product->images->count() > 0)
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Galería de Imágenes</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                        <div class="bg-gray-100 rounded-lg p-2">
                            <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?? $product->name }}" 
                                 class="w-full h-32 object-cover rounded">
                            @if($image->is_primary)
                                <div class="mt-2">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Principal</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
