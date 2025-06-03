@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Editar Usuario</h1>
                <p class="text-purple-100">Modificar información y roles de {{ $user->name }}</p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white/20 rounded-lg p-4">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
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
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-800">Información del Usuario</h2>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Última actualización: {{ $user->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('users.update', $user->id) }}" id="userForm" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Change Detection Hidden Fields -->
                    <input type="hidden" id="originalName" value="{{ $user->name }}">
                    <input type="hidden" id="originalEmail" value="{{ $user->email }}">
                    <input type="hidden" id="originalRoles" value="{{ implode(',', $user->roles->pluck('id')->toArray()) }}">

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
                                value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 @error('name') border-red-500 @enderror"
                                placeholder="Ingrese el nombre completo"
                                required
                                oninput="updatePreviewAndChanges()"
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
                                value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 @error('email') border-red-500 @enderror"
                                placeholder="usuario@ejemplo.com"
                                required
                                oninput="updatePreviewAndChanges()"
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
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-yellow-800 mb-3">Cambiar contraseña (opcional)</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nueva contraseña
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 @error('password') border-red-500 @enderror"
                                        placeholder="Dejar en blanco para mantener actual"
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
                                <div class="mt-2 space-y-1" id="passwordValidation" style="display: none;">
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
                                    Confirmar nueva contraseña
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password_confirmation" 
                                        name="password_confirmation"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                                        placeholder="Repita la nueva contraseña"
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
                        <div class="mt-4 flex items-center justify-between bg-white border border-yellow-300 rounded-lg p-3">
                            <div>
                                <span class="text-sm font-medium text-yellow-800">Generador de contraseñas</span>
                                <p class="text-sm text-yellow-600">Genere una contraseña segura automáticamente</p>
                            </div>
                            <button 
                                type="button" 
                                onclick="generatePassword()"
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-200"
                            >
                                Generar
                            </button>
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Verification Status -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Estado de verificación</h3>
                            <div class="flex items-center space-x-2">
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Verificado
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $user->email_verified_at->format('d/m/Y H:i') }}</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        Sin verificar
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Account Creation -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Creación de cuenta</h3>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 6v2m-6-6h12a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2z"/>
                                </svg>
                                <span class="text-sm text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                                <span class="text-sm text-gray-500">({{ $user->created_at->diffForHumans() }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Roles Assignment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Roles asignados
                            <span class="text-gray-500 font-normal">({{ $user->roles->count() }} actuales)</span>
                        </label>
                        <div class="grid md:grid-cols-2 gap-3">
                            @foreach($roles as $role)
                            <label class="flex items-start space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="roles[]" 
                                    value="{{ $role->id }}"
                                    class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                    {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                                    onchange="updatePreviewAndChanges()"
                                >
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $role->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $role->description ?? 'Sin descripción' }}</div>
                                    @if($user->roles->contains($role->id))
                                        <div class="text-xs text-purple-600 mt-1">● Asignado actualmente</div>
                                    @endif
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
                            <a href="{{ route('roles.create') }}" class="text-purple-600 hover:text-purple-800">Crear un rol</a>
                        </div>
                        @endif
                    </div>

                    <!-- Change Summary -->
                    <div id="changeSummary" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">Resumen de cambios</h3>
                        <div id="changesList" class="space-y-1 text-sm text-blue-700"></div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="flex items-center space-x-3">
                            <button 
                                type="button" 
                                onclick="resetChanges()"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200"
                                id="resetBtn"
                                disabled
                            >
                                Descartar cambios
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
                                href="{{ route('users.show', $user->id) }}" 
                                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200"
                            >
                                Cancelar
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200"
                                id="submitBtn"
                                disabled
                            >
                                Guardar cambios
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
                    <h3 class="text-lg font-semibold text-gray-800">Vista previa actualizada</h3>
                </div>
                <div class="p-4">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center text-white font-semibold" id="previewAvatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900" id="previewName">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500" id="previewEmail">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="text-sm">
                            <span class="text-gray-600">Roles actualizados:</span>
                            <div id="previewRoles" class="mt-1 flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full">{{ $role->name }}</span>
                                @endforeach
                                @if($user->roles->isEmpty())
                                <span class="text-gray-400 text-xs">Sin roles asignados</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Información actual</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <span class="text-sm text-gray-600">Nombre:</span>
                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Email:</span>
                        <div class="font-medium text-gray-900">{{ $user->email }}</div>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Roles:</span>
                        <div class="mt-1 flex flex-wrap gap-1">
                            @foreach($user->roles as $role)
                            <span class="inline-block px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">{{ $role->name }}</span>
                            @endforeach
                            @if($user->roles->isEmpty())
                            <span class="text-gray-400 text-xs">Sin roles asignados</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help & Tips -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl">
                <div class="p-4 border-b border-amber-200">
                    <h3 class="text-lg font-semibold text-amber-800">Consejos de edición</h3>
                </div>
                <div class="p-4 space-y-3 text-sm text-amber-700">
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Los cambios se detectan automáticamente</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Deje la contraseña vacía para mantener la actual</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Cambiar roles afecta los permisos del usuario</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Use "Descartar cambios" para revertir ediciones</span>
                    </div>
                </div>
            </div>

            <!-- User Statistics -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Estadísticas del usuario</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">ID del usuario</span>
                        <span class="font-semibold text-gray-900">#{{ $user->id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Roles asignados</span>
                        <span class="font-semibold text-gray-900">{{ $user->roles->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Permisos totales</span>
                        <span class="font-semibold text-gray-900">
                            {{ $user->roles->flatMap(function($role) { return $role->permissions ?? collect(); })->unique('id')->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Días desde creación</span>
                        <span class="font-semibold text-gray-900">{{ $user->created_at->diffInDays() }}</span>
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
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Borrador guardado</h3>
                    <p class="text-sm text-gray-500 mb-4">Los cambios se han guardado localmente. Puede continuar editando más tarde.</p>
                    <button 
                        onclick="closeDraftModal()"
                        class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200"
                    >
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Original values for change detection
const originalValues = {
    name: document.getElementById('originalName').value,
    email: document.getElementById('originalEmail').value,
    roles: document.getElementById('originalRoles').value.split(',').filter(id => id)
};

// Form validation and change detection
function updatePreviewAndChanges() {
    updatePreview();
    detectChanges();
}

function updatePreview() {
    const name = document.getElementById('name').value || 'Usuario';
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
        return `<span class="inline-block px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full">${label}</span>`;
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
    
    if (emailRegex.test(email)) {
        emailValidation.classList.remove('hidden');
        emailInput.classList.remove('border-red-500');
        emailInput.classList.add('border-green-500');
    } else {
        emailValidation.classList.add('hidden');
        emailInput.classList.remove('border-green-500');
    }
}

function detectChanges() {
    const currentName = document.getElementById('name').value;
    const currentEmail = document.getElementById('email').value;
    const currentRoles = Array.from(document.querySelectorAll('input[name="roles[]"]:checked')).map(input => input.value);
    const currentPassword = document.getElementById('password').value;
    
    const changes = [];
    let hasChanges = false;
    
    // Check name change
    if (currentName !== originalValues.name) {
        changes.push(`• Nombre: "${originalValues.name}" → "${currentName}"`);
        hasChanges = true;
    }
    
    // Check email change
    if (currentEmail !== originalValues.email) {
        changes.push(`• Email: "${originalValues.email}" → "${currentEmail}"`);
        hasChanges = true;
    }
    
    // Check password change
    if (currentPassword.length > 0) {
        changes.push(`• Contraseña: Se establecerá una nueva contraseña`);
        hasChanges = true;
    }
    
    // Check roles change
    const originalRolesSet = new Set(originalValues.roles);
    const currentRolesSet = new Set(currentRoles);
    
    if (originalRolesSet.size !== currentRolesSet.size || 
        ![...originalRolesSet].every(role => currentRolesSet.has(role))) {
        
        const addedRoles = [...currentRolesSet].filter(role => !originalRolesSet.has(role));
        const removedRoles = [...originalRolesSet].filter(role => !currentRolesSet.has(role));
        
        if (addedRoles.length > 0) {
            const roleNames = addedRoles.map(id => {
                const input = document.querySelector(`input[value="${id}"]`);
                return input ? input.closest('label').querySelector('div:first-child').textContent : id;
            });
            changes.push(`• Roles agregados: ${roleNames.join(', ')}`);
        }
        
        if (removedRoles.length > 0) {
            const roleNames = removedRoles.map(id => {
                const input = document.querySelector(`input[value="${id}"]`);
                return input ? input.closest('label').querySelector('div:first-child').textContent : id;
            });
            changes.push(`• Roles removidos: ${roleNames.join(', ')}`);
        }
        
        hasChanges = true;
    }
    
    // Update UI based on changes
    const changeSummary = document.getElementById('changeSummary');
    const changesList = document.getElementById('changesList');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetBtn');
    
    if (hasChanges) {
        changeSummary.classList.remove('hidden');
        changesList.innerHTML = changes.join('<br>');
        submitBtn.disabled = false;
        resetBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        resetBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
        changeSummary.classList.add('hidden');
        changesList.innerHTML = '';
        submitBtn.disabled = true;
        resetBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        resetBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

function validatePassword() {
    const password = document.getElementById('password').value;
    const validation = document.getElementById('passwordValidation');
    
    if (password.length > 0) {
        validation.style.display = 'block';
        
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
    } else {
        validation.style.display = 'none';
    }
    
    validatePasswordConfirmation();
    detectChanges();
}

function validatePasswordConfirmation() {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    const matchDiv = document.getElementById('passwordMatch');
    
    if (confirmation.length > 0 && password.length > 0) {
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

function resetChanges() {
    if (confirm('¿Está seguro de que desea descartar todos los cambios? Esta acción no se puede deshacer.')) {
        // Reset form to original values
        document.getElementById('name').value = originalValues.name;
        document.getElementById('email').value = originalValues.email;
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
        
        // Reset role checkboxes
        document.querySelectorAll('input[name="roles[]"]').forEach(checkbox => {
            checkbox.checked = originalValues.roles.includes(checkbox.value);
        });
        
        // Reset validation states
        document.querySelectorAll('.border-green-500, .border-red-500').forEach(el => {
            el.classList.remove('border-green-500', 'border-red-500');
        });
        
        document.getElementById('passwordMatch').innerHTML = '';
        document.getElementById('emailValidation').classList.add('hidden');
        document.getElementById('passwordValidation').style.display = 'none';
        
        updatePreview();
        detectChanges();
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
    
    draft.userId = {{ $user->id }};
    localStorage.setItem('userEditDraft_{{ $user->id }}', JSON.stringify(draft));
    document.getElementById('draftModal').classList.remove('hidden');
}

function loadDraft() {
    const draft = localStorage.getItem('userEditDraft_{{ $user->id }}');
    if (draft) {
        const data = JSON.parse(draft);
        
        Object.keys(data).forEach(key => {
            if (key === 'userId') return;
            
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
        detectChanges();
        validatePassword();
    }
}

function closeDraftModal() {
    document.getElementById('draftModal').classList.add('hidden');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
    detectChanges();
    loadDraft();
    
    // Add event listeners
    document.getElementById('name').addEventListener('input', updatePreviewAndChanges);
    document.getElementById('email').addEventListener('input', updatePreviewAndChanges);
    document.querySelectorAll('input[name="roles[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updatePreviewAndChanges);
    });
});
</script>
@endsection
