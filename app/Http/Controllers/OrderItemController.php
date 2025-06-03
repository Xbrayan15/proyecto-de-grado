<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])->get();
        return view('order_items.index', compact('orderItems'));
    }

    public function create()
    {
        $orders = Order::all();
        $products = Product::all();
        return view('order_items.create', compact('orders', 'products'));
    }

    public function show($id)
    {
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);
        return view('order_items.show', compact('orderItem'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);
        $item = OrderItem::create($data);
        return redirect()->route('order-items.index')->with('success', 'Item de orden creado exitosamente');
    }

    public function edit($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orders = Order::all();
        $products = Product::all();
        return view('order_items.edit', compact('orderItem', 'orders', 'products'));
    }

    public function update(Request $request, $id)
    {
        $item = OrderItem::findOrFail($id);
        $data = $request->validate([
            'order_id' => 'sometimes|required|exists:orders,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
        ]);
        $item->update($data);
        return redirect()->route('order-items.index')->with('success', 'Item de orden actualizado exitosamente');
    }

    public function destroy($id)
    {
        $item = OrderItem::findOrFail($id);
        $item->delete();
        return redirect()->route('order-items.index')->with('success', 'Item de orden eliminado exitosamente');
    }
}
