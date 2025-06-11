<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-2">¡Bienvenido, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600 dark:text-gray-400">Explora nuestros productos y realiza tus compras de manera fácil y segura.</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('products.catalog') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg transition duration-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold">Ver Catálogo</h4>
                            <p class="text-sm opacity-90">Explorar productos</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('orders.index') }}" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg transition duration-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold">Mis Órdenes</h4>
                            <p class="text-sm opacity-90">Historial de compras</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-lg transition duration-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold">Mi Perfil</h4>
                            <p class="text-sm opacity-90">Editar información</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Órdenes Recientes</h3>
                    <div class="space-y-3">
                        @forelse(Auth::user()->orders()->latest()->take(5)->get() as $order)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">Orden #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900 dark:text-gray-100">${{ number_format($order->total ?? 0, 2) }}</p>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($order->status === 'completed') bg-green-100 text-green-800 
                                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800 
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($order->status ?? 'pending') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400 text-center py-8">
                                No tienes órdenes aún. 
                                <a href="{{ route('products.catalog') }}" class="text-blue-600 hover:text-blue-800">¡Comienza a comprar!</a>
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Current Cart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Mi Carrito Actual</h3>
                    <div id="cartContent">
                        <p class="text-gray-600 dark:text-gray-400">Cargando carrito...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load current cart
        document.addEventListener('DOMContentLoaded', function() {
            loadCurrentCart();
        });

        async function loadCurrentCart() {
            try {
                const response = await fetch('/api/carts/active', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const carts = await response.json();
                    if (carts && carts.length > 0) {
                        const cart = carts[0];
                        displayCart(cart);
                    } else {
                        document.getElementById('cartContent').innerHTML = `
                            <p class="text-gray-600 dark:text-gray-400 text-center py-4">
                                Tu carrito está vacío. 
                                <a href="{{ route('products.catalog') }}" class="text-blue-600 hover:text-blue-800">¡Agrega algunos productos!</a>
                            </p>
                        `;
                    }
                } else {
                    document.getElementById('cartContent').innerHTML = '<p class="text-red-600">Error al cargar el carrito.</p>';
                }
            } catch (error) {
                console.error('Error loading cart:', error);
                document.getElementById('cartContent').innerHTML = '<p class="text-red-600">Error al cargar el carrito.</p>';
            }
        }

        function displayCart(cart) {
            const itemCount = cart.cart_items_count || 0;
            const content = `
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-900 dark:text-gray-100">
                            <span class="font-medium">${itemCount}</span> 
                            ${itemCount === 1 ? 'producto' : 'productos'} en tu carrito
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Carrito #${cart.id}</p>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('products.catalog') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded transition duration-200">
                            Seguir Comprando
                        </a>
                        ${itemCount > 0 ? `
                            <a href="{{ route('checkout.index') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded transition duration-200">
                                Finalizar Compra
                            </a>
                        ` : ''}
                    </div>
                </div>
            `;
            document.getElementById('cartContent').innerHTML = content;
        }
    </script>
</x-app-layout>
