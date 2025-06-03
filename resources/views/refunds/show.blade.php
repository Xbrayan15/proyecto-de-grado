@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('refunds.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reembolso #{{ $refund->id }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Detalles completos del reembolso</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('refunds.edit', $refund) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Editar</span>
            </a>
            <form method="POST" action="{{ route('refunds.destroy', $refund) }}" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este reembolso?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-medium transition duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Eliminar</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Status Alert -->
    <div class="mb-6">
        @if($refund->status === 'completed')
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                        Reembolso Completado
                    </h3>
                    <div class="mt-2 text-sm text-green-700 dark:text-green-300">
                        <p>Este reembolso fue procesado exitosamente{{ $refund->completed_at ? ' el ' . $refund->completed_at->format('d/m/Y à las H:i') : '' }}.</p>
                    </div>
                </div>
            </div>
        </div>
        @elseif($refund->status === 'pending')
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                        Reembolso Pendiente
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                        <p>Este reembolso está pendiente de procesamiento desde el {{ $refund->created_at->format('d/m/Y') }}.</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                        Reembolso Fallido
                    </h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <p>Este reembolso falló durante el procesamiento el {{ $refund->updated_at->format('d/m/Y à las H:i') }}.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Refund Details -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Detalles del Reembolso</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID de Reembolso</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $refund->id }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                            <dd class="mt-1">
                                @if($refund->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        ✅ Completado
                                    </span>
                                @elseif($refund->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                        🕐 Pendiente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                        ❌ Fallido
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto del Reembolso</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <span class="text-lg font-semibold">{{ $refund->currency }} ${{ number_format($refund->amount, 2) }}</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Razón</dt>
                            <dd class="mt-1">
                                @switch($refund->reason)
                                    @case('customer_request')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                            👤 Solicitud del cliente
                                        </span>
                                        @break
                                    @case('duplicate')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">
                                            🔄 Transacción duplicada
                                        </span>
                                        @break
                                    @case('fraudulent')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                            ⚠️ Actividad fraudulenta
                                        </span>
                                        @break
                                    @case('product_issue')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100">
                                            📦 Problema con el producto
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">
                                            {{ $refund->reason }}
                                        </span>
                                @endswitch
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Referencia del Gateway</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $refund->gateway_reference ?? 'No asignada' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Procesado por</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                @if($refund->processedBy)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ substr($refund->processedBy->name, 0, 1) }}</span>
                                        </div>
                                        <span>{{ $refund->processedBy->name }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500">Sin asignar</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Creación</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $refund->created_at->format('d/m/Y H:i:s') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última Actualización</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $refund->updated_at->format('d/m/Y H:i:s') }}</dd>
                        </div>

                        @if($refund->completed_at)
                        <div class="col-span-1 sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Completado</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $refund->completed_at->format('d/m/Y H:i:s') }}</dd>
                        </div>
                        @endif

                        @if($refund->notes)
                        <div class="col-span-1 sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notas</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $refund->notes }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Transaction Details Card -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transacción Original</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID de Transacción</dt>
                            <dd class="mt-1">
                                <a href="{{ route('transactions.show', $refund->transaction) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-mono text-sm">
                                    #{{ $refund->transaction->id }}
                                </a>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado de Transacción</dt>
                            <dd class="mt-1">
                                @if($refund->transaction->status === 'success')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        ✅ Exitosa
                                    </span>
                                @elseif($refund->transaction->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                        🕐 Pendiente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                        ❌ Fallida
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Original</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <span class="text-lg font-semibold">{{ $refund->transaction->currency }} ${{ number_format($refund->transaction->amount, 2) }}</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Reembolsado</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <span class="text-lg font-semibold text-red-600 dark:text-red-400">-{{ $refund->currency }} ${{ number_format($refund->amount, 2) }}</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuario</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                @if($refund->transaction->user)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ substr($refund->transaction->user->name, 0, 1) }}</span>
                                        </div>
                                        <span>{{ $refund->transaction->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500">Sin usuario</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gateway Reference</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $refund->transaction->gateway_reference }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Acciones Rápidas</h3>
                </div>
                <div class="p-4 space-y-3">
                    @if($refund->status === 'pending')
                    <form method="POST" action="{{ route('refunds.update', $refund) }}" class="space-y-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed">
                        <input type="hidden" name="completed_at" value="{{ now() }}">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium transition duration-200 flex items-center justify-center space-x-2" onclick="return confirm('¿Marcar este reembolso como completado?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Marcar Completado</span>
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('refunds.update', $refund) }}" class="space-y-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="failed">
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-medium transition duration-200 flex items-center justify-center space-x-2" onclick="return confirm('¿Marcar este reembolso como fallido?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Marcar Fallido</span>
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('transactions.show', $refund->transaction) }}" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Ver Transacción</span>
                    </a>

                    <a href="{{ route('refunds.create', ['transaction_id' => $refund->transaction_id]) }}" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md font-medium transition duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Nuevo Reembolso</span>
                    </a>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Resumen</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto original:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ $refund->transaction->currency }} ${{ number_format($refund->transaction->amount, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto reembolsado:</dt>
                            <dd class="text-sm text-red-600 dark:text-red-400 font-medium">-{{ $refund->currency }} ${{ number_format($refund->amount, 2) }}</dd>
                        </div>
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto restante:</dt>
                                <dd class="text-sm text-gray-900 dark:text-white font-bold">{{ $refund->transaction->currency }} ${{ number_format($refund->transaction->amount - $refund->amount, 2) }}</dd>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Porcentaje reembolsado:</dt>
                                <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ number_format(($refund->amount / $refund->transaction->amount) * 100, 1) }}%</dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Timeline -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Cronología</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-900 dark:text-white font-medium">Reembolso creado</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $refund->created_at->format('d/m/Y H:i:s') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            @if($refund->updated_at != $refund->created_at)
                            <li>
                                <div class="relative pb-8">
                                    @if($refund->completed_at)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-900 dark:text-white font-medium">Reembolso actualizado</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $refund->updated_at->format('d/m/Y H:i:s') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif

                            @if($refund->completed_at)
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-900 dark:text-white font-medium">Reembolso completado</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $refund->completed_at->format('d/m/Y H:i:s') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Information -->
    <div class="mt-6 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Información Relacionada</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <a href="{{ route('transactions.index') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span>Ver Transacciones</span>
            </a>
            <a href="{{ route('refunds.index') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Ver Reembolsos</span>
            </a>
            <a href="{{ route('refunds.create') }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Nuevo Reembolso</span>
            </a>
            <a href="{{ route('refunds.edit', $refund) }}" class="text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Editar Reembolso</span>
            </a>
        </div>
    </div>
</div>

@if($refund->status === 'pending')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh for pending refunds
    const refreshInterval = 30000; // 30 seconds
    
    function refreshPage() {
        if (document.visibilityState === 'visible') {
            location.reload();
        }
    }
    
    // Only auto-refresh if the page is visible
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            setTimeout(refreshPage, 1000); // Small delay when page becomes visible
        }
    });
    
    // Set up interval for auto-refresh
    setInterval(refreshPage, refreshInterval);
});
</script>
@endif
@endsection
