<?php

namespace App\Listeners;

use App\Models\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserCart
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        $user = $event->user;
        
        // Ensure the user has exactly one active cart
        $user->ensureSingleActiveCart();
    }
}
