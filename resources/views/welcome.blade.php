<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stocky</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .carousel {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
        }

        .carousel-item {
            height: 100vh;
        }

        .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .carousel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .main-content {
            position: relative;
            z-index: 2;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .auth-modal-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background-color: white;
            border: 2px solid #223a5e;
            color: #223a5e;
            transition: all 0.3s ease;
        }

        .auth-modal-button:hover {
            background-color: #223a5e;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Carrusel de fondo -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="carousel-overlay"></div>
                <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                    class="d-block w-100" alt="Warehouse 1">
            </div>
            <div class="carousel-item">
                <div class="carousel-overlay"></div>
                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                    class="d-block w-100" alt="Warehouse 2">
            </div>
            <div class="carousel-item">
                <div class="carousel-overlay"></div>
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                    class="d-block w-100" alt="Warehouse 3">
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="container-fluid pe-none user-select-none min-vh-100 d-flex justify-content-center align-items-center">
        <div class="main-content" style="max-width: 540px;">
            <h1 class="text-center fw-bold mb-4"
                style="color: #223a5e; font-size: 2.5rem; letter-spacing: 1px;">¡Bienvenido a Stocky!</h1>
            <p class="text-center fw-semibold text-dark mb-2" style="font-size: 1.15rem;">Tu aliado inteligente en el
                control de inventario.<br>
                Gestiona existencias, optimiza movimientos y mantén tu operación siempre en orden, todo desde un solo
                lugar.<br>
                Comienza a explorar tus productos, movimientos y reportes con facilidad.
            </p>
            <p class="text-center fw-bold text-secondary" style="font-size: 1.1rem;">📦 Eficiencia, claridad y
                control.</p>
        </div>
    </div>

    <!-- Modal de autenticación -->
    <div class="auth-modal z-2">
        <div class="auth-modal-container">
            <div id="auth-container" class="auth-forms-container">
                <div class="auth-form-container auth-sign-up-container">
                    <!-- REGISTRO -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-6 w-full max-w-md mx-auto p-8">
                        @csrf

                        <div class="space-y-2">
                            <label for="register_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="register_name" name="name" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="register_email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="register_email" name="email" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="register_password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input type="password" id="register_password" name="password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('password')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                            <input type="password" id="register_password_confirmation" name="password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('password_confirmation')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
        <input type="hidden" name="user_type" value="cliente">
                        <div class="flex items-center justify-between pt-4">
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-500" id="goToLogin">¿Ya estás registrado?</a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Registrar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="auth-form-container auth-sign-in-container">
                    <!-- LOGIN -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6 w-full max-w-md mx-auto p-8">
                        @csrf

                        <div class="space-y-2">
                            <label for="login_email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <input type="email" name="email" id="login_email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror" 
                                value="{{ old('email') }}"
                                required autofocus>
                            @error('email')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="login_password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input type="password" name="password" id="login_password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror" 
                                required>
                            @error('password')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-700" for="remember">
                                Recuérdame
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>
                <div class="auth-overlay-container">
                    <div class="auth-overlay bg-gradient-to-r from-blue-600 to-blue-800">
                        <div class="auth-overlay-panel auth-overlay-left">
                            <h1 class="text-4xl font-bold text-white mb-4">¡Bienvenido de nuevo!</h1>
                            <p class="text-white text-lg mb-8">Para mantenerte conectado, inicia sesión con tu información personal</p>
                            <button class="px-8 py-3 border-2 border-white text-white rounded-full hover:bg-white hover:text-blue-600 transition-colors duration-300 ghost" id="signIn">
                                Iniciar Sesión
                            </button>
                        </div>
                        <div class="auth-overlay-panel auth-overlay-right">
                            <h1 class="text-4xl font-bold text-white mb-4">¡Hola, amigo!</h1>
                            <p class="text-white text-lg mb-8">Ingresa tus datos personales y comienza tu viaje con nosotros</p>
                            <button class="px-8 py-3 border-2 border-white text-white rounded-full hover:bg-white hover:text-blue-600 transition-colors duration-300 ghost" id="signUp">
                                Registrarse
                            </button>
                        </div>
                    </div>
                </div>
                <button class="icon-button close-button"></button>
            </div>
        </div>
        <button class="auth-modal-button btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold"
            type="button">Login</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializar el carrusel con todas las opciones necesarias
            const myCarousel = new bootstrap.Carousel(document.getElementById('carouselExampleFade'), {
                interval: 3000,    // Cambiar cada 3 segundos
                pause: false,      // No pausar al pasar el mouse
                wrap: true,        // Continuar desde el principio al llegar al final
                keyboard: true,    // Permitir control con teclado
                touch: true,       // Permitir control táctil
                ride: 'carousel'   // Iniciar automáticamente
            });

            // Forzar el inicio del carrusel
            myCarousel.cycle();

            // Manejar el botón de login
            const loginButton = document.querySelector('.auth-modal-button');
            const authModal = document.querySelector('.auth-modal');
            const closeButton = document.querySelector('.close-button');

            loginButton.addEventListener('click', function () {
                authModal.classList.add('show');
            });

            closeButton.addEventListener('click', function () {
                authModal.classList.remove('show');
            });

            // Cambiar entre login y registro
            const signUpButton = document.getElementById('signUp');
            const signInButton = document.getElementById('signIn');
            const container = document.getElementById('auth-container');

            signUpButton?.addEventListener('click', () => {
                container.classList.add('right-panel-active');
            });

            signInButton?.addEventListener('click', () => {
                container.classList.remove('right-panel-active');
            });
        });
    </script>
</body>

</html>
