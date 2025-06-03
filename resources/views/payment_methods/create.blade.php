@extends('layouts.app')
@section('content')
<h1>Crear Método de Pago</h1>
<form method="POST" action="{{ route('payment-methods.store') }}">
    @csrf
    <div>
        <label>Usuario</label>
        <select name="user_id" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Tipo</label>
        <select name="type" required>
            <option value="credit_card">Tarjeta de crédito</option>
            <option value="debit_card">Tarjeta de débito</option>
            <option value="bank_account">Cuenta bancaria</option>
            <option value="digital_wallet">Billetera digital</option>
        </select>
    </div>
    <div>
        <label>Proveedor</label>
        <input type="text" name="provider">
    </div>
    <div>
        <label>Alias</label>
        <input type="text" name="nickname">
    </div>
    <div>
        <label>¿Por defecto?</label>
        <input type="checkbox" name="is_default" value="1">
    </div>
    <div>
        <label>Estado</label>
        <select name="status">
            <option value="active">Activo</option>
            <option value="inactive">Inactivo</option>
            <option value="expired">Expirado</option>
        </select>
    </div>
    <button type="submit">Guardar</button>
</form>
@endsection
