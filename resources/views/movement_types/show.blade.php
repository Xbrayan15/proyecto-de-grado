@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <nav class="flex mb-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('movement-types.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-list mr-2"></i>Tipos de Movimiento
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500">{{ $movementType->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Detalles del Tipo de Movimiento</h1>
            <p class="text-gray-600">Información completa del tipo de movimiento de inventario</p>
        </div>
        <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
            <button onclick="printDetails()" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-print mr-2"></i>Imprimir
            </button>
            <button onclick="exportDetails()" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-download mr-2"></i>Exportar
            </button>
            <a href="{{ route('movement-types.edit', $movementType->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-edit mr-2"></i>Editar
            </a>
            <a href="{{ route('movement-types.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r {{ $movementType->effect === 'in' ? 'from-green-500 to-green-600' : 'from-red-500 to-red-600' }} text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                                <i class="fas {{ $movementType->effect === 'in' ? 'fa-arrow-up' : 'fa-arrow-down' }} text-2xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">{{ $movementType->name }}</h2>
                            <p class="opacity-90">Tipo de movimiento #{{ $movementType->id }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">ID del Tipo</label>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-lg font-mono text-gray-900">#{{ $movementType->id }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Tipo</label>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-lg text-gray-900">{{ $movementType->name }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Efecto en Inventario</label>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $movementType->effect === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas {{ $movementType->effect === 'in' ? 'fa-plus' : 'fa-minus' }} mr-2"></i>
                                    {{ $movementType->effect === 'in' ? 'Entrada (+)' : 'Salida (-)' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción del Efecto</label>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-sm text-gray-900">
                                    @if($movementType->effect === 'in')
                                        Este tipo incrementa la cantidad de productos en inventario
                                    @else
                                        Este tipo reduce la cantidad de productos en inventario
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Statistics Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                        Estadísticas de Uso
                    </h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="bg-blue-100 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-exchange-alt text-blue-600 text-xl"></i>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $movementType->inventoryMovements->count() }}</div>
                            <div class="text-sm text-gray-600">Movimientos Totales</div>
                        </div>

                        <div class="text-center">
                            <div class="bg-green-100 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-calendar-month text-green-600 text-xl"></i>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $movementType->inventoryMovements->where('created_at', '>=', now()->startOfMonth())->count() }}
                            </div>
                            <div class="text-sm text-gray-600">Este Mes</div>
                        </div>

                        <div class="text-center">
                            <div class="bg-purple-100 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-clock text-purple-600 text-xl"></i>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">
                                @if($movementType->inventoryMovements->count() > 0)
                                    {{ $movementType->inventoryMovements->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
                                @else
                                    N/A
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">Último Uso</div>
                        </div>
                    </div>

                    @if($movementType->inventoryMovements->count() === 0)
                        <div class="mt-6 text-center py-8 bg-gray-50 rounded-lg">
                            <i class="fas fa-info-circle text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-600">Este tipo de movimiento aún no ha sido utilizado</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Movements -->
            @if($movementType->inventoryMovements->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-history mr-2 text-green-500"></i>
                                Movimientos Recientes
                            </h3>
                            <a href="{{ route('inventory-movements.index') }}?movement_type={{ $movementType->id }}" 
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Ver todos →
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($movementType->inventoryMovements->sortByDesc('created_at')->take(5) as $movement)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $movement->movement_date->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $movement->product->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="font-medium {{ $movementType->effect === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $movementType->effect === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $movement->user->name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Timestamp Information -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-clock mr-2 text-gray-500"></i>
                        Información Temporal
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Creación</label>
                        <div class="text-sm text-gray-900">{{ $movementType->created_at->format('d/m/Y H:i:s') }}</div>
                        <div class="text-xs text-gray-500">{{ $movementType->created_at->diffForHumans() }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Última Modificación</label>
                        <div class="text-sm text-gray-900">{{ $movementType->updated_at->format('d/m/Y H:i:s') }}</div>
                        <div class="text-xs text-gray-500">{{ $movementType->updated_at->diffForHumans() }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Días desde Creación</label>
                        <div class="text-sm text-gray-900">{{ $movementType->created_at->diffInDays(now()) }} días</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('movement-types.edit', $movementType->id) }}" 
                        class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                        <i class="fas fa-edit mr-2"></i>Editar Tipo
                    </a>

                    <a href="{{ route('inventory-movements.create') }}?movement_type={{ $movementType->id }}" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                        <i class="fas fa-plus mr-2"></i>Nuevo Movimiento
                    </a>

                    <a href="{{ route('inventory-movements.index') }}?movement_type={{ $movementType->id }}" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                        <i class="fas fa-list mr-2"></i>Ver Movimientos
                    </a>

                    <button onclick="duplicateType()" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                        <i class="fas fa-copy mr-2"></i>Duplicar Tipo
                    </button>

                    <button onclick="confirmDelete()" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                        <i class="fas fa-trash mr-2"></i>Eliminar Tipo
                    </button>
                </div>
            </div>

            <!-- System Information -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        Información del Sistema
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Estado:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="mr-1">●</span> Activo
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Tipo de Modelo:</span>
                        <span class="text-sm text-gray-900">MovementType</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">ID de Base de Datos:</span>
                        <span class="text-sm font-mono text-gray-900">{{ $movementType->id }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Relaciones:</span>
                        <span class="text-sm text-gray-900">{{ $movementType->inventoryMovements->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Confirmar Eliminación</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    ¿Estás seguro de que deseas eliminar el tipo de movimiento 
                    <span class="font-medium text-gray-900">{{ $movementType->name }}</span>?
                </p>
                @if($movementType->inventoryMovements->count() > 0)
                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-xs text-yellow-700">
                            <i class="fas fa-warning mr-1"></i>
                            Este tipo tiene {{ $movementType->inventoryMovements->count() }} movimientos asociados.
                        </p>
                    </div>
                @endif
                <p class="text-xs text-red-600 mt-2">Esta acción no se puede deshacer.</p>
            </div>
            <div class="flex gap-4 px-7 py-3">
                <button onclick="closeDeleteModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-300">
                    Cancelar
                </button>
                <form action="{{ route('movement-types.destroy', $movementType->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Duplicate Type Modal -->
<div id="duplicateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 mb-4">
                <i class="fas fa-copy text-purple-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mb-4">Duplicar Tipo de Movimiento</h3>
            <form action="{{ route('movement-types.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="duplicate_name" class="block text-sm font-medium text-gray-700 mb-2">Nuevo Nombre</label>
                    <input type="text" name="name" id="duplicate_name" value="{{ $movementType->name }} (Copia)" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                <input type="hidden" name="effect" value="{{ $movementType->effect }}">
                <div class="flex gap-4">
                    <button type="button" onclick="closeDuplicateModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-300">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                        Duplicar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function printDetails() {
    window.print();
}

function exportDetails() {
    const data = {
        id: {{ $movementType->id }},
        name: "{{ $movementType->name }}",
        effect: "{{ $movementType->effect }}",
        movements_count: {{ $movementType->inventoryMovements->count() }},
        created_at: "{{ $movementType->created_at->format('d/m/Y H:i:s') }}",
        updated_at: "{{ $movementType->updated_at->format('d/m/Y H:i:s') }}"
    };

    const csvContent = "Campo,Valor\n" + 
        Object.entries(data).map(([key, value]) => `"${key}","${value}"`).join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `tipo_movimiento_${{{ $movementType->id }}}_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    window.URL.revokeObjectURL(url);
}

function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function duplicateType() {
    document.getElementById('duplicateModal').classList.remove('hidden');
}

function closeDuplicateModal() {
    document.getElementById('duplicateModal').classList.add('hidden');
}

// Close modals when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.getElementById('duplicateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDuplicateModal();
    }
});
</script>

<style media="print">
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .shadow-md {
        box-shadow: none !important;
    }
}
</style>
@endsection
