<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Iniciar Sesión</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Selecciona tu tipo de usuario</p>
    </div>

    <!-- User Type Selection -->
    <div class="mb-6" id="userTypeSelection">
        <div class="grid grid-cols-2 gap-4">
            <button type="button" 
                    onclick="selectUserType('cliente')" 
                    id="clienteBtn"
                    class="user-type-btn flex flex-col items-center justify-center p-6 border-2 border-gray-300 rounded-lg hover:border-blue-500 transition-colors duration-200">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Cliente</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Comprar productos</span>
            </button>
            
            <button type="button" 
                    onclick="selectUserType('vendedor')" 
                    id="vendedorBtn"
                    class="user-type-btn flex flex-col items-center justify-center p-6 border-2 border-gray-300 rounded-lg hover:border-green-500 transition-colors duration-200">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h2M7 21V5a2 2 0 012-2h5.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H17a2 2 0 012 2v16M7 10h6m-6 4h6m-6 4h6"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Vendedor</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Gestionar ventas</span>
            </button>
        </div>
    </div>

    <!-- Login Form (initially hidden) -->
    <div id="loginForm" class="hidden">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Hidden field for user type -->
            <input type="hidden" name="user_type" id="userType" value="">

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <button type="button" onclick="goBack()" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    ← Volver
                </button>
                
                <div class="flex items-center">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function selectUserType(type) {
            // Update hidden field
            document.getElementById('userType').value = type;
            
            // Update UI
            document.getElementById('userTypeSelection').classList.add('hidden');
            document.getElementById('loginForm').classList.remove('hidden');
            
            // Update button styles
            const buttons = document.querySelectorAll('.user-type-btn');
            buttons.forEach(btn => btn.classList.remove('border-blue-500', 'border-green-500'));
            
            if (type === 'cliente') {
                document.getElementById('clienteBtn').classList.add('border-blue-500');
            } else {
                document.getElementById('vendedorBtn').classList.add('border-green-500');
            }
        }

        function goBack() {
            document.getElementById('userTypeSelection').classList.remove('hidden');
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('userType').value = '';
        }
    </script>

    <style>
        .user-type-btn.selected {
            border-color: #3B82F6;
            background-color: #EFF6FF;
        }
    </style>
</x-guest-layout>
