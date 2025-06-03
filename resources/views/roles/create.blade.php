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
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Nuevo Rol</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Crear Nuevo Rol</h1>
        <p class="text-gray-600">Define un nuevo rol con sus permisos y configuraciones correspondientes</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('roles.store') }}" id="role-form" class="space-y-8">
                @csrf
                
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
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full px-3 py-2 pr-20 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                    placeholder="Ej: Administrador, Editor, Usuario"
                                    maxlength="255"
                                    oninput="updatePreview(); updateCharCount(this, 'name-count'); validateForm()">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span id="name-count" class="text-xs text-gray-500">0/255</span>
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
                                oninput="updatePreview(); validateForm()">{{ old('description') }}</textarea>
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
                                    <input type="radio" name="is_system" value="0" class="sr-only" {{ old('is_system', '0') == '0' ? 'checked' : '' }} onchange="updatePreview(); validateForm()">
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
                                    <input type="radio" name="is_system" value="1" class="sr-only" {{ old('is_system') == '1' ? 'checked' : '' }} onchange="updatePreview(); validateForm()">
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
                                onchange="updatePreview(); validateForm()">
                                <option value="">Sin rol padre</option>
                                @foreach($parentRoles as $parentRole)
                                    <option value="{{ $parentRole->id }}" {{ old('parent_role_id') == $parentRole->id ? 'selected' : '' }}>
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
                                            {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                            data-module="{{ $module }}"
                                            onchange="updatePreview(); validateForm()">
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

                <!-- Additional Options -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Opciones Adicionales</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" id="save-draft" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Guardar como borrador automáticamente</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" id="redirect-to-show" name="redirect_to_show" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Ir a la página de detalle después de crear</span>
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" id="submit-btn" disabled
                        class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gray-400 cursor-not-allowed transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Crear Rol
                    </button>
                    <button type="button" onclick="resetForm()" 
                        class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reiniciar
                    </button>
                    <a href="{{ route('roles.index') }}" 
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
            <!-- Live Preview -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Vista Previa</h3>
                </div>
                <div class="p-6" id="live-preview">
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3" id="preview-icon">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900" id="preview-name">Nombre del rol</h4>
                            <p class="text-sm text-gray-500" id="preview-type">Tipo de rol</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Descripción:</p>
                            <p class="text-sm text-gray-600" id="preview-description">Sin descripción</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Rol padre:</p>
                            <p class="text-sm text-gray-600" id="preview-parent">Sin rol padre</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Permisos seleccionados:</p>
                            <p class="text-sm text-gray-600" id="preview-permissions">0 permisos</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Templates -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Plantillas Rápidas</h3>
                </div>
                <div class="p-6 space-y-3">
                    <button type="button" onclick="loadTemplate('admin')" class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="font-medium text-gray-900">Administrador</div>
                        <div class="text-sm text-gray-500">Acceso completo al sistema</div>
                    </button>
                    <button type="button" onclick="loadTemplate('editor')" class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="font-medium text-gray-900">Editor</div>
                        <div class="text-sm text-gray-500">Gestión de contenido</div>
                    </button>
                    <button type="button" onclick="loadTemplate('viewer')" class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="font-medium text-gray-900">Visualizador</div>
                        <div class="text-sm text-gray-500">Solo lectura</div>
                    </button>
                    <button type="button" onclick="loadTemplate('moderator')" class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="font-medium text-gray-900">Moderador</div>
                        <div class="text-sm text-gray-500">Moderación de usuarios</div>
                    </button>
                </div>
            </div>

            <!-- Help & Tips -->
            <div class="bg-blue-50 rounded-lg border border-blue-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-blue-200">
                    <h3 class="text-lg font-medium text-blue-900">Ayuda y Consejos</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Nombres descriptivos</p>
                            <p class="text-sm text-blue-700">Usa nombres claros como "Administrador de Inventario" en lugar de "Admin_Inv"</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Roles del sistema</p>
                            <p class="text-sm text-blue-700">Marca como "Rol del Sistema" solo aquellos críticos para el funcionamiento</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2m-2-2a2 2 0 00-2 2m0 0a2 2 0 01-2 2m2-2a2 2 0 002 2M9 5a2 2 0 012 2v0a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h2z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Principio de menor privilegio</p>
                            <p class="text-sm text-blue-700">Asigna solo los permisos mínimos necesarios para cada rol</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation and interaction
document.addEventListener('DOMContentLoaded', function() {
    // Initialize form
    updatePreview();
    validateForm();
    loadDraft();
    
    // Auto-save draft functionality
    const saveAsDraft = document.getElementById('save-draft');
    if (saveAsDraft.checked) {
        setInterval(saveDraft, 30000); // Save every 30 seconds
    }
    
    saveAsDraft.addEventListener('change', function() {
        if (this.checked) {
            setInterval(saveDraft, 30000);
        }
    });
    
    // Update role type visual selection
    updateRoleTypeSelection();
});

function updateCharCount(input, countId) {
    const count = input.value.length;
    const max = input.getAttribute('maxlength');
    document.getElementById(countId).textContent = `${count}/${max}`;
}

function updatePreview() {
    const name = document.getElementById('name').value || 'Nombre del rol';
    const description = document.getElementById('description').value || 'Sin descripción';
    const isSystem = document.querySelector('input[name="is_system"]:checked')?.value;
    const parentSelect = document.getElementById('parent_role_id');
    const parent = parentSelect ? (parentSelect.options[parentSelect.selectedIndex]?.text || 'Sin rol padre') : 'Sin rol padre';
    const permissionsCount = document.querySelectorAll('input[name="permissions[]"]:checked').length;
    
    // Update preview content
    document.getElementById('preview-name').textContent = name;
    document.getElementById('preview-description').textContent = description;
    document.getElementById('preview-parent').textContent = parent;
    document.getElementById('preview-permissions').textContent = `${permissionsCount} permisos`;
    
    // Update type and icon
    const typeElement = document.getElementById('preview-type');
    const iconElement = document.getElementById('preview-icon');
    
    if (isSystem === '1') {
        typeElement.textContent = 'Rol del Sistema';
        iconElement.className = 'h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center mr-3';
        iconElement.innerHTML = `
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        `;
    } else {
        typeElement.textContent = 'Rol Personalizado';
        iconElement.className = 'h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3';
        iconElement.innerHTML = `
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
        `;
    }
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

function validateForm() {
    const name = document.getElementById('name').value.trim();
    const submitBtn = document.getElementById('submit-btn');
    
    if (name.length > 0) {
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
    updatePreview();
}

function clearAllPermissions() {
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    updatePreview();
}

function toggleModulePermissions(module) {
    const checkboxes = document.querySelectorAll(`input[data-module="${module}"]`);
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });
    updatePreview();
}

// Template loading
function loadTemplate(templateType) {
    const templates = {
        admin: {
            name: 'Administrador',
            description: 'Acceso completo al sistema con todos los permisos administrativos',
            is_system: '1',
            permissions: 'all'
        },
        editor: {
            name: 'Editor',
            description: 'Gestión de contenido y recursos del sistema',
            is_system: '0',
            permissions: ['create', 'read', 'update']
        },
        viewer: {
            name: 'Visualizador',
            description: 'Acceso de solo lectura a los recursos del sistema',
            is_system: '0',
            permissions: ['read']
        },
        moderator: {
            name: 'Moderador',
            description: 'Moderación de usuarios y contenido',
            is_system: '0',
            permissions: ['read', 'update', 'moderate']
        }
    };
    
    const template = templates[templateType];
    if (!template) return;
    
    // Fill form fields
    document.getElementById('name').value = template.name;
    document.getElementById('description').value = template.description;
    
    // Set role type
    const systemRadio = document.querySelector(`input[name="is_system"][value="${template.is_system}"]`);
    if (systemRadio) {
        systemRadio.checked = true;
        updateRoleTypeSelection();
    }
    
    // Set permissions
    if (template.permissions === 'all') {
        selectAllPermissions();
    } else {
        clearAllPermissions();
        // This would require mapping permission names to actual permission IDs
        // For now, we'll just select all for simplicity
        if (templateType === 'admin') {
            selectAllPermissions();
        }
    }
    
    updatePreview();
    validateForm();
}

// Draft functionality
function saveDraft() {
    const formData = new FormData(document.getElementById('role-form'));
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
    
    localStorage.setItem('role_draft', JSON.stringify(draft));
    
    // Show temporary feedback
    const originalText = 'Guardar como borrador automáticamente';
    const draftLabel = document.querySelector('label[for="save-draft"] span');
    draftLabel.textContent = 'Borrador guardado ✓';
    setTimeout(() => {
        draftLabel.textContent = originalText;
    }, 2000);
}

function loadDraft() {
    const draft = localStorage.getItem('role_draft');
    if (!draft) return;
    
    try {
        const draftData = JSON.parse(draft);
        
        // Ask user if they want to restore the draft
        if (confirm('Se encontró un borrador guardado. ¿Deseas restaurarlo?')) {
            // Fill form with draft data
            Object.entries(draftData).forEach(([key, value]) => {
                const field = document.querySelector(`[name="${key}"]`);
                if (field) {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        if (Array.isArray(value)) {
                            value.forEach(v => {
                                const specificField = document.querySelector(`[name="${key}"][value="${v}"]`);
                                if (specificField) specificField.checked = true;
                            });
                        } else {
                            const specificField = document.querySelector(`[name="${key}"][value="${value}"]`);
                            if (specificField) specificField.checked = true;
                        }
                    } else {
                        field.value = Array.isArray(value) ? value[0] : value;
                    }
                }
            });
            
            updateRoleTypeSelection();
            updatePreview();
            validateForm();
        }
    } catch (e) {
        console.error('Error loading draft:', e);
    }
}

function resetForm() {
    if (confirm('¿Estás seguro de que deseas reiniciar el formulario? Se perderán todos los datos ingresados.')) {
        document.getElementById('role-form').reset();
        localStorage.removeItem('role_draft');
        updateRoleTypeSelection();
        updatePreview();
        validateForm();
    }
}

// Handle radio button changes
document.addEventListener('change', function(e) {
    if (e.target.name === 'is_system') {
        updateRoleTypeSelection();
    }
});

// Auto-save on form changes
document.getElementById('role-form').addEventListener('input', function() {
    if (document.getElementById('save-draft').checked) {
        clearTimeout(window.draftTimeout);
        window.draftTimeout = setTimeout(saveDraft, 2000);
    }
});
</script>
@endsection
