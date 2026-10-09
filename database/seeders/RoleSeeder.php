<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'description' => 'Full system access',
                'status' => true,
            ],
            [
                'name' => 'Admin',
                'description' => 'Administrative access based on assigned permissions',
                'status' => true,
            ],
            [
                'name' => 'User',
                'description' => 'Regular user access based on assigned permissions',
                'status' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
        
    }
}