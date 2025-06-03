@extends('layouts.app')
@section('content')
<h1>Registrar Reembolso</h1>
<form method="POST" action="{{ route('refunds.store') }}">
    @csrf
    <div>
        <label>Transacción</label>
        <select name="transaction_id" required>
            <!-- Opciones de transacciones -->
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
        <label>Motivo</label>
        <select name="reason" required>
            <option value="customer_request">Solicitud del cliente</option>
            <option value="duplicate">Duplicado</option>
            <option value="fraudulent">Fraudulento</option>
            <option value="product_issue">Problema con producto</option>
        </select>
    </div>
    <div>
        <label>Estado</label>
        <select name="status">
            <option value="pending">Pendiente</option>
            <option value="completed">Completado</option>
            <option value="failed">Fallido</option>
        </select>
    </div>
    <div>
        <label>Procesado por</label>
        <select name="processed_by">
            <!-- Opciones de usuarios -->
        </select>
    </div>
    <div>
        <label>Notas</label>
        <textarea name="notes"></textarea>
    </div>
    <div>
        <label>Fecha completado</label>
        <input type="date" name="completed_at">
    </div>
    <div>
        <label>Referencia de pasarela</label>
        <input type="text" name="gateway_reference">
    </div>
    <button type="submit">Guardar</button>
</form>
@endsection
