<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignRoleToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-role-by-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign roles to users based on their user_type';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        
        foreach ($users as $user) {
            // Remove existing roles
            $user->roles()->detach();
            
            // Assign role based on user_type
            if ($user->user_type === 'cliente') {
                $user->roles()->attach(1); // Role ID 1 = cliente
                $this->info("Assigned cliente role to {$user->email}");
            } elseif ($user->user_type === 'vendedor') {
                $user->roles()->attach(2); // Role ID 2 = vendedor
                $this->info("Assigned vendedor role to {$user->email}");
            } else {
                // Default to cliente if no user_type is set
                $user->update(['user_type' => 'cliente']);
                $user->roles()->attach(1);
                $this->info("Set {$user->email} as cliente (default)");
            }
        }
        
        $this->info('Role assignment completed!');
        return 0;
    }
}
