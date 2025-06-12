@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-full mx-4 sm:mx-6 lg:mx-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <!-- Product Management -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            📦 Product Management
                        </h3>
                        <nav class="space-y-2">
                            <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                🏷️ Categorías
                            </a>
                            <a href="{{ route('suppliers.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                🏭 Proveedores
                            </a>
                            <a href="{{ route('products.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                📱 Productos
                            </a>
                            <a href="{{ route('product-images.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                🖼️ Imágenes de Productos
                            </a>
                        </nav>
                    </div>
                </div>
                <!-- Inventory Management -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            📊 Inventory Management
                        </h3>
                        <nav class="space-y-2">
                            <a href="{{ route('movement-types.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                🔄 Tipos de Movimiento
                            </a>
                            <a href="{{ route('inventory-movements.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                📈 Movimientos de Inventario
                            </a>
                        </nav>
                    </div>
                </div>
                <!-- Shopping & Checkout -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            🛒 Shopping & Checkout
                        </h3>
                        <nav class="space-y-2">
                            <a href="{{ route('carts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                🛒 Carritos
                            </a>
                            <a href="{{ route('cart-items.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                📦 Items de Carritos
                            </a>
                            <a href="{{ route('checkout.index') }}" class="block px-4 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-md transition-colors font-medium">
                                ✅ Checkout
                            </a>
                        </nav>
                    </div>
                </div>
                <!-- Payment System -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg md:col-span-2 lg:col-span-3">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            💳 Payment System
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <a href="{{ route('payment-methods.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    💰 Métodos de Pago
                                </a>
                                <a href="{{ route('credit-cards.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    💳 Tarjetas de Crédito
                                </a>
                                <a href="{{ route('payment-gateways.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    🌐 Pasarelas de Pago
                                </a>
                                <a href="{{ route('orders-payments.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    📋 Órdenes de Pago
                                </a>
                            </div>
                            <div class="space-y-2">
                                <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    💸 Transacciones
                                </a>
                                <a href="{{ route('refunds.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    🔄 Reembolsos
                                </a>
                                <a href="{{ route('audit-logs-payments.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    📊 Logs de Auditoría de Pagos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Management -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg md:col-span-2 xl:col-span-4">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            👥 User Management
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors text-center">
                                🎭 Roles
                            </a>
                            <a href="{{ route('permissions.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors text-center">
                                🔐 Permisos
                            </a>
                            <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors text-center">
                                👤 Usuarios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
