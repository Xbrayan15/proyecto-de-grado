@extends('layouts.app')
@section('content')
<h1>Registrar Transacción</h1>
<form method="POST" action="{{ route('transactions.store') }}">
    @csrf
    <div>
        <label>Usuario</label>
        <select name="user_id">
            <!-- Opciones de usuarios -->
        </select>
    </div>
    <div>
        <label>Orden de Pago</label>
        <select name="order_id" required>
            <!-- Opciones de órdenes de pago -->
        </select>
    </div>
    <div>
        <label>Método de Pago</label>
        <select name="payment_method_id">
            <!-- Opciones de métodos de pago -->
        </select>
    </div>
    <div>
        <label>Pasarela</label>
        <select name="gateway_id" required>
            <!-- Opciones de pasarelas -->
        </select>
    </div>
    <div>
        <label>Monto</label>
        <input type="number" step="0.01" name="amount" required>
    </div>
    <div>
        <label>Moneda</label>
        <input type="text" name="currency" value="USD" required>
    </div>
    <div>
        <label>Estado</label>
        <select name="status">
            <option value="pending">Pendiente</option>
            <option value="success">Éxito</option>
            <option value="failed">Fallido</option>
        </select>
    </div>
    <div>
        <label>Referencia de pasarela</label>
        <input type="text" name="gateway_reference" required>
    </div>
    <button type="submit">Guardar</button>
</form>
@endsection
