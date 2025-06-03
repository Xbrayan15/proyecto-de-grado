<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\MovementType;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class InventoryMovementController extends Controller
{
    public function index()
    {
        $movements = InventoryMovement::with(['movementType', 'product', 'order', 'user'])->get();
        return view('inventory_movements.index', compact('movements'));
    }

    public function create()
    {
        $movementTypes = MovementType::all();
        $products = Product::all();
        $orders = Order::all();
        $users = User::all();
        return view('inventory_movements.create', compact('movementTypes', 'products', 'orders', 'users'));
    }

    public function show($id)
    {
        $movement = InventoryMovement::with(['movementType', 'product', 'order', 'user'])->findOrFail($id);
        return view('inventory_movements.show', compact('movement'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'movement_date' => 'required|date',
            'movement_type_id' => 'required|exists:movement_types,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'unit_price' => 'nullable|numeric',
            'order_id' => 'nullable|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);
        $movement = InventoryMovement::create($data);
        return redirect()->route('inventory-movements.index')->with('success', 'Movimiento de inventario creado exitosamente');
    }

    public function edit($id)
    {
        $movement = InventoryMovement::findOrFail($id);
        $movementTypes = MovementType::all();
        $products = Product::all();
        $orders = Order::all();
        $users = User::all();
        return view('inventory_movements.edit', compact('movement', 'movementTypes', 'products', 'orders', 'users'));
    }

    public function update(Request $request, $id)
    {
        $movement = InventoryMovement::findOrFail($id);
        $data = $request->validate([
            'movement_date' => 'sometimes|required|date',
            'movement_type_id' => 'sometimes|required|exists:movement_types,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer',
            'unit_price' => 'nullable|numeric',
            'order_id' => 'nullable|exists:orders,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'notes' => 'nullable|string',
        ]);
        $movement->update($data);
        return redirect()->route('inventory-movements.index')->with('success', 'Movimiento de inventario actualizado exitosamente');
    }

    public function destroy($id)
    {
        $movement = InventoryMovement::findOrFail($id);
        $movement->delete();
        return redirect()->route('inventory-movements.index')->with('success', 'Movimiento de inventario eliminado exitosamente');
    }
}
