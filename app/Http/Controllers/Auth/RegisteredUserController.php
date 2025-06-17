<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function createVendor(): View
    {
        if (!auth()->user() || !auth()->user()->roles()->whereIn('id', [2])->exists()) {
            abort(403, 'Unauthorized action.');
        }
        return view('auth.register-vendor');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => ['required', 'in:cliente,vendedor'],
        ]);

        // For vendor registration, check if the current user has permission
        if ($request->user_type === 'vendedor') {
            if (!auth()->user() || !auth()->user()->roles()->whereIn('id', [2])->exists()) {
                abort(403, 'Unauthorized action.');
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the corresponding role by ID
        if ($request->user_type === 'cliente') {
            $user->roles()->attach(1); // Role ID 1 = cliente
        } elseif ($request->user_type === 'vendedor') {
            $user->roles()->attach(2); // Role ID 2 = vendedor
        }

        event(new Registered($user));

        // Only login if it's a client registration
        if ($request->user_type === 'cliente') {
            Auth::login($user);
            return redirect(route('customer.dashboard', absolute: false));
        } else {
            // For vendor registration, redirect back with success message
            return redirect()->route('users.index')->with('success', 'Vendedor registrado exitosamente');
        }
    }
}
