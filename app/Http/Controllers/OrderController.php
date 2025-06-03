<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        return view('orders.create', compact('users'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'items')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'status' => 'in:pendiente,completado,cancelado',
        ]);
        $order = Order::create($data);
        return redirect()->route('orders.index')->with('success', 'Orden creada exitosamente');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $users = User::all();
        return view('orders.edit', compact('order', 'users'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'total' => 'sometimes|required|numeric',
            'status' => 'in:pendiente,completado,cancelado',
        ]);
        $order->update($data);
        return redirect()->route('orders.index')->with('success', 'Orden actualizada exitosamente');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Orden eliminada exitosamente');
    }
}
