@extends('layouts.app')
@section('content')
<h1>Registrar Pasarela de Pago</h1>
<form method="POST" action="{{ route('payment-gateways.store') }}">
    @csrf
    <div>
        <label>Proveedor</label>
        <input type="text" name="provider" required>
    </div>
    <div>
        <label>Clave pública</label>
        <input type="text" name="public_key" required>
    </div>
    <div>
        <label>Clave secreta</label>
        <input type="text" name="secret_key" required>
    </div>
    <div>
        <label>Sandbox</label>
        <input type="checkbox" name="sandbox_mode" value="1" checked>
    </div>
    <div>
        <label>Config Webhook (JSON)</label>
        <textarea name="webhook_config"></textarea>
    </div>
    <div>
        <label>Estado</label>
        <select name="status">
            <option value="active">Activo</option>
            <option value="inactive">Inactivo</option>
        </select>
    </div>
    <button type="submit">Guardar</button>
</form>
@endsection
