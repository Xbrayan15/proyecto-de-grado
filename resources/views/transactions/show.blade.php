@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Transacción #{{ $transaction->id }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Detalles completos de la transacción</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('transactions.edit', $transaction) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Editar</span>
            </a>
            <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta transacción?')">
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
        @if($transaction->status === 'success')
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                        Transacción Exitosa
                    </h3>
                    <div class="mt-2 text-sm text-green-700 dark:text-green-300">
                        <p>Esta transacción fue procesada exitosamente el {{ $transaction->updated_at->format('d/m/Y à las H:i') }}.</p>
                    </div>
                </div>
            </div>
        </div>
        @elseif($transaction->status === 'pending')
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                        Transacción Pendiente
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                        <p>Esta transacción está pendiente de procesamiento desde el {{ $transaction->created_at->format('d/m/Y') }}.</p>
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
                        Transacción Fallida
                    </h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <p>Esta transacción falló durante el procesamiento el {{ $transaction->updated_at->format('d/m/Y à las H:i') }}.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Transaction Details -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Detalles de la Transacción</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID de Transacción</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $transaction->id }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                            <dd class="mt-1">
                                @if($transaction->status === 'success')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        ✅ Exitosa
                                    </span>
                                @elseif($transaction->status === 'pending')
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <span class="text-lg font-semibold">{{ $transaction->currency }} ${{ number_format($transaction->amount, 2) }}</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Referencia del Gateway</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $transaction->gateway_reference }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Creación</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última Actualización</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->updated_at->format('d/m/Y H:i:s') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Order Information -->
            @if($transaction->order)
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Información de la Orden</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID de Orden</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <a href="{{ route('orders-payments.show', $transaction->order) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-mono">
                                    #{{ $transaction->order->id }}
                                </a>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de la Orden</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($transaction->order->total, 2) }}</dd>
                        </div>

                        @if($transaction->order->user)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuario de la Orden</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->order->user->name }}</dd>
                        </div>
                        @endif

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de la Orden</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->order->created_at->format('d/m/Y H:i:s') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Information -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Gateway Information -->
            @if($transaction->gateway)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Gateway de Pago</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->gateway->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Proveedor</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->gateway->provider }}</dd>
                        </div>

                        @if($transaction->gateway->is_active)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        Activo
                                    </span>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
            @endif

            <!-- Payment Method Information -->
            @if($transaction->paymentMethod)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Método de Pago</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->paymentMethod->type }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Proveedor</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->paymentMethod->provider }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nickname</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->paymentMethod->nickname }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            @endif

            <!-- User Information -->
            @if($transaction->user)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Usuario</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->user->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->user->email }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registro</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->user->created_at->format('d/m/Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Acciones Rápidas</h3>
                <div class="space-y-3">
                    @if($transaction->status === 'pending')
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="w-full">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="success">
                        <input type="hidden" name="order_id" value="{{ $transaction->order_id }}">
                        <input type="hidden" name="gateway_id" value="{{ $transaction->gateway_id }}">
                        <input type="hidden" name="amount" value="{{ $transaction->amount }}">
                        <input type="hidden" name="currency" value="{{ $transaction->currency }}">
                        <input type="hidden" name="gateway_reference" value="{{ $transaction->gateway_reference }}">
                        <input type="hidden" name="user_id" value="{{ $transaction->user_id }}">
                        <input type="hidden" name="payment_method_id" value="{{ $transaction->payment_method_id }}">
                        <button type="submit" onclick="return confirm('¿Marcar esta transacción como exitosa?')" class="w-full text-center py-2 px-4 bg-green-600 hover:bg-green-700 text-white rounded-md transition duration-200 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Marcar como Exitosa</span>
                        </button>
                    </form>
                    @endif
                    
                    <a href="{{ route('refunds.create', ['transaction_id' => $transaction->id]) }}" class="w-full text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        <span>Crear Reembolso</span>
                    </a>
                    
                    <a href="{{ route('transactions.create') }}" class="w-full text-center py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Nueva Transacción</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Refunds -->
    @if($transaction->refunds && $transaction->refunds->count() > 0)
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Reembolsos Relacionados</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($transaction->refunds as $refund)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            #{{ $refund->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $refund->currency }} ${{ number_format($refund->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $refund->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 
                                   ($refund->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : 
                                    'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100') }}">
                                {{ ucfirst($refund->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $refund->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('refunds.show', $refund) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy transaction ID to clipboard
    const transactionId = document.querySelector('[data-transaction-id]');
    if (transactionId) {
        transactionId.addEventListener('click', function() {
            navigator.clipboard.writeText(this.textContent);
            
            // Show temporary feedback
            const originalText = this.textContent;
            this.textContent = 'Copiado!';
            setTimeout(() => {
                this.textContent = originalText;
            }, 1000);
        });
    }

    // Auto-refresh status for pending transactions
    @if($transaction->status === 'pending')
    setInterval(() => {
        fetch(`{{ route('transactions.show', $transaction) }}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== '{{ $transaction->status }}') {
                location.reload();
            }
        })
        .catch(() => {
            // Silently handle errors
        });
    }, 30000); // Check every 30 seconds
    @endif
});
</script>
@endpush
