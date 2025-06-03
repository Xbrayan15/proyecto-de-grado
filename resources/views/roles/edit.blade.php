@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('roles.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Roles
                </a>
            </li>
            <li class="inline-flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <a href="{{ route('roles.show', $role->id) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">{{ $role->name }}</a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Editar</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Warning Banner for System Roles or Roles with Users -->
    @if($role->is_system || $role->users->count() > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong>Importante:</strong> 
                    @if($role->is_system)
                        Este es un rol del sistema. Los cambios pueden afectar el funcionamiento crítico de la aplicación.
                    @endif
                    @if($role->users->count() > 0)
                        Este rol tiene {{ $role->users->count() }} usuario(s) asignado(s). Los cambios en permisos afectarán inmediatamente su acceso.
                    @endif
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Rol: {{ $role->name }}</h1>
        <p class="text-gray-600">Modifica las configuraciones y permisos del rol</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('roles.update', $role->id) }}" id="role-form" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Información Básica</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Role Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Rol <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}" required
                                    class="w-full px-3 py-2 pr-20 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                    placeholder="Ej: Administrador, Editor, Usuario"
                                    maxlength="255"
                                    data-original="{{ $role->name }}"
                                    oninput="detectChanges(); updateCharCount(this, 'name-count'); validateForm()">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span id="name-count" class="text-xs text-gray-500">{{ strlen($role->name) }}/255</span>
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                placeholder="Describe las responsabilidades y alcance de este rol..."
                                data-original="{{ $role->description }}"
                                oninput="detectChanges(); validateForm()">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Tipo de Rol <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex cursor-pointer rounded-lg border border-gray-300 bg-white p-4 shadow-sm focus:outline-none hover:border-purple-400 hover:shadow-md transition-all duration-200 role-type-option" data-type="custom">
                                    <input type="radio" name="is_system" value="0" class="sr-only" {{ old('is_system', $role->is_system) == '0' ? 'checked' : '' }} data-original="{{ $role->is_system ? '1' : '0' }}" onchange="detectChanges(); validateForm()">
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="flex items-center">
                                                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                                </svg>
                                                <span class="block text-sm font-medium text-gray-900">Rol Personalizado</span>
                                            </span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">
                                                Rol creado por el usuario con permisos específicos
                                            </span>
                                        </span>
                                    </span>
                                    <svg class="h-5 w-5 text-purple-600 role-check hidden" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </label>

                                <label class="relative flex cursor-pointer rounded-lg border border-gray-300 bg-white p-4 shadow-sm focus:outline-none hover:border-green-400 hover:shadow-md transition-all duration-200 role-type-option" data-type="system">
                                    <input type="radio" name="is_system" value="1" class="sr-only" {{ old('is_system', $role->is_system) == '1' ? 'checked' : '' }} data-original="{{ $role->is_system ? '1' : '0' }}" onchange="detectChanges(); validateForm()">
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="flex items-center">
                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                                <span class="block text-sm font-medium text-gray-900">Rol del Sistema</span>
                                            </span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">
                                                Rol crítico con permisos elevados del sistema
                                            </span>
                                        </span>
                                    </span>
                                    <svg class="h-5 w-5 text-green-600 role-check hidden" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </label>
                            </div>
                            @error('is_system')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Parent Role -->
                        @if($parentRoles->count() > 0)
                        <div>
                            <label for="parent_role_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Rol Padre (Opcional)
                            </label>
                            <select id="parent_role_id" name="parent_role_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('parent_role_id') border-red-500 @enderror"
                                data-original="{{ $role->parent_role_id }}"
                                onchange="detectChanges(); validateForm()">
                                <option value="">Sin rol padre</option>
                                @foreach($parentRoles as $parentRole)
                                    <option value="{{ $parentRole->id }}" {{ old('parent_role_id', $role->parent_role_id) == $parentRole->id ? 'selected' : '' }}>
                                        {{ $parentRole->name }} 
                                        @if($parentRole->is_system)
                                            (Sistema)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">El rol heredará algunos permisos del rol padre</p>
                            @error('parent_role_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Permissions -->
                @if($permissions->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Permisos</h3>
                            <div class="flex space-x-2">
                                <button type="button" onclick="selectAllPermissions()" class="text-sm text-blue-600 hover:text-blue-800">
                                    Seleccionar Todos
                                </button>
                                <button type="button" onclick="clearAllPermissions()" class="text-sm text-gray-600 hover:text-gray-800">
                                    Limpiar Todos
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $groupedPermissions = $permissions->groupBy('module');
                                $currentPermissions = old('permissions', $role->permissions->pluck('id')->toArray());
                            @endphp
                            @foreach($groupedPermissions as $module => $modulePermissions)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-medium text-gray-900">{{ $module ?? 'General' }}</h4>
                                    <button type="button" onclick="toggleModulePermissions('{{ $module }}')" class="text-xs text-blue-600 hover:text-blue-800">
                                        Alternar
                                    </button>
                                </div>
                                <div class="space-y-2">
                                    @foreach($modulePermissions as $permission)
                                    <label class="flex items-start space-x-2 cursor-pointer hover:bg-gray-50 rounded p-1 transition-colors">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                            class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded permission-checkbox"
                                            {{ in_array($permission->id, $currentPermissions) ? 'checked' : '' }}
                                            data-module="{{ $module }}"
                                            data-original="{{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : 'unchecked' }}"
                                            onchange="detectChanges(); validateForm()">
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900">{{ $permission->name }}</div>
                                            @if($permission->description)
                                                <div class="text-xs text-gray-500">{{ $permission->description }}</div>
                                            @endif
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('permissions')
                            <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @endif

                <!-- Change Documentation (for roles with users) -->
                @if($role->users->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" id="change-documentation">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Documentación de Cambios</h3>
                        <p class="text-sm text-gray-600 mt-1">Requerido para roles con usuarios asignados</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="change_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Razón del Cambio <span class="text-red-500">*</span>
                            </label>
                            <textarea id="change_reason" name="change_reason" rows="3" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Explica por qué es necesario realizar estos cambios al rol...">{{ old('change_reason') }}</textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="flex items-start space-x-2 cursor-pointer">
                                <input type="checkbox" name="impact_acknowledgment" value="1" required class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="text-sm text-gray-700">Entiendo que estos cambios afectarán inmediatamente a {{ $role->users->count() }} usuario(s)</span>
                            </label>
                            <label class="flex items-start space-x-2 cursor-pointer">
                                <input type="checkbox" name="review_acknowledgment" value="1" required class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="text-sm text-gray-700">He revisado cuidadosamente los permisos antes de realizar cambios</span>
                            </label>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" id="submit-btn" disabled
                        class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gray-400 cursor-not-allowed transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Actualizar Rol
                    </button>
                    <button type="button" onclick="previewChanges()" id="preview-btn" 
                        class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Vista Previa
                    </button>
                    <button type="button" onclick="resetForm()" 
                        class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reiniciar
                    </button>
                    <a href="{{ route('roles.show', $role->id) }}" 
                        class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Original Values -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Valores Originales</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nombre</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $role->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Descripción</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $role->description ?? 'Sin descripción' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tipo</label>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $role->is_system ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $role->is_system ? 'Sistema' : 'Personalizado' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Rol Padre</label>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($role->parent)
                                {{ $role->parent->name }}
                            @else
                                Sin rol padre
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Permisos</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $role->permissions->count() }} permisos</p>
                    </div>
                </div>
            </div>

            <!-- Change Detection -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Detección de Cambios</h3>
                </div>
                <div class="p-6">
                    <div id="changes-detected" class="hidden space-y-3">
                        <div class="flex items-center text-sm text-amber-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            Cambios detectados
                        </div>
                        <div id="changes-list" class="space-y-1 text-sm text-gray-600">
                            <!-- Changes will be listed here -->
                        </div>
                    </div>
                    <div id="no-changes" class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Sin cambios detectados
                    </div>
                </div>
            </div>

            <!-- Usage Impact -->
            @if($role->users->count() > 0)
            <div class="bg-yellow-50 rounded-lg border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-medium text-yellow-900">Impacto de Uso</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center text-sm text-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        {{ $role->users->count() }} usuarios afectados
                    </div>
                    <div class="text-sm text-yellow-700">
                        Los cambios en permisos se aplicarán inmediatamente a todos los usuarios con este rol.
                    </div>
                    @if($role->children->count() > 0)
                    <div class="flex items-center text-sm text-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        {{ $role->children->count() }} roles hijos pueden verse afectados
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Preview Changes Modal -->
<div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Vista Previa de Cambios</h3>
                <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Original</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nuevo Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="preview-table-body">
                        <!-- Preview content will be inserted here -->
                    </tbody>
                </table>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button onclick="closePreviewModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Form interaction and validation
document.addEventListener('DOMContentLoaded', function() {
    updateRoleTypeSelection();
    detectChanges();
    validateForm();
});

function updateCharCount(input, countId) {
    const count = input.value.length;
    const max = input.getAttribute('maxlength');
    document.getElementById(countId).textContent = `${count}/${max}`;
}

function updateRoleTypeSelection() {
    const options = document.querySelectorAll('.role-type-option');
    const radios = document.querySelectorAll('input[name="is_system"]');
    
    radios.forEach(radio => {
        const option = radio.closest('.role-type-option');
        const check = option.querySelector('.role-check');
        
        if (radio.checked) {
            option.classList.add('border-blue-500', 'bg-blue-50');
            option.classList.remove('border-gray-300');
            check.classList.remove('hidden');
        } else {
            option.classList.remove('border-blue-500', 'bg-blue-50');
            option.classList.add('border-gray-300');
            check.classList.add('hidden');
        }
    });
}

function detectChanges() {
    const changesDetected = document.getElementById('changes-detected');
    const noChanges = document.getElementById('no-changes');
    const changesList = document.getElementById('changes-list');
    const previewBtn = document.getElementById('preview-btn');
    
    let changes = [];
    
    // Check each form field for changes
    const fields = [
        { id: 'name', label: 'Nombre' },
        { id: 'description', label: 'Descripción' },
        { id: 'parent_role_id', label: 'Rol Padre' }
    ];
    
    fields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element) {
            const original = element.dataset.original || '';
            const current = element.value || '';
            if (original !== current) {
                changes.push(`${field.label} modificado`);
            }
        }
    });
    
    // Check role type changes
    const systemRadio = document.querySelector('input[name="is_system"]:checked');
    if (systemRadio) {
        const original = systemRadio.dataset.original;
        const current = systemRadio.value;
        if (original !== current) {
            changes.push('Tipo de rol modificado');
        }
    }
    
    // Check permission changes
    let permissionChanges = 0;
    document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
        const original = checkbox.dataset.original;
        const current = checkbox.checked ? 'checked' : 'unchecked';
        if (original !== current) {
            permissionChanges++;
        }
    });
    
    if (permissionChanges > 0) {
        changes.push(`${permissionChanges} permiso(s) modificado(s)`);
    }
    
    // Update UI
    if (changes.length > 0) {
        changesDetected.classList.remove('hidden');
        noChanges.classList.add('hidden');
        previewBtn.disabled = false;
        previewBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        
        changesList.innerHTML = changes.map(change => 
            `<div class="flex items-center text-amber-600">
                <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3"/>
                </svg>
                ${change}
            </div>`
        ).join('');
    } else {
        changesDetected.classList.add('hidden');
        noChanges.classList.remove('hidden');
        previewBtn.disabled = true;
        previewBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
    
    return changes.length > 0;
}

function validateForm() {
    const hasChanges = detectChanges();
    const name = document.getElementById('name').value.trim();
    const submitBtn = document.getElementById('submit-btn');
    
    // Check if change documentation is required and filled
    const changeDoc = document.getElementById('change-documentation');
    let docValid = true;
    
    if (changeDoc && hasChanges) {
        const reason = document.getElementById('change_reason').value.trim();
        const impact = document.querySelector('input[name="impact_acknowledgment"]').checked;
        const review = document.querySelector('input[name="review_acknowledgment"]').checked;
        docValid = reason.length > 0 && impact && review;
    }
    
    if (name.length > 0 && hasChanges && docValid) {
        submitBtn.disabled = false;
        submitBtn.className = 'flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200';
    } else {
        submitBtn.disabled = true;
        submitBtn.className = 'flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gray-400 cursor-not-allowed transition-all duration-200';
    }
}

// Permission management
function selectAllPermissions() {
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    detectChanges();
    validateForm();
}

function clearAllPermissions() {
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    detectChanges();
    validateForm();
}

function toggleModulePermissions(module) {
    const checkboxes = document.querySelectorAll(`input[data-module="${module}"]`);
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });
    detectChanges();
    validateForm();
}

// Preview changes
function previewChanges() {
    const tbody = document.getElementById('preview-table-body');
    tbody.innerHTML = '';
    
    // Helper function to create table row
    function createRow(field, original, current, status) {
        return `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${field}</td>
                <td class="px-6 py-4 text-sm text-gray-500">${original}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${current}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${status === 'changed' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800'}">
                        ${status === 'changed' ? 'Modificado' : 'Sin cambios'}
                    </span>
                </td>
            </tr>
        `;
    }
    
    // Check each field
    const nameElement = document.getElementById('name');
    const originalName = nameElement.dataset.original;
    const currentName = nameElement.value;
    tbody.innerHTML += createRow('Nombre', originalName, currentName, originalName !== currentName ? 'changed' : 'unchanged');
    
    const descElement = document.getElementById('description');
    const originalDesc = descElement.dataset.original || 'Sin descripción';
    const currentDesc = descElement.value || 'Sin descripción';
    tbody.innerHTML += createRow('Descripción', originalDesc, currentDesc, originalDesc !== currentDesc ? 'changed' : 'unchanged');
    
    // Add other fields...
    
    document.getElementById('previewModal').classList.remove('hidden');
}

function closePreviewModal() {
    document.getElementById('previewModal').classList.add('hidden');
}

function resetForm() {
    if (confirm('¿Estás seguro de que deseas reiniciar el formulario? Se perderán todos los cambios.')) {
        location.reload();
    }
}

// Handle radio button changes
document.addEventListener('change', function(e) {
    if (e.target.name === 'is_system') {
        updateRoleTypeSelection();
    }
    detectChanges();
    validateForm();
});

// Handle form input changes
document.getElementById('role-form').addEventListener('input', function() {
    detectChanges();
    validateForm();
});

// Close modal when clicking outside
document.getElementById('previewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePreviewModal();
    }
});
</script>
@endsection
