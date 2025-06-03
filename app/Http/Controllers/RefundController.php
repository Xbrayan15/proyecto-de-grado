<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::with(['transaction', 'processedBy'])->get();
        return view('refunds.index', compact('refunds'));
    }

    public function create()
    {
        $transactions = Transaction::all();
        $users = User::all();
        return view('refunds.create', compact('transactions', 'users'));
    }

    public function show($id)
    {
        $refund = Refund::with(['transaction', 'processedBy'])->findOrFail($id);
        return view('refunds.show', compact('refund'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'reason' => 'required|in:customer_request,duplicate,fraudulent,product_issue',
            'status' => 'in:pending,completed,failed',
            'processed_by' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'completed_at' => 'nullable|date',
            'gateway_reference' => 'nullable|string',
        ]);
        $refund = Refund::create($data);
        return redirect()->route('refunds.index')->with('success', 'Reembolso creado exitosamente');
    }

    public function edit($id)
    {
        $refund = Refund::findOrFail($id);
        $transactions = Transaction::all();
        $users = User::all();
        return view('refunds.edit', compact('refund', 'transactions', 'users'));
    }

    public function update(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);
        $data = $request->validate([
            'transaction_id' => 'sometimes|required|exists:transactions,id',
            'amount' => 'sometimes|required|numeric',
            'currency' => 'sometimes|required|string|size:3',
            'reason' => 'sometimes|required|in:customer_request,duplicate,fraudulent,product_issue',
            'status' => 'in:pending,completed,failed',
            'processed_by' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'completed_at' => 'nullable|date',
            'gateway_reference' => 'nullable|string',
        ]);
        $refund->update($data);
        return redirect()->route('refunds.index')->with('success', 'Reembolso actualizado exitosamente');
    }

    public function destroy($id)
    {
        $refund = Refund::findOrFail($id);
        $refund->delete();
        return redirect()->route('refunds.index')->with('success', 'Reembolso eliminado exitosamente');
    }
}
