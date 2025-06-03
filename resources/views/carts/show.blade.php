@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('carts.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Carrito #{{ $cart->id }}</h1>
                <div class="flex items-center space-x-4 mt-1">
                    <p class="text-gray-600 dark:text-gray-400">Propietario: {{ $cart->user->name ?? 'Usuario eliminado' }}</p>
                    @if($cart->status === 'active')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            🟢 Activo
                        </span>
                    @elseif($cart->status === 'purchased')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            🔵 Comprado
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            🔴 Abandonado
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('carts.edit', $cart->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Editar</span>
            </a>
            <button onclick="deleteCart({{ $cart->id }})" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>Eliminar</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cart Items -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Artículos del Carrito</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $cart->items->count() }} producto(s) en el carrito</p>
                        </div>
                        @if($cart->status === 'active')
                            <a href="{{ route('cart-items.create') }}?cart_id={{ $cart->id }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition duration-200 flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>Agregar Producto</span>
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($cart->items as $item)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <div class="flex items-center space-x-4">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $item->product->name ?? 'Producto eliminado' }}
                                        </h3>
                                        @if($item->product)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Código: {{ $item->product->code }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            ${{ number_format($item->unit_price, 2) }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">por unidad</p>
                                    </div>
                                </div>
                                
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Cantidad:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $item->quantity }}</span>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            ${{ number_format($item->quantity * $item->unit_price, 2) }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">subtotal</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex-shrink-0 flex items-center space-x-2">
                                @if($item->product)
                                    <a href="{{ route('products.show', $item->product->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200" title="Ver producto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                @endif
                                <a href="{{ route('cart-items.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors duration-200" title="Editar artículo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="deleteCartItem({{ $item->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200" title="Eliminar artículo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Carrito Vacío</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Este carrito no contiene productos.</p>
                        @if($cart->status === 'active')
                            <a href="{{ route('cart-items.create') }}?cart_id={{ $cart->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                                Agregar Productos
                            </a>
                        @endif
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Cart Activity Log (Placeholder for future enhancement) -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actividad Reciente</h3>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-green-400 rounded-full mt-2"></div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-900 dark:text-white">Carrito creado</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $cart->created_at ? $cart->created_at->format('d/m/Y H:i') : 'Fecha no disponible' }}
                            </p>
                        </div>
                    </div>
                    @if($cart->items->count() > 0)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-2"></div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $cart->items->count() }} producto(s) agregado(s)</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Estado actual del carrito</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Cart Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Resumen del Carrito</h3>
                
                @php
                    $totalItems = $cart->items->sum('quantity');
                    $totalAmount = $cart->items->sum(function($item) {
                        return $item->quantity * $item->unit_price;
                    });
                @endphp
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total de Artículos:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $totalItems }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Productos Únicos:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $cart->items->count() }}</span>
                    </div>
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-medium text-gray-900 dark:text-white">Total Estimado:</span>
                            <span class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format($totalAmount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información del Carrito</h3>
                
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">ID del Carrito:</span>
                        <p class="font-medium text-gray-900 dark:text-white">#{{ $cart->id }}</p>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Propietario:</span>
                        <div class="flex items-center space-x-2 mt-1">
                            <div class="w-6 h-6 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                    {{ strtoupper(substr($cart->user->name ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $cart->user->name ?? 'Usuario eliminado' }}</p>
                                @if($cart->user)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $cart->user->email }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Fecha de Creación:</span>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $cart->created_at ? $cart->created_at->format('d/m/Y H:i') : 'No disponible' }}
                        </p>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Estado:</span>
                        <div class="mt-1">
                            @if($cart->status === 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    🟢 Activo
                                </span>
                            @elseif($cart->status === 'purchased')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    🔵 Comprado
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    🔴 Abandonado
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones Rápidas</h3>
                
                <div class="space-y-3">
                    @if($cart->status === 'active')
                        <a href="{{ route('cart-items.create') }}?cart_id={{ $cart->id }}" class="w-full flex items-center space-x-3 text-sm text-white bg-green-600 hover:bg-green-700 transition-colors duration-200 p-3 rounded-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Agregar Productos</span>
                        </a>
                    @endif
                    
                    <a href="{{ route('cart-items.index') }}?cart_id={{ $cart->id }}" class="w-full flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 p-3 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>Gestionar Artículos</span>
                    </a>
                    
                    @if($cart->user)
                        <a href="{{ route('users.show', $cart->user->id) }}" class="w-full flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors duration-200 p-3 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Ver Perfil del Usuario</span>
                        </a>
                    @endif
                    
                    <a href="{{ route('carts.edit', $cart->id) }}" class="w-full flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors duration-200 p-3 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Editar Carrito</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Cart Modal -->
<div id="deleteCartModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-4">Eliminar Carrito</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    ¿Estás seguro de que deseas eliminar este carrito? Esta acción también eliminará todos los artículos del carrito y no se puede deshacer.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmDeleteCart" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200">
                    Eliminar Carrito
                </button>
                <button id="cancelDeleteCart" class="mt-3 px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none transition duration-200">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Cart Item Modal -->
<div id="deleteItemModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-4">Eliminar Artículo</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    ¿Estás seguro de que deseas eliminar este artículo del carrito?
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmDeleteItem" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200">
                    Eliminar Artículo
                </button>
                <button id="cancelDeleteItem" class="mt-3 px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none transition duration-200">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Delete cart functionality
let cartToDelete = null;

function deleteCart(cartId) {
    cartToDelete = cartId;
    document.getElementById('deleteCartModal').classList.remove('hidden');
}

document.getElementById('confirmDeleteCart').addEventListener('click', function() {
    if (cartToDelete) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/carts/${cartToDelete}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
});

document.getElementById('cancelDeleteCart').addEventListener('click', function() {
    cartToDelete = null;
    document.getElementById('deleteCartModal').classList.add('hidden');
});

// Delete cart item functionality
let itemToDelete = null;

function deleteCartItem(itemId) {
    itemToDelete = itemId;
    document.getElementById('deleteItemModal').classList.remove('hidden');
}

document.getElementById('confirmDeleteItem').addEventListener('click', function() {
    if (itemToDelete) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/cart-items/${itemToDelete}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
});

document.getElementById('cancelDeleteItem').addEventListener('click', function() {
    itemToDelete = null;
    document.getElementById('deleteItemModal').classList.add('hidden');
});

// Close modals when clicking outside
document.getElementById('deleteCartModal').addEventListener('click', function(e) {
    if (e.target === this) {
        cartToDelete = null;
        this.classList.add('hidden');
    }
});

document.getElementById('deleteItemModal').addEventListener('click', function(e) {
    if (e.target === this) {
        itemToDelete = null;
        this.classList.add('hidden');
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Escape to close modals
    if (e.key === 'Escape') {
        document.getElementById('deleteCartModal').classList.add('hidden');
        document.getElementById('deleteItemModal').classList.add('hidden');
        cartToDelete = null;
        itemToDelete = null;
    }
    
    // E to edit (when no modal is open)
    if (e.key === 'e' && !document.querySelector('.fixed:not(.hidden)')) {
        window.location.href = "{{ route('carts.edit', $cart->id) }}";
    }
});
</script>
@endpush
