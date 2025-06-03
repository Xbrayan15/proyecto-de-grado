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
                        Editar Gateway de Pago
                    </h1>
                    <p class="text-gray-600 mt-2">Actualiza la configuración del gateway de pago</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('payment-gateways.show', $paymentGateway) }}" 
                       class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver Detalles
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
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Configuración del Gateway
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Actualiza la información y configuración del gateway de pago</p>
                    </div>

                    <form action="{{ route('payment-gateways.update', $paymentGateway) }}" method="POST" id="editForm" class="p-6">
                        @csrf
                        @method('PUT')

                        <!-- Current Gateway Info -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="provider-icon w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm bg-gradient-to-r from-blue-500 to-purple-600">
                                    {{ strtoupper(substr($paymentGateway->provider, 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ ucfirst($paymentGateway->provider) }}</h4>
                                    <p class="text-sm text-gray-600">
                                        Gateway {{ $paymentGateway->status === 'active' ? 'Activo' : 'Inactivo' }} • 
                                        Modo {{ $paymentGateway->sandbox_mode ? 'Sandbox' : 'Producción' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Provider Selection -->
                        <div class="mb-6">
                            <label for="provider" class="block text-sm font-medium text-gray-700 mb-2">
                                Proveedor <span class="text-red-500">*</span>
                            </label>
                            <select name="provider" id="provider" required 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar proveedor...</option>
                                <option value="stripe" {{ $paymentGateway->provider === 'stripe' ? 'selected' : '' }}>Stripe</option>
                                <option value="paypal" {{ $paymentGateway->provider === 'paypal' ? 'selected' : '' }}>PayPal</option>
                                <option value="mercadopago" {{ $paymentGateway->provider === 'mercadopago' ? 'selected' : '' }}>MercadoPago</option>
                                <option value="wompi" {{ $paymentGateway->provider === 'wompi' ? 'selected' : '' }}>Wompi</option>
                                <option value="epayco" {{ $paymentGateway->provider === 'epayco' ? 'selected' : '' }}>ePayco</option>
                                <option value="payu" {{ $paymentGateway->provider === 'payu' ? 'selected' : '' }}>PayU</option>
                                <option value="nequi" {{ $paymentGateway->provider === 'nequi' ? 'selected' : '' }}>Nequi</option>
                                <option value="bancolombia" {{ $paymentGateway->provider === 'bancolombia' ? 'selected' : '' }}>Bancolombia</option>
                            </select>
                        </div>

                        <!-- API Keys -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Public Key -->
                            <div>
                                <label for="public_key" class="block text-sm font-medium text-gray-700 mb-2">
                                    Clave Pública <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="public_key" id="public_key" required
                                           value="{{ old('public_key', $paymentGateway->public_key) }}"
                                           placeholder="pk_test_..."
                                           class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" onclick="toggleVisibility('public_key')" 
                                                class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Secret Key -->
                            <div>
                                <label for="secret_key" class="block text-sm font-medium text-gray-700 mb-2">
                                    Clave Secreta <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="secret_key" id="secret_key" required
                                           value="{{ old('secret_key', $paymentGateway->secret_key) }}"
                                           placeholder="sk_test_..."
                                           class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" onclick="toggleVisibility('secret_key')" 
                                                class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration Options -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Sandbox Mode -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Modo Sandbox</label>
                                <div class="flex items-center gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="sandbox_mode" value="1" 
                                               {{ $paymentGateway->sandbox_mode ? 'checked' : '' }}
                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">Sí (Pruebas)</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="sandbox_mode" value="0" 
                                               {{ !$paymentGateway->sandbox_mode ? 'checked' : '' }}
                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">No (Producción)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                <select name="status" id="status" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="active" {{ $paymentGateway->status === 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactive" {{ $paymentGateway->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Webhook Configuration -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Configuración de Webhooks
                            </label>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="mb-4">
                                    <label for="webhook_url" class="block text-sm font-medium text-gray-600 mb-2">URL del Webhook</label>
                                    <input type="text" id="webhook_url" name="webhook_config[url]"
                                           value="{{ old('webhook_config.url', $paymentGateway->webhook_config['url'] ?? '') }}"
                                           placeholder="https://tudominio.com/webhooks/payment-gateway"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Eventos</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @php
                                            $webhookEvents = $paymentGateway->webhook_config['events'] ?? [];
                                        @endphp
                                        <label class="flex items-center">
                                            <input type="checkbox" name="webhook_config[events][]" value="payment.completed"
                                                   {{ in_array('payment.completed', $webhookEvents) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-600">Pago Completado</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="webhook_config[events][]" value="payment.failed"
                                                   {{ in_array('payment.failed', $webhookEvents) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-600">Pago Fallido</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="webhook_config[events][]" value="refund.completed"
                                                   {{ in_array('refund.completed', $webhookEvents) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-600">Reembolso</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="webhook_config[events][]" value="subscription.updated"
                                                   {{ in_array('subscription.updated', $webhookEvents) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-600">Suscripción</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label for="webhook_secret" class="block text-sm font-medium text-gray-600 mb-2">Secreto del Webhook</label>
                                    <div class="relative">
                                        <input type="password" id="webhook_secret" name="webhook_config[secret]"
                                               value="{{ old('webhook_config.secret', $paymentGateway->webhook_config['secret'] ?? '') }}"
                                               placeholder="whsec_..."
                                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        <button type="button" onclick="toggleVisibility('webhook_secret')" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div class="flex items-center gap-3">
                                <button type="submit" 
                                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Actualizar Gateway
                                </button>
                                <button type="button" onclick="testConnection()" 
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Probar Conexión
                                </button>
                            </div>
                            <div class="text-xs text-gray-500">
                                <kbd class="px-2 py-1 bg-gray-100 rounded">Ctrl+S</kbd> para guardar • 
                                <kbd class="px-2 py-1 bg-gray-100 rounded">Esc</kbd> para cancelar
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Security Tips -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Consejos de Seguridad
                    </h3>
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span>Las claves se almacenan de forma segura</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span>Usa modo sandbox para pruebas</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span>Configura webhooks para eventos en tiempo real</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span>Monitorea las transacciones regularmente</span>
                        </div>
                    </div>
                </div>

                <!-- Provider Info -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6" id="providerInfo">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <a href="{{ route('payment-gateways.show', $paymentGateway) }}" 
                           class="w-full px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-colors duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Ver Detalles del Gateway
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
                    </div>
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
        description: 'Plataforma de pagos líder mundial',
        features: ['Pagos con tarjeta', 'Wallets digitales', 'Pagos recurrentes', 'Marketplace'],
        pricing: '2.9% + $0.30 por transacción',
        docs: 'https://stripe.com/docs'
    },
    paypal: {
        name: 'PayPal',
        description: 'Solución de pagos global reconocida',
        features: ['PayPal Checkout', 'Pagos con tarjeta', 'PayPal Credit', 'Venmo'],
        pricing: '2.9% + tarifa fija por transacción',
        docs: 'https://developer.paypal.com'
    },
    mercadopago: {
        name: 'MercadoPago',
        description: 'Líder en pagos en América Latina',
        features: ['Tarjetas', 'Efectivo', 'Transferencias', 'QR'],
        pricing: 'Desde 2.99% por transacción',
        docs: 'https://www.mercadopago.com.co/developers'
    },
    wompi: {
        name: 'Wompi',
        description: 'Gateway de pagos colombiano',
        features: ['PSE', 'Tarjetas', 'Nequi', 'Efecty'],
        pricing: 'Desde 2.95% por transacción',
        docs: 'https://docs.wompi.co'
    }
};

// Initialize form
document.addEventListener('DOMContentLoaded', function() {
    const provider = document.getElementById('provider').value;
    if (provider) {
        updateProviderInfo(provider);
        updatePlaceholders(provider);
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            document.getElementById('editForm').submit();
        }
        if (e.key === 'Escape') {
            window.location.href = '{{ route("payment-gateways.index") }}';
        }
    });
});

// Provider selection handler
document.getElementById('provider').addEventListener('change', function() {
    const provider = this.value;
    updateProviderInfo(provider);
    updatePlaceholders(provider);
});

function updateProviderInfo(provider) {
    const infoDiv = document.getElementById('providerDetails');
    const data = providerData[provider];
    
    if (data) {
        infoDiv.innerHTML = `
            <div class="space-y-3">
                <h4 class="font-semibold text-gray-900">${data.name}</h4>
                <p class="text-sm text-gray-600">${data.description}</p>
                
                <div>
                    <h5 class="text-sm font-medium text-gray-700 mb-2">Características:</h5>
                    <ul class="text-sm text-gray-600 space-y-1">
                        ${data.features.map(feature => `<li class="flex items-center gap-2">
                            <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            ${feature}
                        </li>`).join('')}
                    </ul>
                </div>
                
                <div>
                    <h5 class="text-sm font-medium text-gray-700">Precios:</h5>
                    <p class="text-sm text-gray-600">${data.pricing}</p>
                </div>
                
                <a href="${data.docs}" target="_blank" 
                   class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Documentación
                </a>
            </div>
        `;
    } else {
        infoDiv.innerHTML = '<p class="text-sm text-gray-500">Selecciona un proveedor para ver más información.</p>';
    }
}

function updatePlaceholders(provider) {
    const sandbox = document.querySelector('input[name="sandbox_mode"]:checked')?.value === '1';
    const publicKey = document.getElementById('public_key');
    const secretKey = document.getElementById('secret_key');
    
    const placeholders = {
        stripe: {
            public: sandbox ? 'pk_test_...' : 'pk_live_...',
            secret: sandbox ? 'sk_test_...' : 'sk_live_...'
        },
        paypal: {
            public: sandbox ? 'client_id_sandbox' : 'client_id_live',
            secret: sandbox ? 'client_secret_sandbox' : 'client_secret_live'
        },
        mercadopago: {
            public: sandbox ? 'TEST-...' : 'APP_USR-...',
            secret: sandbox ? 'TEST-...' : 'APP_USR-...'
        },
        wompi: {
            public: sandbox ? 'pub_test_...' : 'pub_prod_...',
            secret: sandbox ? 'prv_test_...' : 'prv_prod_...'
        }
    };
    
    if (placeholders[provider]) {
        publicKey.placeholder = placeholders[provider].public;
        secretKey.placeholder = placeholders[provider].secret;
    }
}

// Sandbox mode change handler
document.querySelectorAll('input[name="sandbox_mode"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const provider = document.getElementById('provider').value;
        if (provider) {
            updatePlaceholders(provider);
        }
    });
});

function toggleVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.type === 'password' ? 'text' : 'password';
    field.type = type;
}

function testConnection() {
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    
    button.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Probando...
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
        button.className = button.className.replace('bg-green-600 hover:bg-green-700', 'bg-green-500');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
            button.className = button.className.replace('bg-green-500', 'bg-green-600 hover:bg-green-700');
        }, 2000);
    }, 2000);
}
</script>
@endsection
