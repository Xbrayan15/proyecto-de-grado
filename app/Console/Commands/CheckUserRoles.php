<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;

class CheckUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:check-roles {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check user roles and assign cliente role if none';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        $this->info("User: {$user->name} ({$user->email})");
        $this->info("User Type: {$user->user_type}");
        
        $roles = $user->roles;
        
        if ($roles->isEmpty()) {
            $this->warn("User has no roles assigned.");
            
            // Assign cliente role (ID 1)
            $clienteRole = Role::find(1);
            if ($clienteRole) {
                $user->roles()->attach(1);
                $this->info("Assigned 'cliente' role (ID: 1) to user.");
            } else {
                $this->error("Role with ID 1 not found. Please run the seeder first.");
                return 1;
            }
        } else {
            $this->info("User has the following roles:");
            foreach ($roles as $role) {
                $this->line("- ID: {$role->id}, Name: {$role->name}");
            }
        }

        return 0;
    }
}
