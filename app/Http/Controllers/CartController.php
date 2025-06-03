<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['user', 'items'])->get();
        return view('carts.index', compact('carts'));
    }

    public function create()
    {
        $users = User::all();
        return view('carts.create', compact('users'));
    }

    public function show($id)
    {
        $cart = Cart::with(['user', 'items'])->findOrFail($id);
        return view('carts.show', compact('cart'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'in:active,purchased,abandoned',
        ]);
        $cart = Cart::create($data);
        return redirect()->route('carts.index')->with('success', 'Carrito creado exitosamente');
    }

    public function edit($id)
    {
        $cart = Cart::findOrFail($id);
        $users = User::all();
        return view('carts.edit', compact('cart', 'users'));
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'status' => 'in:active,purchased,abandoned',
        ]);
        $cart->update($data);
        return redirect()->route('carts.index')->with('success', 'Carrito actualizado exitosamente');
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('carts.index')->with('success', 'Carrito eliminado exitosamente');
    }
}
