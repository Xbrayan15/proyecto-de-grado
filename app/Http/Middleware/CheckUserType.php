<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $userType  The required user type ('cliente' or 'vendedor')
     */    public function handle(Request $request, Closure $next, string $userType): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Debug logging
        \Log::info('CheckUserType Middleware', [
            'user_id' => $user->id,
            'requested_type' => $userType,
            'user_roles' => $user->roles->pluck('id')->toArray(),
            'route' => $request->path()
        ]);

        // Check if user has vendedor role (ID 2) - they can access everything
        $hasVendedorAccess = $user->roles()->whereIn('id', [2])->exists();

        if ($hasVendedorAccess) {
            \Log::info('User has vendedor access, allowing through');
            return $next($request);
        }

        // For cliente-only routes, check if user has cliente role (ID 1)
        $hasClienteAccess = $user->roles()->whereIn('id', [1])->exists();

        \Log::info('Client access check', [
            'userType' => $userType,
            'hasClienteAccess' => $hasClienteAccess,
            'condition_met' => ($userType === 'cliente' && $hasClienteAccess)
        ]);

        if ($userType === 'cliente' && $hasClienteAccess) {
            \Log::info('User has cliente access, allowing through');
            return $next($request);
        }

        // If user doesn't have access, redirect with error
        \Log::warning('User access denied', [
            'user_id' => $user->id,
            'requested_type' => $userType,
            'hasClienteAccess' => $hasClienteAccess,
            'hasVendedorAccess' => $hasVendedorAccess
        ]);

        if ($hasClienteAccess) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return redirect()->route('dashboard')
            ->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}
