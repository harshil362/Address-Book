<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            MainModuleSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
        ]);

        $superAdminRole = Role::where('name', 'Super Admin')->first();

        // Ensure default Super Admin account exists and has role
        $admin = User::firstOrCreate(
            ['email' => 'Superadmin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('01230123'),
            ]
        );

        if ($superAdminRole) {
            $admin->roles()->syncWithoutDetaching([$superAdminRole->id]);
        }
    }
}