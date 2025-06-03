@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Crear Nuevo Permiso</h1>
                    <p class="mt-2 text-gray-600">Define un nuevo permiso para el sistema de roles</p>
                </div>
                <a href="{{ route('permissions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver a Permisos
                </a>
            </div>
        </div>

        <!-- Breadcrumbs -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('permissions.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Permisos
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Crear Permiso</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <form id="permission-form" method="POST" action="{{ route('permissions.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Información Básica
                            </h3>
                        </div>
                        <div class="px-6 py-6">
                            <div class="grid grid-cols-1 gap-6">
                                <!-- Permission Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nombre del Permiso <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="name" name="name" required
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Ej: manage_users, view_reports, edit_products"
                                               value="{{ old('name') }}"
                                               maxlength="255">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <span id="name-counter" class="text-sm text-gray-400">0/255</span>
                                        </div>
                                    </div>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                        <p class="mt-1 text-sm text-gray-500">Usa nombres descriptivos y únicos. Se recomienda usar guiones bajos (_) para separar palabras.</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                        Descripción
                                    </label>
                                    <textarea id="description" name="description" rows="4"
                                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Describe qué permite hacer este permiso y en qué contexto se utiliza...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                        <p class="mt-1 text-sm text-gray-500">Proporciona una descripción clara de qué acciones permite este permiso.</p>
                                    @enderror
                                </div>

                                <!-- Module Selection -->
                                <div>
                                    <label for="module" class="block text-sm font-medium text-gray-700 mb-2">
                                        Módulo del Sistema
                                    </label>
                                    <div class="relative">
                                        <select id="module" name="module"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Seleccionar módulo...</option>
                                            <option value="users" {{ old('module') === 'users' ? 'selected' : '' }}>Usuarios</option>
                                            <option value="roles" {{ old('module') === 'roles' ? 'selected' : '' }}>Roles</option>
                                            <option value="permissions" {{ old('module') === 'permissions' ? 'selected' : '' }}>Permisos</option>
                                            <option value="products" {{ old('module') === 'products' ? 'selected' : '' }}>Productos</option>
                                            <option value="categories" {{ old('module') === 'categories' ? 'selected' : '' }}>Categorías</option>
                                            <option value="orders" {{ old('module') === 'orders' ? 'selected' : '' }}>Órdenes</option>
                                            <option value="payments" {{ old('module') === 'payments' ? 'selected' : '' }}>Pagos</option>
                                            <option value="inventory" {{ old('module') === 'inventory' ? 'selected' : '' }}>Inventario</option>
                                            <option value="reports" {{ old('module') === 'reports' ? 'selected' : '' }}>Reportes</option>
                                            <option value="audit" {{ old('module') === 'audit' ? 'selected' : '' }}>Auditoría</option>
                                            <option value="settings" {{ old('module') === 'settings' ? 'selected' : '' }}>Configuración</option>
                                            <option value="other">Otro (especificar)</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Custom Module Input (shown when "other" is selected) -->
                                    <div id="custom-module-input" class="mt-3 hidden">
                                        <input type="text" id="custom-module" name="custom_module" 
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Nombre del módulo personalizado">
                                    </div>

                                    @error('module')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                        <p class="mt-1 text-sm text-gray-500">Agrupa los permisos por módulos para una mejor organización.</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Templates -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Plantillas Rápidas
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Opcional
                                </span>
                            </h3>
                        </div>
                        <div class="px-6 py-6">
                            <p class="text-sm text-gray-600 mb-4">Selecciona una plantilla para auto-completar los campos con valores predefinidos comunes:</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                <button type="button" onclick="applyTemplate('view')" class="template-btn p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors duration-200 text-left">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Ver/Consultar</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Permisos de solo lectura</p>
                                </button>

                                <button type="button" onclick="applyTemplate('create')" class="template-btn p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors duration-200 text-left">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Crear</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Permisos de creación</p>
                                </button>

                                <button type="button" onclick="applyTemplate('edit')" class="template-btn p-4 border border-gray-200 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition-colors duration-200 text-left">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Editar</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Permisos de modificación</p>
                                </button>

                                <button type="button" onclick="applyTemplate('delete')" class="template-btn p-4 border border-gray-200 rounded-lg hover:border-red-500 hover:bg-red-50 transition-colors duration-200 text-left">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Eliminar</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Permisos de eliminación</p>
                                </button>

                                <button type="button" onclick="applyTemplate('manage')" class="template-btn p-4 border border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors duration-200 text-left">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Gestionar</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Permisos administrativos</p>
                                </button>

                                <button type="button" onclick="applyTemplate('export')" class="template-btn p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition-colors duration-200 text-left">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Exportar</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Permisos de exportación</p>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Options -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                </svg>
                                Opciones Adicionales
                            </h3>
                        </div>
                        <div class="px-6 py-6">
                            <!-- Save as Draft -->
                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center">
                                    <input type="checkbox" id="save-draft" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="save-draft" class="ml-3 text-sm font-medium text-gray-700">
                                        Guardar como borrador automáticamente
                                    </label>
                                </div>
                                <button type="button" onclick="saveDraft()" class="text-sm text-blue-600 hover:text-blue-800">
                                    Guardar ahora
                                </button>
                            </div>

                            <!-- Post-creation action -->
                            <div class="border-t pt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Después de crear el permiso:</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="post_action" value="index" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-sm text-gray-700">Volver a la lista de permisos</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="post_action" value="show" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-sm text-gray-700">Ver el permiso creado</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="post_action" value="create" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-sm text-gray-700">Crear otro permiso</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4">
                            <div class="flex justify-between items-center">
                                <button type="button" onclick="resetForm()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Limpiar Formulario
                                </button>
                                <div class="space-x-3">
                                    <a href="{{ route('permissions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Cancelar
                                    </a>
                                    <button type="submit" id="submit-btn" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Crear Permiso
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Live Preview -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Vista Previa
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <div id="preview-content" class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900" id="preview-name">
                                        [Nombre del permiso]
                                    </div>
                                    <div class="text-sm text-gray-500" id="preview-description">
                                        [Descripción del permiso]
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t pt-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">MÓDULO</label>
                                <span id="preview-module" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Sin módulo
                                </span>
                            </div>

                            <div class="border-t pt-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">ESTADO</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Nuevo
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help & Tips -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Ayuda y Consejos
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4 text-sm text-gray-600">
                            <div>
                                <h4 class="font-medium text-gray-900 mb-1">💡 Convenciones de Nombres</h4>
                                <ul class="space-y-1 text-xs">
                                    <li>• Usa guiones bajos (_) para separar palabras</li>
                                    <li>• Comienza con el verbo de acción: create_, view_, edit_, delete_</li>
                                    <li>• Añade el objeto: create_users, edit_products</li>
                                </ul>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-900 mb-1">🔒 Principios de Seguridad</h4>
                                <ul class="space-y-1 text-xs">
                                    <li>• Sigue el principio de menor privilegio</li>
                                    <li>• Crea permisos específicos, no generales</li>
                                    <li>• Documenta claramente cada permiso</li>
                                </ul>
                            </div>

                            <div>
                                <h4 class="font-medium text-gray-900 mb-1">📋 Ejemplos Comunes</h4>
                                <ul class="space-y-1 text-xs">
                                    <li>• view_users_list</li>
                                    <li>• create_product</li>
                                    <li>• edit_own_profile</li>
                                    <li>• delete_orders</li>
                                    <li>• export_reports</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Draft Status -->
                <div id="draft-status" class="bg-white shadow rounded-lg hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Borrador Guardado
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-sm text-gray-600" id="draft-info">
                            Se encontró un borrador guardado anteriormente.
                        </p>
                        <div class="mt-3 space-x-2">
                            <button onclick="loadDraft()" class="text-sm text-blue-600 hover:text-blue-800">
                                Cargar borrador
                            </button>
                            <button onclick="clearDraft()" class="text-sm text-red-600 hover:text-red-800">
                                Eliminar borrador
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let formValidation = {
    name: false,
    isValid: function() {
        return this.name;
    }
};

// Templates data
const templates = {
    view: {
        name: 'view_[module]',
        description: 'Permite ver y consultar información de [module]. Solo lectura, sin capacidad de modificación.',
        module: ''
    },
    create: {
        name: 'create_[module]',
        description: 'Permite crear nuevos registros de [module]. Incluye acceso a formularios de creación.',
        module: ''
    },
    edit: {
        name: 'edit_[module]',
        description: 'Permite modificar y actualizar registros existentes de [module].',
        module: ''
    },
    delete: {
        name: 'delete_[module]',
        description: 'Permite eliminar registros de [module]. Acción irreversible que requiere confirmación.',
        module: ''
    },
    manage: {
        name: 'manage_[module]',
        description: 'Acceso completo para administrar [module]. Incluye crear, editar, eliminar y configurar.',
        module: ''
    },
    export: {
        name: 'export_[module]',
        description: 'Permite exportar datos de [module] en diferentes formatos (CSV, PDF, Excel).',
        module: ''
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // Character counter for name field
    const nameInput = document.getElementById('name');
    const nameCounter = document.getElementById('name-counter');
    
    nameInput.addEventListener('input', function() {
        const length = this.value.length;
        nameCounter.textContent = `${length}/255`;
        
        // Validation
        formValidation.name = length > 0 && length <= 255;
        updateSubmitButton();
        updatePreview();
    });

    // Description change handler
    document.getElementById('description').addEventListener('input', updatePreview);

    // Module selection handler
    const moduleSelect = document.getElementById('module');
    const customModuleInput = document.getElementById('custom-module-input');
    
    moduleSelect.addEventListener('change', function() {
        if (this.value === 'other') {
            customModuleInput.classList.remove('hidden');
        } else {
            customModuleInput.classList.add('hidden');
        }
        updatePreview();
    });

    // Custom module input handler
    document.getElementById('custom-module').addEventListener('input', updatePreview);

    // Auto-save draft
    const saveAsDraftCheckbox = document.getElementById('save-draft');
    let autoSaveInterval;

    saveAsDraftCheckbox.addEventListener('change', function() {
        if (this.checked) {
            autoSaveInterval = setInterval(saveDraft, 30000); // Save every 30 seconds
        } else {
            clearInterval(autoSaveInterval);
        }
    });

    // Check for existing draft
    checkForDraft();

    // Form submission handler
    document.getElementById('permission-form').addEventListener('submit', function(e) {
        const moduleSelect = document.getElementById('module');
        const customModule = document.getElementById('custom-module');
        
        if (moduleSelect.value === 'other' && customModule.value.trim()) {
            // Create a hidden input for the custom module
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'module';
            hiddenInput.value = customModule.value.trim();
            this.appendChild(hiddenInput);
            
            // Remove the module select from submission
            moduleSelect.removeAttribute('name');
        }
        
        // Clear draft on successful submission
        localStorage.removeItem('permission_draft');
    });

    // Initial preview update
    updatePreview();
});

function updateSubmitButton() {
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = !formValidation.isValid();
}

function updatePreview() {
    const name = document.getElementById('name').value || '[Nombre del permiso]';
    const description = document.getElementById('description').value || '[Descripción del permiso]';
    const moduleSelect = document.getElementById('module');
    const customModule = document.getElementById('custom-module').value;
    
    let module = 'Sin módulo';
    if (moduleSelect.value === 'other' && customModule.trim()) {
        module = customModule.trim();
    } else if (moduleSelect.value) {
        module = moduleSelect.options[moduleSelect.selectedIndex].text;
    }

    document.getElementById('preview-name').textContent = name;
    document.getElementById('preview-description').textContent = description;
    document.getElementById('preview-module').textContent = module;
}

function applyTemplate(type) {
    const template = templates[type];
    const moduleSelect = document.getElementById('module');
    const selectedModule = moduleSelect.value || 'resource';
    
    // Replace [module] placeholder with selected module or generic term
    const moduleName = selectedModule === 'other' ? 'resource' : selectedModule || 'resource';
    
    document.getElementById('name').value = template.name.replace('[module]', moduleName);
    document.getElementById('description').value = template.description.replace(/\[module\]/g, moduleName);
    
    // If no module selected, suggest one based on template
    if (!moduleSelect.value) {
        if (type === 'view' || type === 'create' || type === 'edit' || type === 'delete') {
            moduleSelect.value = '';
        }
    }

    // Update preview and validation
    updatePreview();
    formValidation.name = document.getElementById('name').value.length > 0;
    updateSubmitButton();
    
    // Update character counter
    const nameInput = document.getElementById('name');
    const nameCounter = document.getElementById('name-counter');
    nameCounter.textContent = `${nameInput.value.length}/255`;

    // Highlight the used template
    document.querySelectorAll('.template-btn').forEach(btn => {
        btn.classList.remove('border-blue-500', 'bg-blue-50');
    });
    event.target.closest('.template-btn').classList.add('border-blue-500', 'bg-blue-50');
}

function resetForm() {
    if (confirm('¿Estás seguro de que deseas limpiar todo el formulario? Se perderán todos los datos ingresados.')) {
        document.getElementById('permission-form').reset();
        document.getElementById('custom-module-input').classList.add('hidden');
        document.getElementById('name-counter').textContent = '0/255';
        
        // Reset validation
        formValidation.name = false;
        updateSubmitButton();
        updatePreview();
        
        // Clear any template highlighting
        document.querySelectorAll('.template-btn').forEach(btn => {
            btn.classList.remove('border-blue-500', 'bg-blue-50');
        });
    }
}

function saveDraft() {
    const formData = {
        name: document.getElementById('name').value,
        description: document.getElementById('description').value,
        module: document.getElementById('module').value,
        customModule: document.getElementById('custom-module').value,
        timestamp: new Date().toISOString()
    };
    
    localStorage.setItem('permission_draft', JSON.stringify(formData));
    
    // Show brief confirmation
    const button = event?.target;
    if (button) {
        const originalText = button.textContent;
        button.textContent = '✓ Guardado';
        button.classList.add('text-green-600');
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('text-green-600');
        }, 2000);
    }
}

function checkForDraft() {
    const draft = localStorage.getItem('permission_draft');
    if (draft) {
        const draftData = JSON.parse(draft);
        const draftDate = new Date(draftData.timestamp);
        
        document.getElementById('draft-status').classList.remove('hidden');
        document.getElementById('draft-info').textContent = 
            `Borrador guardado el ${draftDate.toLocaleDateString()} a las ${draftDate.toLocaleTimeString()}`;
    }
}

function loadDraft() {
    const draft = localStorage.getItem('permission_draft');
    if (draft) {
        const draftData = JSON.parse(draft);
        
        document.getElementById('name').value = draftData.name || '';
        document.getElementById('description').value = draftData.description || '';
        document.getElementById('module').value = draftData.module || '';
        
        if (draftData.module === 'other') {
            document.getElementById('custom-module-input').classList.remove('hidden');
            document.getElementById('custom-module').value = draftData.customModule || '';
        }
        
        // Update counters and validation
        const nameInput = document.getElementById('name');
        const nameCounter = document.getElementById('name-counter');
        nameCounter.textContent = `${nameInput.value.length}/255`;
        
        formValidation.name = nameInput.value.length > 0;
        updateSubmitButton();
        updatePreview();
        
        // Hide draft status
        document.getElementById('draft-status').classList.add('hidden');
    }
}

function clearDraft() {
    localStorage.removeItem('permission_draft');
    document.getElementById('draft-status').classList.add('hidden');
}
</script>
@endsection
