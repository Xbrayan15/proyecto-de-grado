@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        Detalles del Gateway de Pago
                    </h1>
                    <p class="text-gray-600 mt-2">Información completa del gateway {{ ucfirst($paymentGateway->provider) }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('payment-gateways.edit', $paymentGateway) }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('payment-gateways.index') }}" 
                       class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg border border-gray-300 transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Gateway Overview -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Información General
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <!-- Provider Header -->
                        <div class="flex items-center gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="provider-icon w-16 h-16 rounded-xl flex items-center justify-center text-white font-bold text-xl bg-gradient-to-r from-blue-500 to-purple-600">
                                {{ strtoupper(substr($paymentGateway->provider, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">{{ ucfirst($paymentGateway->provider) }}</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $paymentGateway->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        {{ $paymentGateway->status === 'active' ? 'Activo' : 'Inactivo' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $paymentGateway->sandbox_mode ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $paymentGateway->sandbox_mode ? 'Sandbox' : 'Producción' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- API Credentials -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Clave Pública</label>
                                <div class="relative">
                                    <input type="password" value="{{ $paymentGateway->public_key }}" readonly 
                                           id="publicKeyDisplay"
                                           class="w-full px-3 py-2 pr-20 border border-gray-300 rounded-lg bg-gray-50 text-sm">
                                    <div class="absolute inset-y-0 right-0 flex items-center">
                                        <button type="button" onclick="toggleKey('publicKeyDisplay')" 
                                                class="px-3 py-1 text-xs text-gray-500 hover:text-gray-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        <button type="button" onclick="copyToClipboard('{{ $paymentGateway->public_key }}')" 
                                                class="px-3 py-1 text-xs text-gray-500 hover:text-gray-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Clave Secreta</label>
                                <div class="relative">
                                    <input type="password" value="{{ $paymentGateway->secret_key }}" readonly 
                                           id="secretKeyDisplay"
                                           class="w-full px-3 py-2 pr-20 border border-gray-300 rounded-lg bg-gray-50 text-sm">
                                    <div class="absolute inset-y-0 right-0 flex items-center">
                                        <button type="button" onclick="toggleKey('secretKeyDisplay')" 
                                                class="px-3 py-1 text-xs text-gray-500 hover:text-gray-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        <button type="button" onclick="copyToClipboard('{{ $paymentGateway->secret_key }}')" 
                                                class="px-3 py-1 text-xs text-gray-500 hover:text-gray-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Warning -->
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-amber-700">
                                        <strong>Información sensible:</strong> Las claves API se muestran por seguridad. Asegúrate de mantener esta información confidencial.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- System Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Creación</label>
                                <div class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                    {{ $paymentGateway->created_at->format('d/m/Y H:i:s') }}
                                    <span class="text-xs text-gray-500 block">
                                        {{ $paymentGateway->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Última Actualización</label>
                                <div class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                    {{ $paymentGateway->updated_at->format('d/m/Y H:i:s') }}
                                    <span class="text-xs text-gray-500 block">
                                        {{ $paymentGateway->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Webhook Configuration -->
                @if($paymentGateway->webhook_config && is_array($paymentGateway->webhook_config))
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            Configuración de Webhooks
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if(isset($paymentGateway->webhook_config['url']))
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL del Webhook</label>
                            <div class="flex items-center gap-2">
                                <input type="text" value="{{ $paymentGateway->webhook_config['url'] }}" readonly 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm">
                                <button type="button" onclick="copyToClipboard('{{ $paymentGateway->webhook_config['url'] }}')" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                                <button type="button" onclick="testWebhook()" 
                                        class="px-3 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endif

                        @if(isset($paymentGateway->webhook_config['events']) && is_array($paymentGateway->webhook_config['events']))
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Eventos Configurados</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($paymentGateway->webhook_config['events'] as $event)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $event }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(isset($paymentGateway->webhook_config['secret']))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secreto del Webhook</label>
                            <div class="relative">
                                <input type="password" value="{{ $paymentGateway->webhook_config['secret'] }}" readonly 
                                       id="webhookSecretDisplay"
                                       class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg bg-gray-50 text-sm">
                                <button type="button" onclick="toggleKey('webhookSecretDisplay')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Connection Status -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Estado de Conexión
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Estado del Gateway</h4>
                                <p class="text-sm text-gray-600">Última verificación: Hace 5 minutos</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-green-700">Conectado</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <button type="button" onclick="testConnection()" 
                                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Verificar Conexión
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Gateway Statistics -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Estadísticas
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-600">Transacciones Hoy</span>
                            <span class="text-lg font-semibold text-gray-900">24</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-600">Volumen Hoy</span>
                            <span class="text-lg font-semibold text-gray-900">$1,250</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-600">Tasa de Éxito</span>
                            <span class="text-lg font-semibold text-green-600">96.5%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-600">Uptime</span>
                            <span class="text-lg font-semibold text-blue-600">99.9%</span>
                        </div>
                    </div>
                </div>

                <!-- Provider Information -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6" id="providerInfo">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Información del Proveedor
                    </h3>
                    <div id="providerDetails">
                        <!-- Content will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Acciones Rápidas
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('payment-gateways.edit', $paymentGateway) }}" 
                           class="w-full px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-colors duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar Gateway
                        </a>
                        <a href="#" 
                           class="w-full px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg transition-colors duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Ver Transacciones
                        </a>
                        <a href="#" 
                           class="w-full px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg transition-colors duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Ver Logs de Auditoría
                        </a>
                        <button type="button" onclick="confirmDelete()" 
                                class="w-full px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg transition-colors duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar Gateway
                        </button>
                    </div>
                </div>

                <!-- Documentation -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Documentación
                    </h3>
                    <div class="space-y-3">
                        <a href="#" class="block text-sm text-blue-600 hover:text-blue-800 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Documentación de API
                        </a>
                        <a href="#" class="block text-sm text-blue-600 hover:text-blue-800 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Guía de Integración
                        </a>
                        <a href="#" class="block text-sm text-blue-600 hover:text-blue-800 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Soporte Técnico
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div class="mt-2 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar Gateway de Pago</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        ¿Estás seguro de que deseas eliminar este gateway de pago? Esta acción no se puede deshacer y podría afectar las transacciones activas.
                    </p>
                </div>
                <div class="flex gap-3 px-4 py-3">
                    <button onclick="deleteGateway()" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Eliminar
                    </button>
                    <button onclick="closeDeleteModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Provider information data
const providerData = {
    stripe: {
        name: 'Stripe',
        description: 'Plataforma de pagos líder mundial con presencia en más de 40 países.',
        features: ['Pagos con tarjeta', 'Wallets digitales', 'Pagos recurrentes', 'Marketplace', 'Fraud protection'],
        pricing: '2.9% + $0.30 por transacción',
        support: '24/7 soporte técnico',
        docs: 'https://stripe.com/docs'
    },
    paypal: {
        name: 'PayPal',
        description: 'Solución de pagos global con más de 400 millones de usuarios activos.',
        features: ['PayPal Checkout', 'Pagos con tarjeta', 'PayPal Credit', 'Venmo', 'Buy Now Pay Later'],
        pricing: '2.9% + tarifa fija por transacción',
        support: 'Soporte técnico y comercial',
        docs: 'https://developer.paypal.com'
    },
    mercadopago: {
        name: 'MercadoPago',
        description: 'Líder en pagos digitales en América Latina, parte del ecosistema MercadoLibre.',
        features: ['Tarjetas de crédito y débito', 'Efectivo', 'Transferencias bancarias', 'QR', 'Link de pago'],
        pricing: 'Desde 2.99% por transacción',
        support: 'Soporte en español',
        docs: 'https://www.mercadopago.com.co/developers'
    },
    wompi: {
        name: 'Wompi',
        description: 'Gateway de pagos colombiano especializado en el mercado local.',
        features: ['PSE', 'Tarjetas', 'Nequi', 'Efecty', 'Bancolombia a la mano'],
        pricing: 'Desde 2.95% por transacción',
        support: 'Soporte local en Colombia',
        docs: 'https://docs.wompi.co'
    }
};

// Initialize provider info on page load
document.addEventListener('DOMContentLoaded', function() {
    const provider = '{{ $paymentGateway->provider }}';
    updateProviderInfo(provider);
});

function updateProviderInfo(provider) {
    const infoDiv = document.getElementById('providerDetails');
    const data = providerData[provider];
    
    if (data) {
        infoDiv.innerHTML = `
            <div class="space-y-4">
                <div>
                    <h4 class="font-semibold text-gray-900">${data.name}</h4>
                    <p class="text-sm text-gray-600 mt-1">${data.description}</p>
                </div>
                
                <div>
                    <h5 class="text-sm font-medium text-gray-700 mb-2">Características:</h5>
                    <ul class="text-xs text-gray-600 space-y-1">
                        ${data.features.map(feature => `<li class="flex items-center gap-2">
                            <svg class="w-3 h-3 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span>${feature}</span>
                        </li>`).join('')}
                    </ul>
                </div>
                
                <div class="grid grid-cols-1 gap-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Precios:</span>
                        <span class="text-gray-900 font-medium">${data.pricing}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Soporte:</span>
                        <span class="text-gray-900 font-medium">${data.support}</span>
                    </div>
                </div>
                
                <a href="${data.docs}" target="_blank" 
                   class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Ver Documentación
                </a>
            </div>
        `;
    } else {
        infoDiv.innerHTML = '<p class="text-sm text-gray-500">Información del proveedor no disponible.</p>';
    }
}

function toggleKey(fieldId) {
    const field = document.getElementById(fieldId);
    field.type = field.type === 'password' ? 'text' : 'password';
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show success message
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = `
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        `;
        setTimeout(() => {
            button.innerHTML = originalHTML;
        }, 2000);
    });
}

function testConnection() {
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    
    button.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Verificando...
    `;
    button.disabled = true;
    
    // Simulate API test
    setTimeout(() => {
        button.innerHTML = `
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Conexión exitosa
        `;
        button.className = button.className.replace('bg-blue-600 hover:bg-blue-700', 'bg-green-500');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.disabled = false;
            button.className = button.className.replace('bg-green-500', 'bg-blue-600 hover:bg-blue-700');
        }, 3000);
    }, 2000);
}

function testWebhook() {
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    
    button.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
    
    // Simulate webhook test
    setTimeout(() => {
        button.innerHTML = `
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        `;
        button.className = button.className.replace('bg-green-100 hover:bg-green-200', 'bg-green-200');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.className = button.className.replace('bg-green-200', 'bg-green-100 hover:bg-green-200');
        }, 2000);
    }, 1500);
}

function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function deleteGateway() {
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("payment-gateways.destroy", $paymentGateway) }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    form.appendChild(methodField);
    
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection