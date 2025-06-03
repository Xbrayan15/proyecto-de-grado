<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stocky</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center bg-light p-0"
        style="margin:0;">
        <div class="position-fixed top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center w-100"
            style="max-width: 540px;">
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
    <div class="auth-modal">
        <div class="auth-modal-container">
            <div id="auth-container" class="auth-forms-container">
                <div class="auth-form-container auth-sign-up-container">
                    <!-- REGISTRO -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="auth-form-group">
                            <label for="register_name" class="auth-label">Nombre</label>
                            <input type="text" id="register_name" name="name" class="auth-input"
                                value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-form-group">
                            <label for="register_email" class="auth-label">Email</label>
                            <input type="email" id="register_email" name="email" class="auth-input"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-form-group">
                            <label for="register_password" class="auth-label">Contraseña</label>
                            <input type="password" id="register_password" name="password" class="auth-input" required>
                            @error('password')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-form-group">
                            <label for="register_password_confirmation" class="auth-label">Confirmar Contraseña</label>
                            <input type="password" id="register_password_confirmation" name="password_confirmation"
                                class="auth-input" required>
                            @error('password_confirmation')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-actions">
                            <a href="#" class="auth-link" id="goToLogin">¿Ya estás registrado?</a>
                            <button type="submit" class="auth-btn">Registrar</button>
                        </div>
                    </form>
                </div>
                <div class="auth-form-container auth-sign-in-container">
                    <!-- LOGIN -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="auth-form-group">
                            <label for="login_email" class="auth-label">Correo Electrónico</label>
                            <input type="email" name="email" id="login_email"
                                class="auth-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required autofocus>
                            @error('email')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-form-group">
                            <label for="login_password" class="auth-label">Contraseña</label>
                            <input type="password" name="password" id="login_password"
                                class="auth-input @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-form-check">
                            <input type="checkbox" name="remember" id="remember" class="auth-checkbox"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="auth-label-checkbox" for="remember">Recuérdame</label>
                        </div>

                        <div class="auth-actions">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="auth-link">¿Olvidaste tu
                                    contraseña?</a>
                            @endif
                            <button type="submit" class="auth-btn">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
                <div class="auth-overlay-container">
                    <div class="auth-overlay">
                        <div class="auth-overlay-panel auth-overlay-left">
                            <h1>Welcome Back!</h1>
                            <p>To keep connected with us please login with your personal info</p>
                            <button class="ghost" id="signIn">Sign In</button>
                        </div>
                        <div class="auth-overlay-panel auth-overlay-right">
                            <h1>Hello, Friend!</h1>
                            <p>Enter your personal details and start journey with us</p>
                            <button class="ghost" id="signUp">Sign Up</button>
                        </div>
                    </div>
                </div>
                <button class="icon-button close-button"></button>
            </div>
        </div>
        <button class="auth-modal-button btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold" type="button">Login</button>
    </div>



</body>

</html>
