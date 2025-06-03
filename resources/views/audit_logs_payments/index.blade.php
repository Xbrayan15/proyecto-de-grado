@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Logs de Auditoría de Pagos</h1>
            <p class="text-gray-600 dark:text-gray-400">
                Monitorea todas las actividades y cambios en el sistema de pagos
            </p>
        </div>
        <div class="flex space-x-3 mt-4 sm:mt-0">
            <a href="{{ route('audit-logs-payments.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Log
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @php
            $totalLogs = $auditLogs->count();
            $todayLogs = $auditLogs->where('created_at', '>=', today())->count();
            $criticalActions = $auditLogs->whereIn('action', ['delete', 'update', 'disable'])->count();
            $uniqueUsers = $auditLogs->pluck('user_id')->unique()->count();
        @endphp

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de Logs</h2>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalLogs) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Hoy</h2>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($todayLogs) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Acciones Críticas</h2>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($criticalActions) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuarios Activos</h2>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($uniqueUsers) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="searchTerm" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <input type="text" id="searchTerm" name="searchTerm" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                              focus:outline-none focus:ring-blue-500 focus:border-blue-500 
                              dark:bg-gray-700 dark:text-white" 
                       placeholder="Buscar en logs...">
            </div>

            <!-- Action Filter -->
            <div>
                <label for="actionFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Acción</label>
                <select id="actionFilter" name="actionFilter" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 
                               dark:bg-gray-700 dark:text-white">
                    <option value="">Todas las acciones</option>
                    <option value="create">Crear</option>
                    <option value="update">Actualizar</option>
                    <option value="delete">Eliminar</option>
                    <option value="view">Ver</option>
                    <option value="login">Inicio de sesión</option>
                    <option value="logout">Cierre de sesión</option>
                </select>
            </div>

            <!-- Entity Type Filter -->
            <div>
                <label for="entityFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo de Entidad</label>
                <select id="entityFilter" name="entityFilter" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 
                               dark:bg-gray-700 dark:text-white">
                    <option value="">Todas las entidades</option>
                    <option value="transaction">Transacciones</option>
                    <option value="payment_gateway">Gateways de Pago</option>
                    <option value="refund">Reembolsos</option>
                    <option value="orders_payment">Órdenes de Pago</option>
                    <option value="user">Usuarios</option>
                </select>
            </div>

            <!-- Date Range -->
            <div>
                <label for="dateRange" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Período</label>
                <select id="dateRange" name="dateRange" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 
                               dark:bg-gray-700 dark:text-white">
                    <option value="">Todo el tiempo</option>
                    <option value="today">Hoy</option>
                    <option value="week">Esta semana</option>
                    <option value="month">Este mes</option>
                    <option value="quarter">Este trimestre</option>
                </select>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 flex flex-wrap gap-2">
            <button type="button" onclick="clearFilters()" 
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 
                           text-gray-700 dark:text-gray-300 rounded-lg transition duration-200">
                Limpiar Filtros
            </button>
            <button type="button" onclick="exportLogs()" 
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Exportar
            </button>
        </div>
    </div>

    <!-- Results Info -->
    <div class="flex justify-between items-center mb-4">
        <div class="text-sm text-gray-700 dark:text-gray-300">
            Mostrando <span id="resultsCount">{{ $auditLogs->count() }}</span> de {{ $auditLogs->count() }} logs
        </div>
        <div class="flex items-center space-x-2">
            <label for="pageSize" class="text-sm text-gray-700 dark:text-gray-300">Mostrar:</label>
            <select id="pageSize" class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded 
                                         dark:bg-gray-700 dark:text-white text-sm">
                <option value="10">10</option>
                <option value="25" selected>25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        @if($auditLogs->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" onclick="sortTable(0)">
                                <div class="flex items-center space-x-1">
                                    <span>ID</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Usuario
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Acción
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Entidad
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Dirección IP
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Fecha y Hora
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="logsTableBody">
                        @foreach($auditLogs as $log)
                            <tr class="log-row hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150" 
                                data-action="{{ strtolower($log->action) }}"
                                data-entity="{{ strtolower($log->entity_type) }}"
                                data-date="{{ $log->created_at->format('Y-m-d') }}"
                                data-search="{{ strtolower($log->action . ' ' . $log->entity_type . ' ' . ($log->user ? $log->user->name : 'Sistema')) }}">
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    #{{ $log->id }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->user)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                                    <span class="text-xs font-medium text-white">
                                                        {{ substr($log->user->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $log->user->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $log->user->email }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Sistema</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">Acción automática</div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $actionColors = [
                                            'create' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'update' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'delete' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                            'view' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
                                            'login' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            'logout' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        ];
                                        $colorClass = $actionColors[strtolower($log->action)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $log->entity_type)) }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $log->entity_id }}</div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $log->ip_address ?? 'N/A' }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div>{{ $log->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('audit-logs-payments.show', $log->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('audit-logs-payments.edit', $log->id) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" onclick="confirmDelete({{ $log->id }})" 
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
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
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay logs de auditoría</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando tu primer log de auditoría.</p>
                <div class="mt-6">
                    <a href="{{ route('audit-logs-payments.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nuevo Log
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Actions Links -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('transactions.index') }}" 
           class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition duration-200">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Transacciones</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Gestionar transacciones de pago</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        <a href="{{ route('payment-gateways.index') }}" 
           class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition duration-200">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Gateways de Pago</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Gestionar proveedores de pago</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        <a href="{{ route('refunds.index') }}" 
           class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition duration-200">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m5 14-3-3m3 3l-3-3"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Reembolsos</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Gestionar reembolsos</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-2">Eliminar Log de Auditoría</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    ¿Estás seguro de que quieres eliminar este log de auditoría? Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Eliminar
                    </button>
                </form>
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white text-base font-medium rounded-md w-24 hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchTerm');
    const actionFilter = document.getElementById('actionFilter');
    const entityFilter = document.getElementById('entityFilter');
    const dateRangeFilter = document.getElementById('dateRange');
    const pageSizeSelect = document.getElementById('pageSize');

    // Search and filter functionality
    function filterLogs() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedAction = actionFilter.value.toLowerCase();
        const selectedEntity = entityFilter.value.toLowerCase();
        const selectedDateRange = dateRangeFilter.value;
        const rows = document.querySelectorAll('.log-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search');
            const action = row.getAttribute('data-action');
            const entity = row.getAttribute('data-entity');
            const date = row.getAttribute('data-date');
            
            let isVisible = true;

            // Search filter
            if (searchTerm && !searchData.includes(searchTerm)) {
                isVisible = false;
            }

            // Action filter
            if (selectedAction && action !== selectedAction) {
                isVisible = false;
            }

            // Entity filter
            if (selectedEntity && entity !== selectedEntity) {
                isVisible = false;
            }

            // Date range filter
            if (selectedDateRange && !matchesDateRange(date, selectedDateRange)) {
                isVisible = false;
            }

            row.style.display = isVisible ? '' : 'none';
            if (isVisible) visibleCount++;
        });

        // Update results count
        document.getElementById('resultsCount').textContent = visibleCount;
    }

    function matchesDateRange(dateString, range) {
        const logDate = new Date(dateString);
        const today = new Date();
        
        switch(range) {
            case 'today':
                return logDate.toDateString() === today.toDateString();
            case 'week':
                const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                return logDate >= weekAgo;
            case 'month':
                const monthAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
                return logDate >= monthAgo;
            case 'quarter':
                const quarterAgo = new Date(today.getTime() - 90 * 24 * 60 * 60 * 1000);
                return logDate >= quarterAgo;
            default:
                return true;
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterLogs);
    actionFilter.addEventListener('change', filterLogs);
    entityFilter.addEventListener('change', filterLogs);
    dateRangeFilter.addEventListener('change', filterLogs);

    // Page size change
    pageSizeSelect.addEventListener('change', function() {
        // In a real implementation, this would trigger a page reload with new page size
        console.log('Page size changed to:', this.value);
    });
});

// Clear all filters
function clearFilters() {
    document.getElementById('searchTerm').value = '';
    document.getElementById('actionFilter').value = '';
    document.getElementById('entityFilter').value = '';
    document.getElementById('dateRange').value = '';
    
    // Show all rows
    document.querySelectorAll('.log-row').forEach(row => {
        row.style.display = '';
    });
    
    // Update results count
    const totalRows = document.querySelectorAll('.log-row').length;
    document.getElementById('resultsCount').textContent = totalRows;
}

// Export logs
function exportLogs() {
    // In a real implementation, this would trigger a download
    alert('Función de exportación disponible próximamente');
}

// Sort table
function sortTable(columnIndex) {
    const table = document.querySelector('table tbody');
    const rows = Array.from(table.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        if (columnIndex === 0) { // ID column - numeric sort
            return parseInt(aText.replace('#', '')) - parseInt(bText.replace('#', ''));
        }
        
        return aText.localeCompare(bText);
    });
    
    rows.forEach(row => table.appendChild(row));
}

// Delete confirmation
function confirmDelete(logId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = `/audit-logs-payments/${logId}`;
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Auto-refresh every 30 seconds
setInterval(function() {
    if (document.hidden) return; // Don't refresh if tab is not active
    
    // In a real implementation, this would fetch new data via AJAX
    console.log('Auto-refreshing audit logs...');
}, 30000);
</script>
@endpush
