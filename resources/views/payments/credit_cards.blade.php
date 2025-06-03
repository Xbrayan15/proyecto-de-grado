@extends('layouts.app')
@section('content')
<h1>Tarjetas de Crédito</h1>
<form method="POST" action="{{ route('credit-cards.store') }}">
    @csrf
    <div>
        <label>Método de pago</label>
        <select name="payment_method_id" required>
            <!-- Opciones de métodos de pago -->
        </select>
    </div>
    <div>
        <label>Últimos 4 dígitos</label>
        <input type="text" name="last_four" maxlength="4" required>
    </div>
    <div>
        <label>Mes de expiración</label>
        <input type="text" name="expiry_month" maxlength="2" required>
    </div>
    <div>
        <label>Año de expiración</label>
        <input type="text" name="expiry_year" maxlength="4" required>
    </div>
    <div>
        <label>Titular</label>
        <input type="text" name="card_holder" required>
    </div>
    <div>
        <label>Marca</label>
        <select name="brand" required>
            <option value="visa">Visa</option>
            <option value="mastercard">Mastercard</option>
            <option value="amex">Amex</option>
            <option value="discover">Discover</option>
            <option value="other">Otra</option>
        </select>
    </div>
    <div>
        <label>Token</label>
        <input type="text" name="token_id">
    </div>
    <button type="submit">Guardar</button>
</form>
@endsection
