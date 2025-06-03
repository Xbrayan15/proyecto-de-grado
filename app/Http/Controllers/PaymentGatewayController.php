<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $paymentGateways = PaymentGateway::all();
        return view('payment_gateways.index', compact('paymentGateways'));
    }

    public function create()
    {
        return view('payment_gateways.create');
    }

    public function show($id)
    {
        $paymentGateway = PaymentGateway::findOrFail($id);
        return view('payment_gateways.show', compact('paymentGateway'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'provider' => 'required|string',
            'public_key' => 'required|string',
            'secret_key' => 'required|string',
            'sandbox_mode' => 'boolean',
            'webhook_config' => 'nullable|array',
            'status' => 'in:active,inactive',
        ]);
        $gateway = PaymentGateway::create($data);
        return redirect()->route('payment-gateways.index')->with('success', 'Gateway de pago creado exitosamente');
    }

    public function edit($id)
    {
        $paymentGateway = PaymentGateway::findOrFail($id);
        return view('payment_gateways.edit', compact('paymentGateway'));
    }

    public function update(Request $request, $id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $data = $request->validate([
            'provider' => 'sometimes|required|string',
            'public_key' => 'sometimes|required|string',
            'secret_key' => 'sometimes|required|string',
            'sandbox_mode' => 'boolean',
            'webhook_config' => 'nullable|array',
            'status' => 'in:active,inactive',
        ]);
        $gateway->update($data);
        return redirect()->route('payment-gateways.index')->with('success', 'Gateway de pago actualizado exitosamente');
    }

    public function destroy($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $gateway->delete();
        return redirect()->route('payment-gateways.index')->with('success', 'Gateway de pago eliminado exitosamente');
    }
}
