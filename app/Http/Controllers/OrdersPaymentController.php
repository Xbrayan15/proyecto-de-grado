<?php

namespace App\Http\Controllers;

use App\Models\OrdersPayment;
use App\Models\User;
use Illuminate\Http\Request;

class OrdersPaymentController extends Controller
{
    public function index()
    {
        $ordersPayments = OrdersPayment::with('user')->get();
        return view('orders_payments.index', compact('ordersPayments'));
    }

    public function create()
    {
        $users = User::all();
        return view('orders_payments.create', compact('users'));
    }

    public function show($id)
    {
        $ordersPayment = OrdersPayment::with('user')->findOrFail($id);
        return view('orders_payments.show', compact('ordersPayment'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'status' => 'in:pending,completed,canceled',
        ]);
        $order = OrdersPayment::create($data);
        return redirect()->route('orders-payments.index')->with('success', 'Orden de pago creada exitosamente');
    }

    public function edit($id)
    {
        $ordersPayment = OrdersPayment::findOrFail($id);
        $users = User::all();
        return view('orders_payments.edit', compact('ordersPayment', 'users'));
    }

    public function update(Request $request, $id)
    {
        $order = OrdersPayment::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'total' => 'sometimes|required|numeric',
            'status' => 'in:pending,completed,canceled',
        ]);
        $order->update($data);
        return redirect()->route('orders-payments.index')->with('success', 'Orden de pago actualizada exitosamente');
    }

    public function destroy($id)
    {
        $order = OrdersPayment::findOrFail($id);
        $order->delete();
        return redirect()->route('orders-payments.index')->with('success', 'Orden de pago eliminada exitosamente');
    }
}
