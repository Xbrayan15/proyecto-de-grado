@extends('layouts.app')

@section('title', 'Crear Gateway de Pago')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Crear Gateway de Pago</h1>
            <p class="text-gray-600 dark:text-gray-400">
                Configura un nuevo proveedor de pagos para la plataforma
            </p>
        </div>
        <div class="flex space-x-3 mt-4 sm:mt-0">
            <a href="{{ route('payment-gateways.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Listado
            </a>
        </div>
    </div>

    <!-- Security Notice -->
    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-amber-800 dark:text-amber-300">Información de Seguridad</h3>
                <p class="text-sm text-amber-700 dark:text-amber-400 mt-1">
                    Las credenciales del gateway se almacenan de forma segura. Asegúrate de usar las claves correctas para el entorno adecuado (Sandbox/Producción).
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form id="gatewayForm" method="POST" action="{{ route('payment-gateways.store') }}" class="space-y-6">
                @csrf

                <!-- Provider Configuration -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Configuración del Proveedor</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="provider" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Proveedor de Pagos *
                            </label>
                            <select id="provider" name="provider" required 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Seleccionar proveedor...</option>
                                <option value="stripe">Stripe</option>
                                <option value="paypal">PayPal</option>
                                <option value="mercadopago">MercadoPago</option>
                                <option value="wompi">Wompi</option>
                                <option value="payu">PayU</option>
                                <option value="nequi">Nequi</option>
                                <option value="daviplata">Daviplata</option>
                                <option value="otros">Otros</option>
                            </select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Selecciona el proveedor de pagos que deseas integrar
                            </p>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Estado *
                            </label>
                            <select id="status" name="status" required 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                            </select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Los gateways inactivos no procesarán pagos
                            </p>
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" id="sandbox_mode" name="sandbox_mode" value="1" checked 
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Modo Sandbox</span>
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Habilita el modo de pruebas para testing. Desactiva para producción.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- API Credentials -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Credenciales de API</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="public_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Clave Pública *
                            </label>
                            <input type="text" id="public_key" name="public_key" required 
                                   placeholder="pk_test_..."
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white font-mono">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Clave pública del proveedor (se puede exponer en el frontend)
                            </p>
                        </div>

                        <div>
                            <label for="secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Clave Secreta *
                            </label>
                            <div class="relative">
                                <input type="password" id="secret_key" name="secret_key" required 
                                       placeholder="sk_test_..."
                                       class="w-full px-3 py-2 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white font-mono">
                                <button type="button" onclick="togglePasswordVisibility('secret_key')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Clave secreta del proveedor (confidencial, no compartir)
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Webhook Configuration -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        Configuración de Webhooks
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="webhook_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                URL del Webhook
                            </label>
                            <input type="url" id="webhook_url" name="webhook_config[url]" 
                                   placeholder="https://tu-dominio.com/webhooks/payment-gateway"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                URL donde el proveedor enviará notificaciones de eventos
                            </p>
                        </div>

                        <div>
                            <label for="webhook_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Secreto del Webhook
                            </label>
                            <input type="password" id="webhook_secret" name="webhook_config[secret]" 
                                   placeholder="whsec_..."
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white font-mono">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Secreto para verificar la autenticidad de los webhooks
                            </p>
                        </div>

                        <div>
                            <label for="webhook_events" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Eventos a Escuchar
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="webhook_config[events][]" value="payment.succeeded" 
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pago Exitoso</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="webhook_config[events][]" value="payment.failed" 
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pago Fallido</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="webhook_config[events][]" value="refund.succeeded" 
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Reembolso Exitoso</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="webhook_config[events][]" value="dispute.created" 
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Disputa Creada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" id="submitBtn" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-300 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span id="submitText">Crear Gateway</span>
                    </button>
                    <button type="button" onclick="resetForm()" 
                            class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Limpiar Formulario
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">
            <!-- Provider Info -->
            <div id="providerInfo" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hidden">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información del Proveedor</h3>
                <div id="providerDetails" class="space-y-3"></div>
            </div>

            <!-- Security Tips -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Consejos de Seguridad</h3>
                
                <div class="space-y-3">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">Usa Modo Sandbox</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Prueba siempre en modo sandbox antes de activar producción</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">Protege las Claves</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Las claves secretas nunca deben compartirse públicamente</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">Configura Webhooks</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Los webhooks permiten recibir actualizaciones en tiempo real</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">Verifica Credenciales</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Asegúrate de que las credenciales sean válidas antes de guardar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Enlaces Útiles</h3>
                
                <div class="space-y-3">
                    <a href="https://stripe.com/docs/api" target="_blank" 
                       class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M10 6V5a2 2 0 012-2h2a2 2 0 012 2v1M10 6h4"></path>
                        </svg>
                        Documentación Stripe
                    </a>
                    <a href="https://developer.paypal.com/docs/api/" target="_blank" 
                       class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M10 6V5a2 2 0 012-2h2a2 2 0 012 2v1M10 6h4"></path>
                        </svg>
                        API PayPal
                    </a>
                    <a href="https://www.mercadopago.com.ar/developers" target="_blank" 
                       class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M10 6V5a2 2 0 012-2h2a2 2 0 012 2v1M10 6h4"></path>
                        </svg>
                        MercadoPago Developers
                    </a>
                    <a href="https://docs.wompi.co/" target="_blank" 
                       class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M10 6V5a2 2 0 012-2h2a2 2 0 012 2v1M10 6h4"></path>
                        </svg>
                        Documentación Wompi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Provider information data
const providerInfo = {
    stripe: {
        name: 'Stripe',
        description: 'Plataforma de pagos online líder mundial',
        features: ['Tarjetas de crédito/débito', 'Apple Pay', 'Google Pay', 'SEPA', 'Bancontact'],
        fees: 'A partir de 2.9% + $0.30 por transacción'
    },
    paypal: {
        name: 'PayPal',
        description: 'Sistema de pagos online más conocido',
        features: ['PayPal Balance', 'Tarjetas', 'Pagos en cuotas', 'PayPal Credit'],
        fees: 'A partir de 2.9% + tarifa fija'
    },
    mercadopago: {
        name: 'MercadoPago',
        description: 'Solución de pagos líder en Latinoamérica',
        features: ['Tarjetas', 'Transferencias', 'Pagos en efectivo', 'QR'],
        fees: 'Varía según país y método de pago'
    },
    wompi: {
        name: 'Wompi',
        description: 'Gateway de pagos colombiano',
        features: ['Tarjetas', 'PSE', 'Nequi', 'Bancolombia', 'Efecty'],
        fees: 'Tarifas competitivas para Colombia'
    }
};

// Form validation and interaction
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('gatewayForm');
    const providerSelect = document.getElementById('provider');
    const sandboxCheckbox = document.getElementById('sandbox_mode');
    const publicKeyInput = document.getElementById('public_key');
    const secretKeyInput = document.getElementById('secret_key');

    // Provider selection handler
    providerSelect.addEventListener('change', function() {
        const selectedProvider = this.value;
        updateProviderInfo(selectedProvider);
        updateKeyPlaceholders(selectedProvider);
    });

    // Sandbox mode toggle handler
    sandboxCheckbox.addEventListener('change', function() {
        const provider = providerSelect.value;
        updateKeyPlaceholders(provider);
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }

        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        
        submitBtn.disabled = true;
        submitText.textContent = 'Creando Gateway...';
        submitBtn.innerHTML = `
            <svg class="animate-spin w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>Creando Gateway...</span>
        `;

        // Submit form after short delay
        setTimeout(() => {
            form.submit();
        }, 1000);
    });

    // Real-time validation
    const requiredFields = [providerSelect, publicKeyInput, secretKeyInput];
    requiredFields.forEach(field => {
        field.addEventListener('input', validateForm);
        field.addEventListener('blur', validateForm);
    });
});

function updateProviderInfo(provider) {
    const providerInfoDiv = document.getElementById('providerInfo');
    const providerDetailsDiv = document.getElementById('providerDetails');

    if (provider && providerInfo[provider]) {
        const info = providerInfo[provider];
        providerDetailsDiv.innerHTML = `
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white">${info.name}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">${info.description}</p>
            </div>
            <div>
                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">Características:</h5>
                <ul class="text-xs text-gray-600 dark:text-gray-400 mt-1 space-y-1">
                    ${info.features.map(feature => `<li>• ${feature}</li>`).join('')}
                </ul>
            </div>
            <div>
                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">Tarifas:</h5>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">${info.fees}</p>
            </div>
        `;
        providerInfoDiv.classList.remove('hidden');
    } else {
        providerInfoDiv.classList.add('hidden');
    }
}

function updateKeyPlaceholders(provider) {
    const isSandbox = document.getElementById('sandbox_mode').checked;
    const publicKeyInput = document.getElementById('public_key');
    const secretKeyInput = document.getElementById('secret_key');

    const placeholders = {
        stripe: {
            sandbox: { public: 'pk_test_...', secret: 'sk_test_...' },
            production: { public: 'pk_live_...', secret: 'sk_live_...' }
        },
        paypal: {
            sandbox: { public: 'client_id_sandbox', secret: 'client_secret_sandbox' },
            production: { public: 'client_id_live', secret: 'client_secret_live' }
        },
        mercadopago: {
            sandbox: { public: 'TEST-...', secret: 'TEST-...' },
            production: { public: 'APP_USR-...', secret: 'APP_USR-...' }
        },
        wompi: {
            sandbox: { public: 'pub_test_...', secret: 'prv_test_...' },
            production: { public: 'pub_prod_...', secret: 'prv_prod_...' }
        }
    };

    if (provider && placeholders[provider]) {
        const mode = isSandbox ? 'sandbox' : 'production';
        publicKeyInput.placeholder = placeholders[provider][mode].public;
        secretKeyInput.placeholder = placeholders[provider][mode].secret;
    } else {
        publicKeyInput.placeholder = 'Clave pública del proveedor';
        secretKeyInput.placeholder = 'Clave secreta del proveedor';
    }
}

function validateForm() {
    const provider = document.getElementById('provider').value;
    const publicKey = document.getElementById('public_key').value.trim();
    const secretKey = document.getElementById('secret_key').value.trim();
    const submitBtn = document.getElementById('submitBtn');

    const isValid = provider && publicKey && secretKey;
    
    submitBtn.disabled = !isValid;
    submitBtn.classList.toggle('opacity-50', !isValid);

    return isValid;
}

function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);
}

function resetForm() {
    document.getElementById('gatewayForm').reset();
    document.getElementById('providerInfo').classList.add('hidden');
    validateForm();
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        if (!document.getElementById('submitBtn').disabled) {
            document.getElementById('gatewayForm').dispatchEvent(new Event('submit'));
        }
    }
    
    if (e.key === 'Escape') {
        window.location.href = "{{ route('payment-gateways.index') }}";
    }
});
</script>
@endsection
