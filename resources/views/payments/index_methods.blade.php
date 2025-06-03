@extends('layouts.app')
@section('content')
<h1>Métodos de Pago</h1>
<a href="{{ route('payment-methods.create') }}">Crear nuevo método de pago</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Tipo</th>
            <th>Proveedor</th>
            <th>Alias</th>
            <th>Por defecto</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($paymentMethods as $method)
        <tr>
            <td>{{ $method->id }}</td>
            <td>{{ $method->user->name ?? '-' }}</td>
            <td>{{ $method->type }}</td>
            <td>{{ $method->provider }}</td>
            <td>{{ $method->nickname }}</td>
            <td>{{ $method->is_default ? 'Sí' : 'No' }}</td>
            <td>{{ $method->status }}</td>
            <td>
                <a href="{{ route('payment-methods.edit', $method->id) }}">Editar</a>
                <form action="{{ route('payment-methods.destroy', $method->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este método?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
