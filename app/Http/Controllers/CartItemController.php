<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartItemController extends Controller
{    public function index()
    {
        $cartItems = CartItem::with(['cart', 'product'])->paginate(10);
        $carts = Cart::with('user')->get();
        return view('cart_items.index', compact('cartItems', 'carts'));
    }    public function create()
    {
        $carts = Cart::with(['user', 'cartItems'])->get();
        $products = Product::all();
        return view('cart_items.create', compact('carts', 'products'));
    }    public function show($id)
    {
        $cartItem = CartItem::with(['cart.cartItems', 'product'])->findOrFail($id);
        return view('cart_items.show', compact('cartItem'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'unit_price' => 'required|numeric',
        ]);
        $item = CartItem::create($data);
        return redirect()->route('cart-items.index')->with('success', 'Item de carrito creado exitosamente');
    }    public function edit($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $carts = Cart::with(['user', 'cartItems'])->get();
        $products = Product::all();
        return view('cart_items.edit', compact('cartItem', 'carts', 'products'));
    }

    public function update(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);
        $data = $request->validate([
            'cart_id' => 'sometimes|required|exists:carts,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer',
            'unit_price' => 'sometimes|required|numeric',
        ]);
        $item->update($data);
        return redirect()->route('cart-items.index')->with('success', 'Item de carrito actualizado exitosamente');
    }

    public function destroy($id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();
        return redirect()->route('cart-items.index')->with('success', 'Item de carrito eliminado exitosamente');
    }
}
