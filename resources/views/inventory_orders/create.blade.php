@extends('layouts.app')
@section('content')
<h1>Crear Orden de Inventario</h1>
<form method="POST" action="{{ route('inventory-orders.store') }}">
    @csrf
    <div>
        <label>Usuario</label>
        <select name="user_id" required>
            <!-- Opciones de usuarios -->
        </select>
    </div>
    <div>
        <label>Total</label>
        <input type="number" step="0.01" name="total" required>
    </div>
    <div>
        <label>Estado</label>
        <select name="status">
            <option value="pendiente">Pendiente</option>
            <option value="completado">Completado</option>
            <option value="cancelado">Cancelado</option>
        </select>
    </div>
    <button type="submit">Guardar</button>
</form>
@endsection
