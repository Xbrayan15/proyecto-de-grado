@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-6 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Editar Permiso
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Modifica los detalles del permiso "{{ $permission->name }}"
                    </p>
                    <!-- Breadcrumb -->
                    <nav class="flex mt-3" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="{{ route('permissions.index') }}" class="ml-1 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 md:ml-2">Permisos</a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="{{ route('permissions.show', $permission->id) }}" class="ml-1 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 md:ml-2">{{ $permission->name }}</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-blue-600 dark:text-blue-400 md:ml-2 font-medium">Editar</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Quick Actions -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('permissions.show', $permission->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Ver Permiso
                    </a>
                    <a href="{{ route('permissions.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver a Lista
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form Section -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
                    <!-- Form Header -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Información del Permiso
                            </h3>
                            <div class="flex items-center space-x-2">
                                <span id="changeIndicator" class="hidden px-2 py-1 text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-full">
                                    Cambios detectados
                                </span>
                                <button type="button" id="resetForm" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" title="Resetear formulario">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Form Content -->
                    <form method="POST" action="{{ route('permissions.update', $permission->id) }}" id="editPermissionForm" class="p-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information Section -->
                        <div class="space-y-6">
                            <h4 class="text-md font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-slate-700 pb-2">
                                Información Básica
                            </h4>

                            <!-- Permission Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre del Permiso <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $permission->name) }}" 
                                           data-original="{{ $permission->name }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                                           placeholder="Ej: view_users, edit_products"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span id="nameCounter" class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ strlen($permission->name) }}/50
                                        </span>
                                    </div>
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Use formato snake_case (minúsculas con guiones bajos)
                                </p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Descripción
                                </label>
                                <div class="relative">
                                    <textarea id="description" 
                                              name="description" 
                                              rows="3" 
                                              data-original="{{ $permission->description }}"
                                              class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('description') border-red-500 @enderror" 
                                              placeholder="Descripción detallada del permiso">{{ old('description', $permission->description) }}</textarea>
                                    <div class="absolute bottom-2 right-2">
                                        <span id="descCounter" class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ strlen($permission->description ?? '') }}/255
                                        </span>
                                    </div>
                                </div>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Module Selection -->
                            <div>
                                <label for="module" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Módulo
                                </label>
                                <div class="relative">
                                    <select id="moduleSelect" 
                                            name="module" 
                                            data-original="{{ $permission->module }}"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('module') border-red-500 @enderror">
                                        <option value="">Seleccionar módulo</option>
                                        <option value="users" {{ old('module', $permission->module) == 'users' ? 'selected' : '' }}>👥 Usuarios</option>
                                        <option value="roles" {{ old('module', $permission->module) == 'roles' ? 'selected' : '' }}>🔐 Roles</option>
                                        <option value="permissions" {{ old('module', $permission->module) == 'permissions' ? 'selected' : '' }}>🔑 Permisos</option>
                                        <option value="products" {{ old('module', $permission->module) == 'products' ? 'selected' : '' }}>📦 Productos</option>
                                        <option value="categories" {{ old('module', $permission->module) == 'categories' ? 'selected' : '' }}>🏷️ Categorías</option>
                                        <option value="orders" {{ old('module', $permission->module) == 'orders' ? 'selected' : '' }}>🛒 Pedidos</option>
                                        <option value="payments" {{ old('module', $permission->module) == 'payments' ? 'selected' : '' }}>💳 Pagos</option>
                                        <option value="reports" {{ old('module', $permission->module) == 'reports' ? 'selected' : '' }}>📊 Reportes</option>
                                        <option value="settings" {{ old('module', $permission->module) == 'settings' ? 'selected' : '' }}>⚙️ Configuración</option>
                                        <option value="custom" {{ !in_array(old('module', $permission->module), ['users', 'roles', 'permissions', 'products', 'categories', 'orders', 'payments', 'reports', 'settings']) && old('module', $permission->module) ? 'selected' : '' }}>
                                            ✏️ Personalizado
                                        </option>
                                    </select>
                                </div>
                                @error('module')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror

                                <!-- Custom Module Input -->
                                <div id="customModuleDiv" class="mt-3 {{ !in_array(old('module', $permission->module), ['users', 'roles', 'permissions', 'products', 'categories', 'orders', 'payments', 'reports', 'settings']) && old('module', $permission->module) ? '' : 'hidden' }}">
                                    <input type="text" 
                                           id="customModule" 
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                           placeholder="Nombre del módulo personalizado"
                                           value="{{ !in_array(old('module', $permission->module), ['users', 'roles', 'permissions', 'products', 'categories', 'orders', 'payments', 'reports', 'settings']) ? old('module', $permission->module) : '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Change Summary -->
                        <div id="changeSummary" class="hidden bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Resumen de Cambios
                            </h5>
                            <ul id="changesList" class="text-sm text-yellow-700 dark:text-yellow-300 space-y-1">
                            </ul>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-slate-700">
                            <button type="submit" 
                                    id="submitBtn"
                                    class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-medium rounded-lg transition-colors disabled:cursor-not-allowed">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span id="submitBtnText">Guardar Cambios</span>
                                <svg id="submitSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                            <button type="button" 
                                    onclick="window.history.back()"
                                    class="inline-flex justify-center items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Live Preview -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Vista Previa
                        </h3>
                    </div>
                    <div class="p-6">
                        <div id="previewCard" class="border border-gray-200 dark:border-slate-600 rounded-lg p-4 bg-gray-50 dark:bg-slate-700">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-3.586l4.293-4.293A6 6 0 0119 9z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 id="previewName" class="font-medium text-gray-900 dark:text-white">{{ $permission->name }}</h4>
                                        <p id="previewModule" class="text-sm text-gray-500 dark:text-gray-400">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ $permission->module ?: 'Sin módulo' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p id="previewDescription" class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $permission->description ?: 'Sin descripción' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Current Usage Information -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Uso Actual
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Roles asignados:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $permission->roles->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Usuarios afectados:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $permission->roles->sum(function($role) { return $role->users->count(); }) }}</span>
                        </div>
                        @if($permission->roles->count() > 0)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Roles:</p>
                                <div class="space-y-2">
                                    @foreach($permission->roles->take(3) as $role)
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                                            <span class="text-gray-500 dark:text-gray-400">{{ $role->users->count() }} usuarios</span>
                                        </div>
                                    @endforeach
                                    @if($permission->roles->count() > 3)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            +{{ $permission->roles->count() - 3 }} más...
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Help & Tips -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Consejos
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-3">
                            <div>
                                <p class="font-medium text-gray-700 dark:text-gray-300">⚠️ Cuidado al editar:</p>
                                <p>Los cambios en permisos pueden afectar el acceso de usuarios existentes.</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700 dark:text-gray-300">🔒 Seguridad:</p>
                                <p>Verifica que los cambios no comprometan la seguridad del sistema.</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700 dark:text-gray-300">📋 Formato:</p>
                                <p>Usa snake_case para nombres (ej: view_users, edit_products).</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Audit Information -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Información de Auditoría
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Creado:</span>
                            <span class="text-gray-900 dark:text-white">{{ $permission->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Modificado:</span>
                            <span class="text-gray-900 dark:text-white">{{ $permission->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">ID:</span>
                            <span class="text-gray-900 dark:text-white font-mono">#{{ $permission->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form elements
    const form = document.getElementById('editPermissionForm');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const moduleSelect = document.getElementById('moduleSelect');
    const customModuleDiv = document.getElementById('customModuleDiv');
    const customModuleInput = document.getElementById('customModule');
    const submitBtn = document.getElementById('submitBtn');
    const submitBtnText = document.getElementById('submitBtnText');
    const submitSpinner = document.getElementById('submitSpinner');
    const resetBtn = document.getElementById('resetForm');
    
    // Counter elements
    const nameCounter = document.getElementById('nameCounter');
    const descCounter = document.getElementById('descCounter');
    
    // Preview elements
    const previewName = document.getElementById('previewName');
    const previewDescription = document.getElementById('previewDescription');
    const previewModule = document.getElementById('previewModule');
    
    // Change tracking elements
    const changeIndicator = document.getElementById('changeIndicator');
    const changeSummary = document.getElementById('changeSummary');
    const changesList = document.getElementById('changesList');
    
    // Store original values
    const originalData = {
        name: nameInput.dataset.original,
        description: descriptionInput.dataset.original,
        module: moduleSelect.dataset.original
    };
    
    // Character counters
    function updateCounters() {
        const nameLength = nameInput.value.length;
        const descLength = descriptionInput.value.length;
        
        nameCounter.textContent = `${nameLength}/50`;
        descCounter.textContent = `${descLength}/255`;
        
        // Color coding for limits
        nameCounter.className = nameLength > 40 ? 'text-xs text-orange-500' : 'text-xs text-gray-500 dark:text-gray-400';
        descCounter.className = descLength > 200 ? 'text-xs text-orange-500' : 'text-xs text-gray-500 dark:text-gray-400';
    }
    
    // Live preview update
    function updatePreview() {
        const name = nameInput.value || 'Nombre del permiso';
        const description = descriptionInput.value || 'Sin descripción';
        const module = getCurrentModule() || 'Sin módulo';
        
        previewName.textContent = name;
        previewDescription.textContent = description;
        
        // Update module badge
        const moduleEmojis = {
            'users': '👥',
            'roles': '🔐',
            'permissions': '🔑',
            'products': '📦',
            'categories': '🏷️',
            'orders': '🛒',
            'payments': '💳',
            'reports': '📊',
            'settings': '⚙️'
        };
        
        const emoji = moduleEmojis[module] || '📄';
        previewModule.innerHTML = `
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                ${emoji} ${module}
            </span>
        `;
    }
    
    // Get current module value
    function getCurrentModule() {
        if (moduleSelect.value === 'custom') {
            return customModuleInput.value;
        }
        return moduleSelect.value;
    }
    
    // Change detection
    function detectChanges() {
        const currentData = {
            name: nameInput.value,
            description: descriptionInput.value,
            module: getCurrentModule()
        };
        
        const changes = [];
        let hasChanges = false;
        
        Object.keys(originalData).forEach(key => {
            if (currentData[key] !== originalData[key]) {
                hasChanges = true;
                const labels = {
                    name: 'Nombre',
                    description: 'Descripción',
                    module: 'Módulo'
                };
                changes.push(`${labels[key]}: "${originalData[key] || 'Vacío'}" → "${currentData[key] || 'Vacío'}"`);
            }
        });
        
        // Update UI based on changes
        if (hasChanges) {
            changeIndicator.classList.remove('hidden');
            changeSummary.classList.remove('hidden');
            changesList.innerHTML = changes.map(change => `<li>• ${change}</li>`).join('');
            submitBtnText.textContent = 'Guardar Cambios';
        } else {
            changeIndicator.classList.add('hidden');
            changeSummary.classList.add('hidden');
            submitBtnText.textContent = 'Sin Cambios';
        }
        
        // Enable/disable submit button
        const nameValid = nameInput.value.trim().length > 0;
        submitBtn.disabled = !hasChanges || !nameValid;
    }
    
    // Form validation
    function validateForm() {
        const nameValid = nameInput.value.trim().length > 0;
        const nameLength = nameInput.value.length <= 50;
        const descLength = descriptionInput.value.length <= 255;
        
        // Update field styles
        nameInput.classList.toggle('border-red-500', !nameValid || !nameLength);
        descriptionInput.classList.toggle('border-red-500', !descLength);
        
        return nameValid && nameLength && descLength;
    }
    
    // Module selection handler
    moduleSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customModuleDiv.classList.remove('hidden');
            customModuleInput.focus();
        } else {
            customModuleDiv.classList.add('hidden');
            customModuleInput.value = '';
        }
        updatePreview();
        detectChanges();
    });
    
    // Custom module input handler
    customModuleInput.addEventListener('input', function() {
        updatePreview();
        detectChanges();
    });
    
    // Input event handlers
    nameInput.addEventListener('input', function() {
        updateCounters();
        updatePreview();
        detectChanges();
        validateForm();
    });
    
    descriptionInput.addEventListener('input', function() {
        updateCounters();
        updatePreview();
        detectChanges();
        validateForm();
    });
    
    // Reset form
    resetBtn.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que quieres descartar todos los cambios?')) {
            nameInput.value = originalData.name;
            descriptionInput.value = originalData.description;
            moduleSelect.value = originalData.module;
            
            // Handle custom module
            if (!['users', 'roles', 'permissions', 'products', 'categories', 'orders', 'payments', 'reports', 'settings'].includes(originalData.module)) {
                moduleSelect.value = 'custom';
                customModuleInput.value = originalData.module;
                customModuleDiv.classList.remove('hidden');
            } else {
                customModuleDiv.classList.add('hidden');
                customModuleInput.value = '';
            }
            
            updateCounters();
            updatePreview();
            detectChanges();
            validateForm();
        }
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtnText.textContent = 'Guardando...';
        submitSpinner.classList.remove('hidden');
        
        // Update hidden field for custom module
        if (moduleSelect.value === 'custom') {
            moduleSelect.value = customModuleInput.value;
        }
    });
    
    // Initialize
    updateCounters();
    updatePreview();
    detectChanges();
    validateForm();
    
    // Handle custom module on load
    if (!['users', 'roles', 'permissions', 'products', 'categories', 'orders', 'payments', 'reports', 'settings'].includes(originalData.module) && originalData.module) {
        moduleSelect.value = 'custom';
        customModuleInput.value = originalData.module;
        customModuleDiv.classList.remove('hidden');
    }
});
</script>
@endsection
