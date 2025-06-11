<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */    public function run(): void
    {
        // Create Cliente role with ID 1
        Role::firstOrCreate([
            'id' => 1
        ], [
            'name' => 'cliente',
            'description' => 'Cliente que puede comprar productos',
            'is_system' => true
        ]);

        // Create Vendedor role with ID 2
        Role::firstOrCreate([
            'id' => 2
        ], [
            'name' => 'vendedor',
            'description' => 'Vendedor con acceso al panel administrativo',
            'is_system' => true
        ]);

        // Create additional admin roles
        Role::firstOrCreate([
            'name' => 'admin'
        ], [
            'description' => 'Administrador con acceso completo',
            'is_system' => true
        ]);

        Role::firstOrCreate([
            'name' => 'manager'
        ], [
            'description' => 'Gerente con permisos de gestión',
            'is_system' => true
        ]);

        Role::firstOrCreate([
            'name' => 'employee'
        ], [
            'description' => 'Empleado con permisos básicos de administración',
            'is_system' => true
        ]);
    }
}
