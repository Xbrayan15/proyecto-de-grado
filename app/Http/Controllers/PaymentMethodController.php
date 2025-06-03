<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::with('user')->get();
        return view('payment_methods.index', compact('paymentMethods'));
    }    public function show($id)
    {
        $paymentMethod = PaymentMethod::with('user')->findOrFail($id);
        return view('payment_methods.show', compact('paymentMethod'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:credit_card,debit_card,bank_account,digital_wallet',
            'provider' => 'nullable|string',
            'nickname' => 'nullable|string',
            'is_default' => 'boolean',
            'status' => 'in:active,inactive,expired',
        ]);
        $method = PaymentMethod::create($data);
        return redirect()->route('payment-methods.index')->with('success', 'Método de pago creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'type' => 'sometimes|required|in:credit_card,debit_card,bank_account,digital_wallet',
            'provider' => 'nullable|string',
            'nickname' => 'nullable|string',
            'is_default' => 'boolean',
            'status' => 'in:active,inactive,expired',
        ]);
        $method->update($data);
        return redirect()->route('payment-methods.index')->with('success', 'Método de pago actualizado correctamente.');
    }

    public function destroy($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->delete();
        return redirect()->route('payment-methods.index')->with('success', 'Método de pago eliminado correctamente.');
    }

    public function create()
    {
        $users = \App\Models\User::all();
        return view('payment_methods.create', compact('users'));
    }

    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $users = \App\Models\User::all();
        return view('payment_methods.edit', compact('paymentMethod', 'users'));
    }
}
