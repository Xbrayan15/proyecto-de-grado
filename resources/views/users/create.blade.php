@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Crear Nuevo Usuario</h1>
                <p class="text-blue-100">Agregar un nuevo usuario al sistema con roles y permisos</p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white/20 rounded-lg p-4">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Información del Usuario</h2>
                </div>

                <form method="POST" action="{{ route('users.store') }}" id="userForm" class="p-6 space-y-6">
                    @csrf

                    <!-- Personal Information -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre completo
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('name') border-red-500 @enderror"
                                placeholder="Ingrese el nombre completo"
                                required
                                oninput="updatePreview()"
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-1 text-sm text-gray-500" id="nameCounter">0 / 255 caracteres</div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Correo electrónico
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('email') border-red-500 @enderror"
                                placeholder="usuario@ejemplo.com"
                                required
                                oninput="updatePreview()"
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-1 text-sm text-gray-500">
                                <span id="emailValidation" class="hidden text-green-600">✓ Formato válido</span>
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Contraseña
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('password') border-red-500 @enderror"
                                    placeholder="Mínimo 8 caracteres"
                                    required
                                    minlength="8"
                                    oninput="validatePassword()"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                >
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-2 space-y-1">
                                <div class="flex items-center text-sm" id="passwordLength">
                                    <span class="w-4 h-4 rounded-full border-2 border-gray-300 mr-2" id="lengthCheck"></span>
                                    Mínimo 8 caracteres
                                </div>
                                <div class="flex items-center text-sm" id="passwordUpper">
                                    <span class="w-4 h-4 rounded-full border-2 border-gray-300 mr-2" id="upperCheck"></span>
                                    Al menos una mayúscula
                                </div>
                                <div class="flex items-center text-sm" id="passwordNumber">
                                    <span class="w-4 h-4 rounded-full border-2 border-gray-300 mr-2" id="numberCheck"></span>
                                    Al menos un número
                                </div>
                            </div>
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmar contraseña
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                    placeholder="Repita la contraseña"
                                    required
                                    oninput="validatePasswordConfirmation()"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password_confirmation')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                >
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-1 text-sm" id="passwordMatch"></div>
                        </div>
                    </div>

                    <!-- Password Generator -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-blue-800">Generador de contraseñas</h3>
                                <p class="text-sm text-blue-600">Genere una contraseña segura automáticamente</p>
                            </div>
                            <button 
                                type="button" 
                                onclick="generatePassword()"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200"
                            >
                                Generar
                            </button>
                        </div>
                    </div>

                    <!-- Roles Assignment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Roles asignados
                            <span class="text-gray-500 font-normal">(Opcional)</span>
                        </label>
                        <div class="grid md:grid-cols-2 gap-3">
                            @foreach($roles as $role)
                            <label class="flex items-start space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="roles[]" 
                                    value="{{ $role->id }}"
                                    class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    onchange="updatePreview()"
                                >
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $role->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $role->description ?? 'Sin descripción' }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @if($roles->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <p class="mt-2">No hay roles disponibles</p>
                            <a href="{{ route('roles.create') }}" class="text-blue-600 hover:text-blue-800">Crear un rol</a>
                        </div>
                        @endif
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="flex items-center space-x-3">
                            <button 
                                type="button" 
                                onclick="resetForm()"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200"
                            >
                                Limpiar
                            </button>
                            <button 
                                type="button" 
                                onclick="saveDraft()"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200"
                            >
                                Guardar borrador
                            </button>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a 
                                href="{{ route('users.index') }}" 
                                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200"
                            >
                                Cancelar
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200"
                                id="submitBtn"
                            >
                                Crear usuario
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Live Preview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Vista previa</h3>
                </div>
                <div class="p-4">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold" id="previewAvatar">
                            U
                        </div>
                        <div>
                            <div class="font-medium text-gray-900" id="previewName">Nuevo usuario</div>
                            <div class="text-sm text-gray-500" id="previewEmail">usuario@ejemplo.com</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="text-sm">
                            <span class="text-gray-600">Roles:</span>
                            <div id="previewRoles" class="mt-1 flex flex-wrap gap-1">
                                <span class="text-gray-400 text-xs">Sin roles asignados</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help & Tips -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl">
                <div class="p-4 border-b border-amber-200">
                    <h3 class="text-lg font-semibold text-amber-800">Consejos útiles</h3>
                </div>
                <div class="p-4 space-y-3 text-sm text-amber-700">
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Use contraseñas seguras con al menos 8 caracteres</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Asigne roles apropiados según las responsabilidades</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Verifique que el email sea válido y único</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Puede guardar un borrador y continuar más tarde</span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Estadísticas rápidas</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total de usuarios</span>
                        <span class="font-semibold text-gray-900">{{ App\Models\User::count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Roles disponibles</span>
                        <span class="font-semibold text-gray-900">{{ $roles->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Usuarios verificados</span>
                        <span class="font-semibold text-gray-900">{{ App\Models\User::whereNotNull('email_verified_at')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Draft Save Modal -->
<div id="draftModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Borrador guardado</h3>
                    <p class="text-sm text-gray-500 mb-4">Los datos del formulario se han guardado localmente. Puede continuar editando más tarde.</p>
                    <button 
                        onclick="closeDraftModal()"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200"
                    >
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation and preview functionality
function updatePreview() {
    const name = document.getElementById('name').value || 'Nuevo usuario';
    const email = document.getElementById('email').value || 'usuario@ejemplo.com';
    
    // Update avatar with initials
    const avatar = document.getElementById('previewAvatar');
    const initials = name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
    avatar.textContent = initials || 'U';
    
    // Update name and email
    document.getElementById('previewName').textContent = name;
    document.getElementById('previewEmail').textContent = email;
    
    // Update roles
    const selectedRoles = Array.from(document.querySelectorAll('input[name="roles[]"]:checked')).map(input => {
        const label = input.closest('label').querySelector('div:first-child').textContent;
        return `<span class="inline-block px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">${label}</span>`;
    });
    
    const rolesContainer = document.getElementById('previewRoles');
    if (selectedRoles.length > 0) {
        rolesContainer.innerHTML = selectedRoles.join(' ');
    } else {
        rolesContainer.innerHTML = '<span class="text-gray-400 text-xs">Sin roles asignados</span>';
    }
    
    // Update character counter
    const nameCounter = document.getElementById('nameCounter');
    nameCounter.textContent = `${name.length} / 255 caracteres`;
    
    // Email validation
    const emailInput = document.getElementById('email');
    const emailValidation = document.getElementById('emailValidation');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (emailRegex.test(email) && email !== 'usuario@ejemplo.com') {
        emailValidation.classList.remove('hidden');
        emailInput.classList.remove('border-red-500');
        emailInput.classList.add('border-green-500');
    } else {
        emailValidation.classList.add('hidden');
        emailInput.classList.remove('border-green-500');
    }
}

function validatePassword() {
    const password = document.getElementById('password').value;
    const lengthCheck = document.getElementById('lengthCheck');
    const upperCheck = document.getElementById('upperCheck');
    const numberCheck = document.getElementById('numberCheck');
    
    // Length check
    if (password.length >= 8) {
        lengthCheck.classList.add('bg-green-500', 'border-green-500');
        lengthCheck.classList.remove('border-gray-300');
        document.getElementById('passwordLength').classList.add('text-green-600');
        document.getElementById('passwordLength').classList.remove('text-gray-500');
    } else {
        lengthCheck.classList.remove('bg-green-500', 'border-green-500');
        lengthCheck.classList.add('border-gray-300');
        document.getElementById('passwordLength').classList.remove('text-green-600');
        document.getElementById('passwordLength').classList.add('text-gray-500');
    }
    
    // Uppercase check
    if (/[A-Z]/.test(password)) {
        upperCheck.classList.add('bg-green-500', 'border-green-500');
        upperCheck.classList.remove('border-gray-300');
        document.getElementById('passwordUpper').classList.add('text-green-600');
        document.getElementById('passwordUpper').classList.remove('text-gray-500');
    } else {
        upperCheck.classList.remove('bg-green-500', 'border-green-500');
        upperCheck.classList.add('border-gray-300');
        document.getElementById('passwordUpper').classList.remove('text-green-600');
        document.getElementById('passwordUpper').classList.add('text-gray-500');
    }
    
    // Number check
    if (/\d/.test(password)) {
        numberCheck.classList.add('bg-green-500', 'border-green-500');
        numberCheck.classList.remove('border-gray-300');
        document.getElementById('passwordNumber').classList.add('text-green-600');
        document.getElementById('passwordNumber').classList.remove('text-gray-500');
    } else {
        numberCheck.classList.remove('bg-green-500', 'border-green-500');
        numberCheck.classList.add('border-gray-300');
        document.getElementById('passwordNumber').classList.remove('text-green-600');
        document.getElementById('passwordNumber').classList.add('text-gray-500');
    }
    
    validatePasswordConfirmation();
}

function validatePasswordConfirmation() {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    const matchDiv = document.getElementById('passwordMatch');
    
    if (confirmation.length > 0) {
        if (password === confirmation) {
            matchDiv.innerHTML = '<span class="text-green-600">✓ Las contraseñas coinciden</span>';
            document.getElementById('password_confirmation').classList.add('border-green-500');
            document.getElementById('password_confirmation').classList.remove('border-red-500');
        } else {
            matchDiv.innerHTML = '<span class="text-red-600">✗ Las contraseñas no coinciden</span>';
            document.getElementById('password_confirmation').classList.add('border-red-500');
            document.getElementById('password_confirmation').classList.remove('border-green-500');
        }
    } else {
        matchDiv.innerHTML = '';
        document.getElementById('password_confirmation').classList.remove('border-green-500', 'border-red-500');
    }
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    field.type = field.type === 'password' ? 'text' : 'password';
}

function generatePassword() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let password = '';
    
    // Ensure at least one uppercase, one lowercase, one number, one special char
    password += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'[Math.floor(Math.random() * 26)];
    password += 'abcdefghijklmnopqrstuvwxyz'[Math.floor(Math.random() * 26)];
    password += '0123456789'[Math.floor(Math.random() * 10)];
    password += '!@#$%^&*'[Math.floor(Math.random() * 8)];
    
    // Fill the rest randomly
    for (let i = 4; i < 12; i++) {
        password += chars[Math.floor(Math.random() * chars.length)];
    }
    
    // Shuffle the password
    password = password.split('').sort(() => Math.random() - 0.5).join('');
    
    document.getElementById('password').value = password;
    document.getElementById('password_confirmation').value = password;
    
    validatePassword();
    validatePasswordConfirmation();
}

function resetForm() {
    if (confirm('¿Está seguro de que desea limpiar todos los campos? Esta acción no se puede deshacer.')) {
        document.getElementById('userForm').reset();
        updatePreview();
        
        // Reset validation states
        document.querySelectorAll('.border-green-500, .border-red-500').forEach(el => {
            el.classList.remove('border-green-500', 'border-red-500');
        });
        
        document.getElementById('passwordMatch').innerHTML = '';
        document.getElementById('emailValidation').classList.add('hidden');
        
        // Reset password validation
        ['lengthCheck', 'upperCheck', 'numberCheck'].forEach(id => {
            const el = document.getElementById(id);
            el.classList.remove('bg-green-500', 'border-green-500');
            el.classList.add('border-gray-300');
        });
        
        ['passwordLength', 'passwordUpper', 'passwordNumber'].forEach(id => {
            const el = document.getElementById(id);
            el.classList.remove('text-green-600');
            el.classList.add('text-gray-500');
        });
    }
}

function saveDraft() {
    const formData = new FormData(document.getElementById('userForm'));
    const draft = {};
    
    for (let [key, value] of formData.entries()) {
        if (draft[key]) {
            if (Array.isArray(draft[key])) {
                draft[key].push(value);
            } else {
                draft[key] = [draft[key], value];
            }
        } else {
            draft[key] = value;
        }
    }
    
    localStorage.setItem('userDraft', JSON.stringify(draft));
    document.getElementById('draftModal').classList.remove('hidden');
}

function loadDraft() {
    const draft = localStorage.getItem('userDraft');
    if (draft) {
        const data = JSON.parse(draft);
        
        Object.keys(data).forEach(key => {
            const field = document.querySelector(`[name="${key}"]`);
            if (field) {
                if (field.type === 'checkbox') {
                    const values = Array.isArray(data[key]) ? data[key] : [data[key]];
                    document.querySelectorAll(`[name="${key}"]`).forEach(checkbox => {
                        checkbox.checked = values.includes(checkbox.value);
                    });
                } else {
                    field.value = data[key];
                }
            }
        });
        
        updatePreview();
        validatePassword();
    }
}

function closeDraftModal() {
    document.getElementById('draftModal').classList.add('hidden');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
    loadDraft();
    
    // Add real-time validation
    document.getElementById('name').addEventListener('input', updatePreview);
    document.getElementById('email').addEventListener('input', updatePreview);
});
</script>
@endsection
