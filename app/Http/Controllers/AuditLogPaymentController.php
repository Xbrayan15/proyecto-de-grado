<?php

namespace App\Http\Controllers;

use App\Models\AuditLogPayment;
use App\Models\User;
use Illuminate\Http\Request;

class AuditLogPaymentController extends Controller
{
    public function index()
    {
        $auditLogs = AuditLogPayment::with('user')->get();
        return view('audit_logs_payments.index', compact('auditLogs'));
    }

    public function create()
    {
        $users = User::all();
        return view('audit_logs_payments.create', compact('users'));
    }

    public function show($id)
    {
        $auditLog = AuditLogPayment::with('user')->findOrFail($id);
        return view('audit_logs_payments.show', compact('auditLog'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|string',
            'entity_type' => 'required|string',
            'entity_id' => 'required|integer',
            'old_values' => 'nullable|array',
            'new_values' => 'nullable|array',
            'ip_address' => 'nullable|string',
            'user_agent' => 'nullable|string',
        ]);
        $auditLog = AuditLogPayment::create($data);
        return redirect()->route('audit-logs-payments.index')->with('success', 'Log de auditoría creado exitosamente');
    }

    public function edit($id)
    {
        $auditLog = AuditLogPayment::findOrFail($id);
        $users = User::all();
        return view('audit_logs_payments.edit', compact('auditLog', 'users'));
    }

    public function update(Request $request, $id)
    {
        $auditLog = AuditLogPayment::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'action' => 'sometimes|required|string',
            'entity_type' => 'sometimes|required|string',
            'entity_id' => 'sometimes|required|integer',
            'old_values' => 'nullable|array',
            'new_values' => 'nullable|array',
            'ip_address' => 'nullable|string',
            'user_agent' => 'nullable|string',
        ]);
        $auditLog->update($data);
        return redirect()->route('audit-logs-payments.index')->with('success', 'Log de auditoría actualizado exitosamente');
    }

    public function destroy($id)
    {
        $auditLog = AuditLogPayment::findOrFail($id);
        $auditLog->delete();
        return redirect()->route('audit-logs-payments.index')->with('success', 'Log de auditoría eliminado exitosamente');
    }
}
