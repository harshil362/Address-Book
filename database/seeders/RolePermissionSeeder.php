<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure model_id column exists on permissions table
        if (Schema::hasTable('permissions') && !Schema::hasColumn('permissions', 'model_id')) {
            Schema::table('permissions', function ($table) {
                $table->unsignedBigInteger('model_id')->nullable()->after('name');
            });
        }

        $permissions = [
            // country Management (model 1)
            ['name' => 'country-view', 'model_id' => 1],
            ['name' => 'country-create', 'model_id' => 1],
            ['name' => 'country-edit', 'model_id' => 1],
            ['name' => 'country-delete', 'model_id' => 1],

            // state Management (model 2)
            ['name' => 'state-view', 'model_id' => 2],
            ['name' => 'state-create', 'model_id' => 2],
            ['name' => 'state-edit', 'model_id' => 2],
            ['name' => 'state-delete', 'model_id' => 2],

            // city Management (model 3)
            ['name' => 'city-view', 'model_id' => 3],
            ['name' => 'city-create', 'model_id' => 3],
            ['name' => 'city-edit', 'model_id' => 3],
            ['name' => 'city-delete', 'model_id' => 3],

            // area Management (model 4)
            ['name' => 'area-view', 'model_id' => 4],
            ['name' => 'area-create', 'model_id' => 4],
            ['name' => 'area-edit', 'model_id' => 4],
            ['name' => 'area-delete', 'model_id' => 4],

            // address book Management (model 5)
            ['name' => 'address-book-view', 'model_id' => 5],
            ['name' => 'address-book-create', 'model_id' => 5],
            ['name' => 'address-book-edit', 'model_id' => 5],
            ['name' => 'address-book-delete', 'model_id' => 5],
            ['name' => 'address-book-special', 'model_id' => 5],
        ];

        $allowedNames = array_column($permissions, 'name');

        // Delete any extra / legacy permissions not in the allowed list
        $extraPermissionIds = DB::table('permissions')
            ->whereNotIn('name', $allowedNames)
            ->pluck('id')
            ->toArray();

        if (!empty($extraPermissionIds)) {
            DB::table('permission_role')->whereIn('permission_id', $extraPermissionIds)->delete();
            if (Schema::hasTable('permission_user')) {
                DB::table('permission_user')->whereIn('permission_id', $extraPermissionIds)->delete();
            }
            DB::table('permissions')->whereIn('id', $extraPermissionIds)->delete();
        }

        // Insert or update permissions
        foreach ($permissions as $permission) {
            $parts = explode('-', $permission['name']);
            $action = end($parts);
            $moduleSlug = str_replace("-{$action}", '', $permission['name']);

            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']],
                [
                    'model_id' => $permission['model_id'],
                    'module' => $moduleSlug,
                    'action' => $action,
                    'description' => ucfirst(str_replace('-', ' ', $permission['name'])) . ' Permission',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // Super Admin gets all permissions
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->permissions()->sync(
                Permission::pluck('id')->toArray()
            );
        }

        // Admin gets all 20 permissions
        $admin = Role::where('name', 'Admin')->first();
        if ($admin) {
            $admin->permissions()->sync(
                Permission::pluck('id')->toArray()
            );
        }

        // User gets all view permissions by default
        $userRole = Role::where('name', 'User')->first();
        if ($userRole) {
            $viewPermissions = Permission::where('action', 'view')->pluck('id')->toArray();
            $userRole->permissions()->sync($viewPermissions);
        }
    }
}