<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }    /**
     * Handle an incoming authentication request.
     */    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the user type from the request
        $userType = $request->input('user_type');
        $user = Auth::user();

        // Update user's preferred type if it's different from stored type
        if ($userType && $user->user_type !== $userType) {
            // Only update if user doesn't have a type set, or if they're changing from cliente to vendedor
            // and they have the necessary permissions
            if (!$user->user_type || 
                ($userType === 'vendedor' && $user->roles()->whereIn('name', ['admin', 'manager', 'employee'])->exists()) ||
                ($userType === 'cliente')) {
                $user->update(['user_type' => $userType]);
            }
        }

        // Determine redirect route based on user type and roles
        $redirectRoute = $this->getRedirectRoute($user, $userType);

        return redirect()->intended($redirectRoute);
    }/**
     * Determine the appropriate redirect route based on user type and roles
     */    private function getRedirectRoute($user, $userType): string
    {
        // If user has admin/manager/employee roles, always go to admin dashboard
        if ($user->isAdmin()) {
            return route('dashboard');
        }

        // For regular users, redirect based on selected type and stored preference
        switch ($userType) {
            case 'vendedor':
                // Check if user actually has vendor permissions or is set as vendor
                if ($user->isVendor() || $user->roles()->whereIn('name', ['employee', 'manager', 'admin'])->exists()) {
                    return route('dashboard');
                } else {
                    // If user doesn't have vendor permissions, redirect to customer area with message
                    session()->flash('warning', 'No tienes permisos de vendedor. Accediendo como cliente.');
                    return route('customer.dashboard');
                }
                
            case 'cliente':
            default:
                return route('customer.dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
