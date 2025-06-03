@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Editar Método de Pago</h1>
    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('payment-methods.update', $paymentMethod->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block font-semibold">Usuario</label>
            <select name="user_id" class="w-full border rounded p-2" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $paymentMethod->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Tipo</label>
            <select name="type" class="w-full border rounded p-2" required>
                <option value="credit_card" {{ $paymentMethod->type == 'credit_card' ? 'selected' : '' }}>Tarjeta de crédito</option>
                <option value="debit_card" {{ $paymentMethod->type == 'debit_card' ? 'selected' : '' }}>Tarjeta de débito</option>
                <option value="bank_account" {{ $paymentMethod->type == 'bank_account' ? 'selected' : '' }}>Cuenta bancaria</option>
                <option value="digital_wallet" {{ $paymentMethod->type == 'digital_wallet' ? 'selected' : '' }}>Billetera digital</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Proveedor</label>
            <input type="text" name="provider" class="w-full border rounded p-2" value="{{ $paymentMethod->provider }}">
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Alias</label>
            <input type="text" name="nickname" class="w-full border rounded p-2" value="{{ $paymentMethod->nickname }}">
        </div>
        <div class="mb-4">
            <label class="block font-semibold">¿Por defecto?</label>
            <input type="checkbox" name="is_default" value="1" {{ $paymentMethod->is_default ? 'checked' : '' }}>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Estado</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="active" {{ $paymentMethod->status == 'active' ? 'selected' : '' }}>Activo</option>
                <option value="inactive" {{ $paymentMethod->status == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                <option value="expired" {{ $paymentMethod->status == 'expired' ? 'selected' : '' }}>Expirado</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
    </form>
</div>
@endsection
