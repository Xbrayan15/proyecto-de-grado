<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\OrdersPayment;
use App\Models\PaymentMethod;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'order', 'paymentMethod', 'gateway'])->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::all();
        $orders = OrdersPayment::all();
        $paymentMethods = PaymentMethod::all();
        $gateways = PaymentGateway::all();
        return view('transactions.create', compact('users', 'orders', 'paymentMethods', 'gateways'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'order', 'paymentMethod', 'gateway'])->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'order_id' => 'required|exists:orders_payments,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'gateway_id' => 'required|exists:payment_gateways,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'status' => 'in:pending,success,failed',
            'gateway_reference' => 'required|string',
        ]);
        $transaction = Transaction::create($data);
        return redirect()->route('transactions.index')->with('success', 'Transacción creada exitosamente');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $users = User::all();
        $orders = OrdersPayment::all();
        $paymentMethods = PaymentMethod::all();
        $gateways = PaymentGateway::all();
        return view('transactions.edit', compact('transaction', 'users', 'orders', 'paymentMethods', 'gateways'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'order_id' => 'sometimes|required|exists:orders_payments,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'gateway_id' => 'sometimes|required|exists:payment_gateways,id',
            'amount' => 'sometimes|required|numeric',
            'currency' => 'sometimes|required|string|size:3',
            'status' => 'in:pending,success,failed',
            'gateway_reference' => 'sometimes|required|string',
        ]);
        $transaction->update($data);
        return redirect()->route('transactions.index')->with('success', 'Transacción actualizada exitosamente');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transacción eliminada exitosamente');
    }
}
