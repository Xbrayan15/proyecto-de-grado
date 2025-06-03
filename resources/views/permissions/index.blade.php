@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Permisos</h1>
                    <p class="mt-2 text-gray-600">Administra los permisos del sistema y sus asignaciones</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <button onclick="exportData()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Exportar CSV
                    </button>
                    <a href="{{ route('permissions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nuevo Permiso
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Permisos</dt>
                                <dd class="text-lg font-medium text-gray-900" id="total-permissions">{{ $permissions->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Módulos Únicos</dt>
                                <dd class="text-lg font-medium text-gray-900" id="unique-modules">{{ $permissions->whereNotNull('module')->pluck('module')->unique()->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Asignados a Roles</dt>
                                <dd class="text-lg font-medium text-gray-900" id="assigned-permissions">{{ $permissions->filter(function($p) { return $p->roles->count() > 0; })->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Último Agregado</dt>
                                <dd class="text-lg font-medium text-gray-900" id="last-added">
                                    @if($permissions->count() > 0)
                                        {{ $permissions->sortByDesc('created_at')->first()->created_at->diffForHumans() }}
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Filtros y Búsqueda</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Buscar Permisos</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="search" placeholder="Buscar por nombre o descripción..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Module Filter -->
                    <div>
                        <label for="module-filter" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Módulo</label>
                        <select id="module-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los módulos</option>
                            @foreach($permissions->whereNotNull('module')->pluck('module')->unique()->sort() as $module)
                                <option value="{{ $module }}">{{ ucfirst($module) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Assignment Filter -->
                    <div>
                        <label for="assignment-filter" class="block text-sm font-medium text-gray-700 mb-2">Estado de Asignación</label>
                        <select id="assignment-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos</option>
                            <option value="assigned">Asignados a roles</option>
                            <option value="unassigned">Sin asignar</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <button onclick="clearFilters()" class="text-sm text-gray-500 hover:text-gray-700">
                        Limpiar filtros
                    </button>
                    <div class="text-sm text-gray-500">
                        Mostrando <span id="filtered-count">{{ $permissions->count() }}</span> de {{ $permissions->count() }} permisos
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Lista de Permisos</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Ordenar por:</span>
                    <select id="sort-field" class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="name">Nombre</option>
                        <option value="module">Módulo</option>
                        <option value="roles_count">Roles Asignados</option>
                        <option value="created_at">Fecha Creación</option>
                    </select>
                    <button onclick="toggleSortDirection()" id="sort-direction" class="p-1 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="permissions-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permiso</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Módulo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles Asignados</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Creación</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="permissions-tbody">
                        @foreach($permissions as $permission)
                        <tr class="hover:bg-gray-50 permission-row" 
                            data-name="{{ strtolower($permission->name) }}"
                            data-description="{{ strtolower($permission->description ?? '') }}"
                            data-module="{{ $permission->module ?? '' }}"
                            data-roles-count="{{ $permission->roles->count() }}"
                            data-created="{{ $permission->created_at->format('Y-m-d') }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('permissions.show', $permission) }}" class="hover:text-blue-600">
                                                {{ $permission->name }}
                                            </a>
                                        </div>
                                        @if($permission->description)
                                            <div class="text-sm text-gray-500 max-w-xs truncate">
                                                {{ $permission->description }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($permission->module)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        {{ ucfirst($permission->module) }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">Sin módulo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($permission->roles->count() > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            {{ $permission->roles->count() }} {{ $permission->roles->count() === 1 ? 'rol' : 'roles' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                            </svg>
                                            Sin asignar
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-col">
                                    <span>{{ $permission->created_at->format('d/m/Y') }}</span>
                                    <span class="text-xs text-gray-400">{{ $permission->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('permissions.show', $permission) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalle">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('permissions.edit', $permission) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button onclick="confirmDelete({{ $permission->id }}, '{{ $permission->name }}', {{ $permission->roles->count() }})" class="text-red-600 hover:text-red-900" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="hidden p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron permisos</h3>
                <p class="mt-1 text-sm text-gray-500">Intenta ajustar los filtros de búsqueda.</p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="mt-4 text-center">
                <h3 class="text-lg font-medium text-gray-900">Confirmar Eliminación</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        ¿Estás seguro de que deseas eliminar el permiso <strong id="permission-name-to-delete"></strong>?
                    </p>
                    <div id="delete-warning" class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-md hidden">
                        <div class="flex">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Advertencia</h3>
                                <p class="mt-1 text-sm text-yellow-700" id="delete-warning-text"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center space-x-3 px-4 py-3">
                    <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancelar
                    </button>
                    <form id="delete-form" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentSortField = 'name';
let currentSortDirection = 'asc';
let originalData = [];

document.addEventListener('DOMContentLoaded', function() {
    // Store original data for filtering
    const rows = document.querySelectorAll('.permission-row');
    rows.forEach(row => {
        originalData.push({
            element: row,
            name: row.dataset.name,
            description: row.dataset.description,
            module: row.dataset.module,
            rolesCount: parseInt(row.dataset.rolesCount),
            created: row.dataset.created
        });
    });

    // Set up event listeners
    document.getElementById('search').addEventListener('input', filterPermissions);
    document.getElementById('module-filter').addEventListener('change', filterPermissions);
    document.getElementById('assignment-filter').addEventListener('change', filterPermissions);
    document.getElementById('sort-field').addEventListener('change', function() {
        currentSortField = this.value;
        sortAndFilterPermissions();
    });
});

function filterPermissions() {
    const searchTerm = document.getElementById('search').value.toLowerCase();
    const moduleFilter = document.getElementById('module-filter').value;
    const assignmentFilter = document.getElementById('assignment-filter').value;

    let filteredData = originalData.filter(item => {
        // Search filter
        const matchesSearch = item.name.includes(searchTerm) || 
                            item.description.includes(searchTerm);

        // Module filter
        const matchesModule = !moduleFilter || item.module === moduleFilter;

        // Assignment filter
        let matchesAssignment = true;
        if (assignmentFilter === 'assigned') {
            matchesAssignment = item.rolesCount > 0;
        } else if (assignmentFilter === 'unassigned') {
            matchesAssignment = item.rolesCount === 0;
        }

        return matchesSearch && matchesModule && matchesAssignment;
    });

    // Update display
    displayFilteredResults(filteredData);
    updateStatistics(filteredData);
}

function sortAndFilterPermissions() {
    filterPermissions(); // This will handle both filtering and sorting
}

function displayFilteredResults(filteredData) {
    const tbody = document.getElementById('permissions-tbody');
    const emptyState = document.getElementById('empty-state');

    // Sort the filtered data
    filteredData.sort((a, b) => {
        let aValue, bValue;
        
        switch(currentSortField) {
            case 'name':
                aValue = a.name;
                bValue = b.name;
                break;
            case 'module':
                aValue = a.module || '';
                bValue = b.module || '';
                break;
            case 'roles_count':
                aValue = a.rolesCount;
                bValue = b.rolesCount;
                break;
            case 'created_at':
                aValue = a.created;
                bValue = b.created;
                break;
            default:
                aValue = a.name;
                bValue = b.name;
        }

        if (typeof aValue === 'string') {
            return currentSortDirection === 'asc' ? 
                aValue.localeCompare(bValue) : 
                bValue.localeCompare(aValue);
        } else {
            return currentSortDirection === 'asc' ? 
                aValue - bValue : 
                bValue - aValue;
        }
    });

    // Clear current rows
    tbody.innerHTML = '';

    if (filteredData.length === 0) {
        emptyState.classList.remove('hidden');
    } else {
        emptyState.classList.add('hidden');
        filteredData.forEach(item => {
            tbody.appendChild(item.element);
        });
    }

    // Update count
    document.getElementById('filtered-count').textContent = filteredData.length;
}

function updateStatistics(filteredData) {
    const totalPermissions = filteredData.length;
    const uniqueModules = new Set(filteredData.filter(item => item.module).map(item => item.module)).size;
    const assignedPermissions = filteredData.filter(item => item.rolesCount > 0).length;

    document.getElementById('total-permissions').textContent = totalPermissions;
    document.getElementById('unique-modules').textContent = uniqueModules;
    document.getElementById('assigned-permissions').textContent = assignedPermissions;
}

function toggleSortDirection() {
    currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
    
    const button = document.getElementById('sort-direction');
    const svg = button.querySelector('svg');
    
    if (currentSortDirection === 'desc') {
        svg.style.transform = 'rotate(180deg)';
    } else {
        svg.style.transform = 'rotate(0deg)';
    }
    
    sortAndFilterPermissions();
}

function clearFilters() {
    document.getElementById('search').value = '';
    document.getElementById('module-filter').value = '';
    document.getElementById('assignment-filter').value = '';
    
    // Reset to original data
    displayFilteredResults(originalData);
    updateStatistics(originalData);
}

function confirmDelete(permissionId, permissionName, rolesCount) {
    document.getElementById('permission-name-to-delete').textContent = permissionName;
    document.getElementById('delete-form').action = `/permissions/${permissionId}`;
    
    const warning = document.getElementById('delete-warning');
    const warningText = document.getElementById('delete-warning-text');
    
    if (rolesCount > 0) {
        warning.classList.remove('hidden');
        warningText.textContent = `Este permiso está asignado a ${rolesCount} ${rolesCount === 1 ? 'rol' : 'roles'}. Al eliminarlo, se removerá de todos los roles.`;
    } else {
        warning.classList.add('hidden');
    }
    
    document.getElementById('delete-modal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('delete-modal').classList.add('hidden');
}

function exportData() {
    const searchTerm = document.getElementById('search').value.toLowerCase();
    const moduleFilter = document.getElementById('module-filter').value;
    const assignmentFilter = document.getElementById('assignment-filter').value;

    let filteredData = originalData.filter(item => {
        const matchesSearch = item.name.includes(searchTerm) || 
                            item.description.includes(searchTerm);
        const matchesModule = !moduleFilter || item.module === moduleFilter;
        let matchesAssignment = true;
        if (assignmentFilter === 'assigned') {
            matchesAssignment = item.rolesCount > 0;
        } else if (assignmentFilter === 'unassigned') {
            matchesAssignment = item.rolesCount === 0;
        }
        return matchesSearch && matchesModule && matchesAssignment;
    });

    // Create CSV content
    let csvContent = "Nombre,Descripción,Módulo,Roles Asignados,Fecha Creación\n";
    
    filteredData.forEach(item => {
        const row = item.element;
        const name = row.querySelector('td:nth-child(1) .text-sm.font-medium').textContent.trim();
        const description = row.querySelector('td:nth-child(1) .text-gray-500') ? 
                          row.querySelector('td:nth-child(1) .text-gray-500').textContent.trim() : '';
        const module = item.module || 'Sin módulo';
        const rolesCount = item.rolesCount;
        const created = item.created;
        
        csvContent += `"${name}","${description}","${module}","${rolesCount}","${created}"\n`;
    });

    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    link.setAttribute("download", `permisos_${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Close modal when clicking outside
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection
