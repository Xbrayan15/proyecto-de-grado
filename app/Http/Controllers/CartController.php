<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    }    /**
     * Get active carts for API
     */
    public function getActiveCarts(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get or create the user's single active cart
        $activeCart = $this->getUserActiveCart($user);
        $activeCart->loadCount('cartItems');

        return response()->json([$activeCart]);
    }/**
     * Add product to cart via API
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        // Get the product to check stock and get price
        $product = \App\Models\Product::findOrFail($request->product_id);
        
        // Check if we have enough stock
        if ($product->quantity < $request->quantity) {
            return response()->json([
                'error' => 'Insufficient stock',
                'available' => $product->quantity
            ], 400);
        }        // Always use the user's active cart
        $cart = $this->getUserActiveCart($user);

        // Check if product already exists in cart
        $existingItem = \App\Models\CartItem::where('cart_id', $cart->id)
                                          ->where('product_id', $request->product_id)
                                          ->first();

        if ($existingItem) {
            // Update quantity if item exists
            $newQuantity = $existingItem->quantity + $request->quantity;
            
            // Check stock again for total quantity
            if ($product->quantity < $newQuantity) {
                return response()->json([
                    'error' => 'Insufficient stock for total quantity',
                    'available' => $product->quantity,
                    'current_in_cart' => $existingItem->quantity
                ], 400);
            }
            
            $existingItem->update([
                'quantity' => $newQuantity,
                'unit_price' => $product->price
            ]);
            
            $cartItem = $existingItem;
        } else {
            // Create new cart item
            $cartItem = \App\Models\CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price
            ]);
        }

        // Return success response with cart details
        $cart->load(['cartItems', 'cartItems.product']);
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart' => $cart,
            'added_item' => $cartItem->load('product')
        ]);
    }
}
