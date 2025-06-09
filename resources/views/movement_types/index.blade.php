@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Tipos de Movimiento</h1>
            <p class="text-gray-600">Gestión de tipos de movimientos de inventario</p>
        </div>
        <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
            <button onclick="exportData()" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-download mr-2"></i>Exportar
            </button>
            <a href="{{ route('movement-types.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i>Nuevo Tipo
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-list-ul text-blue-500 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tipos</p>
                    <p class="text-2xl font-bold text-gray-900" id="total-types">{{ $movementTypes->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-arrow-up text-green-500 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tipos Entrada</p>
                    <p class="text-2xl font-bold text-gray-900" id="in-types">{{ $movementTypes->where('effect', 'in')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-arrow-down text-red-500 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tipos Salida</p>
                    <p class="text-2xl font-bold text-gray-900" id="out-types">{{ $movementTypes->where('effect', 'out')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-purple-500 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Último Agregado</p>
                    <p class="text-lg font-bold text-gray-900">
                        @if($movementTypes->count() > 0)
                            {{ $movementTypes->sortByDesc('created_at')->first()->created_at->diffForHumans() }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <div class="relative">
                    <input type="text" id="search" placeholder="Buscar por nombre..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div>
                <label for="effectFilter" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Efecto</label>
                <select id="effectFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos los efectos</option>
                    <option value="in">Entrada</option>
                    <option value="out">Salida</option>
                </select>
            </div>

            <div class="flex items-end">
                <button onclick="clearFilters()" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-undo mr-2"></i>Limpiar Filtros
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Movement Types Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Lista de Tipos de Movimiento</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="movementTypesTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(0)">
                            ID <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(1)">
                            Nombre <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(2)">
                            Efecto <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(3)">
                            Fecha Creación <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($movementTypes as $type)
                        <tr class="hover:bg-gray-50 transition duration-150" data-effect="{{ $type->effect }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                #{{ $type->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full flex items-center justify-center {{ $type->effect === 'in' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            <i class="fas {{ $type->effect === 'in' ? 'fa-arrow-up' : 'fa-arrow-down' }} text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $type->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $type->effect === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <span class="mr-1">
                                        <i class="fas {{ $type->effect === 'in' ? 'fa-plus' : 'fa-minus' }}"></i>
                                    </span>
                                    {{ $type->effect === 'in' ? 'Entrada' : 'Salida' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex flex-col">
                                    <span>{{ $type->created_at->format('d/m/Y') }}</span>
                                    <span class="text-xs text-gray-500">{{ $type->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('movement-types.show', $type->id) }}" 
                                        class="text-blue-600 hover:text-blue-900 transition duration-150" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('movement-types.edit', $type->id) }}" 
                                        class="text-yellow-600 hover:text-yellow-900 transition duration-150" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $type->id }}, '{{ $type->name }}')" 
                                        class="text-red-600 hover:text-red-900 transition duration-150" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay tipos de movimiento</h3>
                                    <p class="text-gray-500 mb-4">Comienza creando tu primer tipo de movimiento</p>
                                    <a href="{{ route('movement-types.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                        <i class="fas fa-plus mr-2"></i>Crear Tipo de Movimiento
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        @if($movementTypes->count() > 0)
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando <span class="font-medium">{{ $movementTypes->count() }}</span> tipos de movimiento
                    </div>
                    <div class="text-sm text-gray-500">
                        Última actualización: {{ now()->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        @endif
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
                    <span id="deleteTypeName" class="font-medium text-gray-900"></span>?
                </p>
                <p class="text-xs text-red-600 mt-2">Esta acción no se puede deshacer.</p>
            </div>
            <div class="flex gap-4 px-7 py-3">
                <button onclick="closeDeleteModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-300">
                    Cancelar
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('search');
    const effectFilter = document.getElementById('effectFilter');
    const table = document.getElementById('movementTypesTable');
    const rows = table.querySelectorAll('tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const effectValue = effectFilter.value;

        rows.forEach(row => {
            if (row.children.length === 1) return; // Skip empty state row

            const name = row.children[1].textContent.toLowerCase();
            const effect = row.dataset.effect;

            const matchesSearch = name.includes(searchTerm);
            const matchesEffect = effectValue === '' || effect === effectValue;

            row.style.display = matchesSearch && matchesEffect ? '' : 'none';
        });

        updateStats();
    }

    function updateStats() {
        const visibleRows = Array.from(rows).filter(row => 
            row.style.display !== 'none' && row.children.length > 1
        );

        const inCount = visibleRows.filter(row => row.dataset.effect === 'in').length;
        const outCount = visibleRows.filter(row => row.dataset.effect === 'out').length;

        document.getElementById('total-types').textContent = visibleRows.length;
        document.getElementById('in-types').textContent = inCount;
        document.getElementById('out-types').textContent = outCount;
    }

    searchInput.addEventListener('input', filterTable);
    effectFilter.addEventListener('change', filterTable);
});

function clearFilters() {
    document.getElementById('search').value = '';
    document.getElementById('effectFilter').value = '';
    
    const rows = document.querySelectorAll('#movementTypesTable tbody tr');
    rows.forEach(row => row.style.display = '');
    
    // Reset stats
    const totalTypes = {{ $movementTypes->count() }};
    const inTypes = {{ $movementTypes->where('effect', 'in')->count() }};
    const outTypes = {{ $movementTypes->where('effect', 'out')->count() }};
    
    document.getElementById('total-types').textContent = totalTypes;
    document.getElementById('in-types').textContent = inTypes;
    document.getElementById('out-types').textContent = outTypes;
}

function sortTable(columnIndex) {
    const table = document.getElementById('movementTypesTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.children.length > 1);
    
    const isAscending = table.dataset.sortDirection !== 'asc';
    table.dataset.sortDirection = isAscending ? 'asc' : 'desc';
    
    rows.sort((a, b) => {
        const aValue = a.children[columnIndex].textContent.trim();
        const bValue = b.children[columnIndex].textContent.trim();
        
        if (columnIndex === 0) { // ID column
            return isAscending ? 
                parseInt(aValue.replace('#', '')) - parseInt(bValue.replace('#', '')) :
                parseInt(bValue.replace('#', '')) - parseInt(aValue.replace('#', ''));
        }
        
        return isAscending ? 
            aValue.localeCompare(bValue) : 
            bValue.localeCompare(aValue);
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

function confirmDelete(id, name) {
    document.getElementById('deleteTypeName').textContent = name;
    document.getElementById('deleteForm').action = `{{ route('movement-types.destroy', ['movement_type' => ':id']) }}`.replace(':id', id);
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function exportData() {
    const rows = document.querySelectorAll('#movementTypesTable tbody tr');
    const csvContent = "ID,Nombre,Efecto,Fecha Creación\n" + 
        Array.from(rows)
            .filter(row => row.children.length > 1 && row.style.display !== 'none')
            .map(row => {
                const id = row.children[0].textContent.trim();
                const name = row.children[1].querySelector('.text-sm').textContent.trim();
                const effect = row.children[2].textContent.trim();
                const date = row.children[3].querySelector('span').textContent.trim();
                return `"${id}","${name}","${effect}","${date}"`;
            }).join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `tipos_movimiento_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    window.URL.revokeObjectURL(url);
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection
