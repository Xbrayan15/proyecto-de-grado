@extends('layouts.app')
@section('content')
<h1>Editar Orden de Inventario</h1>
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('inventory-orders.update', $inventoryOrder->id) }}">
    @csrf
    @method('PUT')
    <div>
        <label>Usuario</label>
        <select name="user_id" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $inventoryOrder->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Total</label>
        <input type="number" step="0.01" name="total" value="{{ old('total', $inventoryOrder->total) }}" required>
    </div>
    <div>
        <label>Estado</label>
        <select name="status">
            <option value="pendiente" {{ $inventoryOrder->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="completado" {{ $inventoryOrder->status == 'completado' ? 'selected' : '' }}>Completado</option>
            <option value="cancelado" {{ $inventoryOrder->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
        </select>
    </div>
    <button type="submit">Actualizar</button>
</form>
@endsection
