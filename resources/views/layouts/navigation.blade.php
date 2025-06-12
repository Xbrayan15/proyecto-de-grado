<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/Logo.png') }}" alt="Logo de Stocky" class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center justify-center">
                    <!-- Productos Dropdown -->
                    <div class="relative" x-data="{ open: false, timeout: null }" 
                        @mouseenter="clearTimeout(timeout); open = true" 
                        @mouseleave="timeout = setTimeout(() => open = false, 150)">
                        <button class="text-[17px] font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300">
                            Productos
                        </button>
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute left-1/2 transform -translate-x-1/2 z-50 mt-1 w-40 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-md shadow-lg">
                            <div class="flex flex-col items-center space-y-0.5">
                                <x-dropdown-link class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1" :href="route('categories.index')">🏷️ Categorías</x-dropdown-link>
                                <x-dropdown-link class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1" :href="route('suppliers.index')">🏭 Proveedores</x-dropdown-link>
                                <x-dropdown-link class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1" :href="route('products.index')">📱 Productos</x-dropdown-link>
                                <x-dropdown-link class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1" :href="route('product-images.index')">🖼️ Imágenes</x-dropdown-link>
                            </div>
                        </div>
                    </div>

                    <!-- Inventario Dropdown -->
                    <div class="relative" x-data="{ open: false, timeout: null }" 
                        @mouseenter="clearTimeout(timeout); open = true" 
                        @mouseleave="timeout = setTimeout(() => open = false, 150)">
                        <button class="text-[17px] font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300">
                            Inventario
                        </button>
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute left-1/2 transform -translate-x-1/2 z-50 mt-1 w-40 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-md shadow-lg">
                            <div class="flex flex-col items-center space-y-0.5">
                                <x-dropdown-link :href="route('movement-types.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">🔄 Tipos de Movimiento</x-dropdown-link>
                                <x-dropdown-link :href="route('inventory-movements.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">📈 Movimientos</x-dropdown-link>
                            </div>
                        </div>
                    </div>

                    <!-- Compras Dropdown -->
                    <div class="relative" x-data="{ open: false, timeout: null }" 
                        @mouseenter="clearTimeout(timeout); open = true" 
                        @mouseleave="timeout = setTimeout(() => open = false, 150)">
                        <button class="text-[17px] font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300">
                            Compras
                        </button>
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute left-1/2 transform -translate-x-1/2 z-50 mt-1 w-40 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-md shadow-lg">
                            <div class="flex flex-col items-center space-y-0.5">
                                <x-dropdown-link :href="route('carts.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">🛒 Carritos</x-dropdown-link>
                                <x-dropdown-link :href="route('cart-items.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">📦 Items de Carrito</x-dropdown-link>
                                <x-dropdown-link :href="route('checkout.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">✅ Checkout</x-dropdown-link>
                            </div>
                        </div>
                    </div>

                    <!-- Pagos Dropdown -->
                    <div class="relative" x-data="{ open: false, timeout: null }" 
                        @mouseenter="clearTimeout(timeout); open = true" 
                        @mouseleave="timeout = setTimeout(() => open = false, 150)">
                        <button class="text-[17px] font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300">
                            Pagos
                        </button>
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute left-1/2 transform -translate-x-1/2 z-50 mt-1 w-40 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-md shadow-lg">
                            <div class="flex flex-col items-center space-y-0.5">
                                <x-dropdown-link :href="route('payment-methods.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">💰 Métodos de Pago</x-dropdown-link>
                                <x-dropdown-link :href="route('credit-cards.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">💳 Tarjetas</x-dropdown-link>
                                <x-dropdown-link :href="route('payment-gateways.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">🌐 Pasarelas</x-dropdown-link>
                                <x-dropdown-link :href="route('orders-payments.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">📋 Órdenes</x-dropdown-link>
                                <x-dropdown-link :href="route('transactions.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">💸 Transacciones</x-dropdown-link>
                                <x-dropdown-link :href="route('refunds.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">🔄 Reembolsos</x-dropdown-link>
                            </div>
                        </div>
                    </div>

                    <!-- Usuarios Dropdown -->
                    <div class="relative" x-data="{ open: false, timeout: null }" 
                        @mouseenter="clearTimeout(timeout); open = true" 
                        @mouseleave="timeout = setTimeout(() => open = false, 150)">
                        <button class="text-[17px] font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300">
                            Usuarios
                        </button>
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute left-1/2 transform -translate-x-1/2 z-50 mt-1 w-40 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-md shadow-lg">
                            <div class="flex flex-col items-center space-y-0.5">
                                <x-dropdown-link :href="route('roles.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">🎭 Roles</x-dropdown-link>
                                <x-dropdown-link :href="route('permissions.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">🔐 Permisos</x-dropdown-link>
                                <x-dropdown-link :href="route('users.index')" class="text-[10px] text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 py-1">👤 Usuarios</x-dropdown-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                    <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-all duration-200">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link class="text-[10px]" :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link class="text-[10px]" :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-all duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- Productos Section -->
        <div x-data="{ expanded: false }" class="border-t border-gray-200 dark:border-gray-600">
            <button @click="expanded = !expanded" class="flex items-center justify-between w-full px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 focus:outline-none transition duration-150 ease-in-out dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-600">
                <span>Productos</span>
                <svg :class="{'rotate-180': expanded}" class="w-5 h-5 transform transition-transform duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="expanded" x-collapse>
                <x-responsive-nav-link :href="route('categories.index')">Categorías</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('suppliers.index')">Proveedores</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('products.index')">Productos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('product-images.index')">Imágenes</x-responsive-nav-link>
            </div>
        </div>

        <!-- Inventario Section -->
        <div x-data="{ expanded: false }" class="border-t border-gray-200 dark:border-gray-600">
            <button @click="expanded = !expanded" class="flex items-center justify-between w-full px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 focus:outline-none transition duration-150 ease-in-out dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-600">
                <span>Inventario</span>
                <svg :class="{'rotate-180': expanded}" class="w-5 h-5 transform transition-transform duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="expanded" x-collapse>
                <x-responsive-nav-link :href="route('movement-types.index')">Tipos de Movimiento</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inventory-movements.index')">Movimientos</x-responsive-nav-link>
            </div>
        </div>

        <!-- Compras Section -->
        <div x-data="{ expanded: false }" class="border-t border-gray-200 dark:border-gray-600">
            <button @click="expanded = !expanded" class="flex items-center justify-between w-full px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 focus:outline-none transition duration-150 ease-in-out dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-600">
                <span>Compras</span>
                <svg :class="{'rotate-180': expanded}" class="w-5 h-5 transform transition-transform duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="expanded" x-collapse>
                <x-responsive-nav-link :href="route('carts.index')">Carritos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cart-items.index')">Items de Carrito</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('checkout.index')">Checkout</x-responsive-nav-link>
            </div>
        </div>

        <!-- Pagos Section -->
        <div x-data="{ expanded: false }" class="border-t border-gray-200 dark:border-gray-600">
            <button @click="expanded = !expanded" class="flex items-center justify-between w-full px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 focus:outline-none transition duration-150 ease-in-out dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-600">
                <span>Pagos</span>
                <svg :class="{'rotate-180': expanded}" class="w-5 h-5 transform transition-transform duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="expanded" x-collapse>
                <x-responsive-nav-link :href="route('payment-methods.index')">Métodos de Pago</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('credit-cards.index')">Tarjetas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('payment-gateways.index')">Pasarelas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders-payments.index')">Órdenes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('transactions.index')">Transacciones</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('refunds.index')">Reembolsos</x-responsive-nav-link>
            </div>
        </div>

        <!-- Usuarios Section -->
        <div x-data="{ expanded: false }" class="border-t border-gray-200 dark:border-gray-600">
            <button @click="expanded = !expanded" class="flex items-center justify-between w-full px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 focus:outline-none transition duration-150 ease-in-out dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-600">
                <span>Usuarios</span>
                <svg :class="{'rotate-180': expanded}" class="w-5 h-5 transform transition-transform duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="expanded" x-collapse>
                <x-responsive-nav-link :href="route('roles.index')">Roles</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('permissions.index')">Permisos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')">Usuarios</x-responsive-nav-link>
            </div>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
