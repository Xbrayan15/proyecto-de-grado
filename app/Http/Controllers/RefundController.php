<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Refund as StripeRefund;

class RefundController extends Controller
{    public function index()
    {
        $refunds = Refund::with(['transaction', 'processedBy'])->get();
        
        // Si es una petición API, devolver JSON
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $refunds
            ]);
        }
        
        return view('refunds.index', compact('refunds'));
    }

    public function create()
    {
        $transactions = Transaction::all();
        $users = User::all();
        return view('refunds.create', compact('transactions', 'users'));
    }    public function show($id)
    {
        $refund = Refund::with(['transaction', 'processedBy'])->findOrFail($id);
        
        // Si es una petición API, devolver JSON
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $refund
            ]);
        }
        
        return view('refunds.show', compact('refund'));
    }    public function store(Request $request)
    {
        try {            Log::info('Refund creation attempt', [
                'user_id' => Auth::id(),
                'user_roles' => Auth::user()->roles->pluck('id')->toArray(),
                'data' => $request->all()
            ]);
            
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
              // Si no se proporciona processed_by, usar el usuario actual
            if (!isset($data['processed_by']) || empty($data['processed_by'])) {
                $data['processed_by'] = Auth::id();
                Log::info('Setting processed_by to current user', ['user_id' => Auth::id()]);
            }
            
            // Si el estado es completed y no se proporciona completed_at, usar la fecha actual
            if (isset($data['status']) && $data['status'] === 'completed' && !isset($data['completed_at'])) {
                $data['completed_at'] = now();
                Log::info('Setting completed_at to now()', ['completed_at' => now()]);
            }
              $refund = Refund::create($data);
            Log::info('Refund created successfully', ['refund_id' => $refund->id, 'data' => $data]);
            
            // Intentar crear el reembolso en Stripe si la transacción es de Stripe
            $this->createStripeRefund($refund);
            
            // Si es una petición API, devolver JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reembolso creado exitosamente',
                    'data' => $refund->load(['transaction', 'processedBy'])
                ], 201);
            }
            
            return redirect()->route('refunds.index')->with('success', 'Reembolso creado exitosamente');
        } catch (\Exception $e) {            Log::error('Error creating refund', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Si es una petición API, devolver error JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el reembolso',
                    'error' => $e->getMessage()
                ], 400);
            }
            
            return back()->withErrors(['error' => 'Error al crear el reembolso: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $refund = Refund::findOrFail($id);
        $transactions = Transaction::all();
        $users = User::all();
        return view('refunds.edit', compact('refund', 'transactions', 'users'));
    }    public function update(Request $request, $id)
    {
        try {
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
              // Si no se proporciona processed_by, usar el usuario actual
            if (isset($data['processed_by']) && empty($data['processed_by'])) {
                $data['processed_by'] = Auth::id();
            }
            
            // Si el estado es completed y no se proporciona completed_at, usar la fecha actual
            if (isset($data['status']) && $data['status'] === 'completed' && 
                (!isset($data['completed_at']) || empty($data['completed_at']))) {
                $data['completed_at'] = now();
            }
            
            $refund->update($data);
            
            // Si es una petición API, devolver JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reembolso actualizado exitosamente',
                    'data' => $refund->load(['transaction', 'processedBy'])
                ]);
            }
            
            return redirect()->route('refunds.index')->with('success', 'Reembolso actualizado exitosamente');
        } catch (\Exception $e) {
            // Si es una petición API, devolver error JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el reembolso',
                    'error' => $e->getMessage()
                ], 400);
            }
            
            return back()->withErrors(['error' => 'Error al actualizar el reembolso: ' . $e->getMessage()])->withInput();
        }
    }    public function destroy($id)
    {
        try {
            $refund = Refund::findOrFail($id);
            $refund->delete();
            
            // Si es una petición API, devolver JSON
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reembolso eliminado exitosamente'
                ]);
            }
            
            return redirect()->route('refunds.index')->with('success', 'Reembolso eliminado exitosamente');
        } catch (\Exception $e) {
            // Si es una petición API, devolver error JSON
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el reembolso',
                    'error' => $e->getMessage()
                ], 400);
            }
            
            return back()->withErrors(['error' => 'Error al eliminar el reembolso: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Crear reembolso en Stripe si la transacción es de Stripe
     */
    private function createStripeRefund(Refund $refund)
    {
        try {
            // Cargar la transacción con su gateway
            $transaction = $refund->transaction()->with('gateway')->first();
            
            if (!$transaction) {
                Log::warning('No se encontró la transacción para el reembolso', ['refund_id' => $refund->id]);
                return;
            }
            
            // Verificar si el gateway es Stripe
            $gateway = $transaction->gateway;
            if (!$gateway || strtolower($gateway->provider) !== 'stripe') {
                Log::info('El reembolso no es para una transacción de Stripe, saltando integración', [
                    'refund_id' => $refund->id,
                    'gateway_provider' => $gateway->provider ?? 'unknown'
                ]);
                return;
            }
            
            // Configurar Stripe
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            // El gateway_reference contiene el payment_intent_id de Stripe
            $paymentIntentId = $transaction->gateway_reference;
            
            if (!$paymentIntentId) {
                Log::warning('No se encontró payment_intent_id para crear el reembolso en Stripe', [
                    'refund_id' => $refund->id,
                    'transaction_id' => $transaction->id
                ]);
                return;
            }
            
            Log::info('Creando reembolso en Stripe', [
                'refund_id' => $refund->id,
                'payment_intent_id' => $paymentIntentId,
                'amount' => $refund->amount * 100, // Stripe usa centavos
                'currency' => $refund->currency
            ]);
            
            // Crear el reembolso en Stripe
            $stripeRefund = StripeRefund::create([
                'payment_intent' => $paymentIntentId,
                'amount' => intval($refund->amount * 100), // Convertir a centavos
                'reason' => $this->mapReasonToStripe($refund->reason),
                'metadata' => [
                    'refund_id' => $refund->id,
                    'transaction_id' => $transaction->id,
                    'processed_by' => $refund->processed_by
                ]
            ]);
            
            // Actualizar el reembolso local con la referencia de Stripe
            $refund->update([
                'gateway_reference' => $stripeRefund->id,
                'status' => 'completed',
                'completed_at' => now()
            ]);
            
            Log::info('Reembolso creado exitosamente en Stripe', [
                'refund_id' => $refund->id,
                'stripe_refund_id' => $stripeRefund->id,
                'amount' => $stripeRefund->amount / 100,
                'status' => $stripeRefund->status
            ]);
            
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            Log::error('Error de Stripe al crear reembolso', [
                'refund_id' => $refund->id,
                'error' => $e->getMessage(),
                'stripe_error_code' => $e->getStripeCode()
            ]);
            
            // Marcar el reembolso como fallido
            $refund->update([
                'status' => 'failed',
                'notes' => ($refund->notes ?? '') . "\n\nError de Stripe: " . $e->getMessage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error general al crear reembolso en Stripe', [
                'refund_id' => $refund->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Marcar el reembolso como fallido
            $refund->update([
                'status' => 'failed',
                'notes' => ($refund->notes ?? '') . "\n\nError al procesar en Stripe: " . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Mapear las razones del sistema a las razones de Stripe
     */
    private function mapReasonToStripe($reason)
    {
        $mapping = [
            'customer_request' => 'requested_by_customer',
            'duplicate' => 'duplicate',
            'fraudulent' => 'fraudulent',
            'product_issue' => 'requested_by_customer'
        ];
        
        return $mapping[$reason] ?? 'requested_by_customer';
    }
}
