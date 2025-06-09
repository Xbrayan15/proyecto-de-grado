<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class CreditCardController extends Controller
{
    public function index()
    {
        $creditCards = CreditCard::with('paymentMethod')->get();
        return view('credit_cards.index', compact('creditCards'));
    }

    public function create()
    {
        $paymentMethods = PaymentMethod::all();
        return view('credit_cards.create', compact('paymentMethods'));
    }

    public function show($id)
    {
        $creditCard = CreditCard::with('paymentMethod')->findOrFail($id);
        return view('credit_cards.show', compact('creditCard'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'last_four' => 'required|string|size:4',
            'expiry_month' => 'required|integer|min:1|max:12',
            'expiry_year' => 'required|integer|min:2000|max:2100',
            'card_holder' => 'required|string',
            'brand' => 'required|in:visa,mastercard,amex,discover,other',
            'token_id' => 'nullable|string',
        ]);
        $data['expiry_month'] = (int) $data['expiry_month'];
        $data['expiry_year'] = (int) $data['expiry_year'];
        $card = CreditCard::create($data);
        return redirect()->route('credit-cards.index')->with('success', 'Tarjeta de crédito creada exitosamente');
    }

    public function edit($id)
    {
        $creditCard = CreditCard::findOrFail($id);
        $paymentMethods = PaymentMethod::all();
        return view('credit_cards.edit', compact('creditCard', 'paymentMethods'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'payment_method_id' => 'sometimes|required|exists:payment_methods,id',
            'last_four' => 'sometimes|required|string|size:4',
            'expiry_month' => 'sometimes|required|integer|min:1|max:12',
            'expiry_year' => 'sometimes|required|integer|min:2000|max:2100',
            'card_holder' => 'sometimes|required|string',
            'brand' => 'sometimes|required|in:visa,mastercard,amex,discover,other',
            'token_id' => 'nullable|string',
        ]);
        if (isset($data['expiry_month'])) $data['expiry_month'] = (int) $data['expiry_month'];
        if (isset($data['expiry_year'])) $data['expiry_year'] = (int) $data['expiry_year'];
        $creditCard = CreditCard::findOrFail($id);
        $creditCard->update($data);
        return redirect()->route('credit-cards.index')->with('success', 'Tarjeta de crédito actualizada exitosamente');
    }

    public function destroy($id)
    {
        $card = CreditCard::findOrFail($id);
        $card->delete();
        return redirect()->route('credit-cards.index')->with('success', 'Tarjeta de crédito eliminada exitosamente');
    }
}
