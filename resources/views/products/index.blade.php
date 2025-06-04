@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Productos</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
            <i class="fas fa-plus mr-2"></i>Crear Producto
        </a>
    </div>

    <!-- Search bar -->
    <div class="mb-6 flex items-center">
        <div class="relative w-full max-w-xs">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" id="product-search" placeholder="Buscar productos..." class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50 text-gray-800 shadow-sm" autocomplete="off">
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div id="product-grid" class="bg-white rounded-lg shadow p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="col-span-1 flex flex-col items-center bg-gray-50 rounded-lg shadow-md p-3 product-card" data-name="{{ strtolower($product->name) }}" data-code="{{ strtolower($product->code) }}" data-category="{{ strtolower($product->category->name ?? '') }}">
                @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-28 w-full object-cover rounded-t-lg mb-2">
                @else
                    <div class="h-28 w-full bg-gray-300 flex items-center justify-center rounded-t-lg mb-2">
                        <i class="fas fa-box text-gray-500 text-2xl"></i>
                    </div>
                @endif
                <div class="w-full flex-1 flex flex-col justify-between">
                    <h2 class="text-base font-bold text-gray-900 mb-1 truncate">{{ $product->name }}</h2>
                    <p class="text-xs text-gray-600 mb-1 truncate">Código: <span class="font-mono">{{ $product->code }}</span></p>
                    <p class="text-xs text-gray-600 mb-1 truncate">Categoría: {{ $product->category->name ?? 'Sin categoría' }}</p>
                    <p class="text-xs text-gray-600 mb-1">Precio: <span class="font-semibold text-blue-700">${{ number_format($product->price, 2) }}</span></p>
                    <p class="text-xs text-gray-600 mb-1">Stock: <span class="font-semibold">{{ $product->quantity }}</span></p>
                    <p class="text-xs mb-2">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </p>
                    <div class="flex justify-between gap-1 mt-2">
                        <a href="{{ route('products.show', $product->id) }}" class="text-white bg-blue-700 hover:bg-blue-900 px-2 py-1 rounded font-semibold text-xs transition">Ver</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 px-2 py-1 rounded font-semibold text-xs transition">Editar</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-800 px-2 py-1 rounded font-semibold text-xs transition" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 py-8">No hay productos registrados</div>
        @endforelse
    </div>
</div>

<style>
.product-card {
    transition: transform 0.18s cubic-bezier(.4,2,.6,1), box-shadow 0.18s cubic-bezier(.4,2,.6,1);
}
.product-card:hover {
    transform: translateY(-6px) scale(1.025);
    box-shadow: 0 8px 32px 0 rgba(34,58,94,0.10), 0 1.5px 6px 0 rgba(34,58,94,0.08);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('product-search');
    const cards = document.querySelectorAll('.product-card');
    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        let anyVisible = false;
        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const code = card.getAttribute('data-code');
            const category = card.getAttribute('data-category');
            const matches = name.includes(query) || code.includes(query) || category.includes(query);
            card.style.display = matches ? '' : 'none';
            if (matches) anyVisible = true;
        });
        // Show/hide empty message
        const emptyMsg = document.querySelector('#product-grid .col-span-full');
        if (emptyMsg) {
            emptyMsg.style.display = anyVisible ? 'none' : '';
        }
    });
});
</script>
@endsection
