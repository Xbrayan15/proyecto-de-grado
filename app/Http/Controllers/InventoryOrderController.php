<?php

namespace App\Http\Controllers;

use App\Models\InventoryOrder;
use App\Models\User;
use Illuminate\Http\Request;

class InventoryOrderController extends Controller
{
    public function index()
    {
        $inventoryOrders = InventoryOrder::with('user')->get();
        return view('inventory_orders.index', compact('inventoryOrders'));
    }

    public function create()
    {
        $users = User::all();
        return view('inventory_orders.create', compact('users'));
    }

    public function show($id)
    {
        $inventoryOrder = InventoryOrder::with('user')->findOrFail($id);
        return view('inventory_orders.show', compact('inventoryOrder'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'status' => 'in:pendiente,completado,cancelado',
        ]);
        $order = InventoryOrder::create($data);
        return redirect()->route('inventory-orders.index')->with('success', 'Orden de inventario creada exitosamente');
    }

    public function edit($id)
    {
        $inventoryOrder = InventoryOrder::findOrFail($id);
        $users = User::all();
        return view('inventory_orders.edit', compact('inventoryOrder', 'users'));
    }

    public function update(Request $request, $id)
    {
        $order = InventoryOrder::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'total' => 'sometimes|required|numeric',
            'status' => 'in:pendiente,completado,cancelado',
        ]);
        $order->update($data);
        return redirect()->route('inventory-orders.index')->with('success', 'Orden de inventario actualizada exitosamente');
    }

    public function destroy($id)
    {
        $order = InventoryOrder::findOrFail($id);
        $order->delete();
        return redirect()->route('inventory-orders.index')->with('success', 'Orden de inventario eliminada exitosamente');
    }
}
