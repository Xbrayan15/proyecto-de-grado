@extends('layouts.app')
@section('content')
<h1>Editar Método de Pago</h1>
<form method="POST" action="{{ route('payment-methods.update', $paymentMethod->id) }}">
    @csrf
    @method('PUT')
    <div>
        <label>Usuario</label>
        <select name="user_id" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $paymentMethod->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Tipo</label>
        <select name="type" required>
            <option value="credit_card" {{ $paymentMethod->type == 'credit_card' ? 'selected' : '' }}>Tarjeta de crédito</option>
            <option value="debit_card" {{ $paymentMethod->type == 'debit_card' ? 'selected' : '' }}>Tarjeta de débito</option>
            <option value="bank_account" {{ $paymentMethod->type == 'bank_account' ? 'selected' : '' }}>Cuenta bancaria</option>
            <option value="digital_wallet" {{ $paymentMethod->type == 'digital_wallet' ? 'selected' : '' }}>Billetera digital</option>
        </select>
    </div>
    <div>
        <label>Proveedor</label>
        <input type="text" name="provider" value="{{ $paymentMethod->provider }}">
    </div>
    <div>
        <label>Alias</label>
        <input type="text" name="nickname" value="{{ $paymentMethod->nickname }}">
    </div>
    <div>
        <label>¿Por defecto?</label>
        <input type="checkbox" name="is_default" value="1" {{ $paymentMethod->is_default ? 'checked' : '' }}>
    </div>
    <div>
        <label>Estado</label>
        <select name="status">
            <option value="active" {{ $paymentMethod->status == 'active' ? 'selected' : '' }}>Activo</option>
            <option value="inactive" {{ $paymentMethod->status == 'inactive' ? 'selected' : '' }}>Inactivo</option>
            <option value="expired" {{ $paymentMethod->status == 'expired' ? 'selected' : '' }}>Expirado</option>
        </select>
    </div>
    <button type="submit">Actualizar</button>
</form>
@endsection
