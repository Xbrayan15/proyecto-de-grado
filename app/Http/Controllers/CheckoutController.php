<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\OrdersPayment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show active carts for checkout
        $carts = Cart::where('status', 'active')
                    ->where('user_id', Auth::id())
                    ->with(['cartItems.product'])
                    ->get();
        
        return view('checkout.index', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show checkout form for a specific cart
        $cart = Cart::where('status', 'active')
                   ->where('user_id', Auth::id())
                   ->with(['cartItems.product'])
                   ->first();
        
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('carts.index')->with('error', 'No tienes productos en tu carrito para proceder al checkout.');
        }
        
        return view('checkout.create', compact('cart'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        try {
            DB::beginTransaction();

            $cart = Cart::where('id', $request->cart_id)
                       ->where('user_id', Auth::id())
                       ->where('status', 'active')
                       ->with('cartItems.product')
                       ->first();

            if (!$cart) {
                throw new \Exception('Carrito no encontrado o no válido');
            }

            // Calculate total amount
            $totalAmount = $cart->cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            // Create payment order
            $orderPayment = OrdersPayment::create([
                'user_id' => Auth::id(),
                'payment_method_id' => $request->payment_method_id,
                'amount' => $totalAmount,
                'status' => 'pending',
                'currency' => 'USD', // Default currency
                'order_details' => json_encode($cart->cartItems->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->product->price,
                        'total_price' => $item->quantity * $item->product->price,
                    ];
                }))
            ]);

            // Update cart status to purchased
            $cart->update(['status' => 'purchased']);

            // Create initial transaction record
            Transaction::create([
                'orders_payment_id' => $orderPayment->id,
                'amount' => $totalAmount,
                'status' => 'pending',
                'transaction_type' => 'purchase',
                'currency' => 'USD',
            ]);

            DB::commit();

            return redirect()->route('orders-payments.show', $orderPayment->id)
                           ->with('success', 'Checkout completado exitosamente. Tu orden de pago ha sido creada.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error durante el checkout: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Show checkout details/confirmation
        $orderPayment = OrdersPayment::where('id', $id)
                                   ->where('user_id', Auth::id())
                                   ->with(['paymentMethod', 'transactions'])
                                   ->firstOrFail();
        
        return view('checkout.show', compact('orderPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Not typically needed for checkout
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Not typically needed for checkout
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cancel checkout/order if still pending
        $orderPayment = OrdersPayment::where('id', $id)
                                   ->where('user_id', Auth::id())
                                   ->where('status', 'pending')
                                   ->firstOrFail();
        
        $orderPayment->update(['status' => 'cancelled']);
        
        return redirect()->route('checkout.index')
                       ->with('success', 'Orden de pago cancelada exitosamente.');
    }
}