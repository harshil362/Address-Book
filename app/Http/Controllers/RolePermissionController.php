<?php

namespace App\Http\Controllers;

use App\Models\MasterModel;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display listing of roles and module permissions.
     */
    public function index()
    {
        Permission::ensureDefaultPermissions();

        $roles = Role::where('status', true)->withCount('permissions', 'users')->get();

        return view('role-permissions.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role with module permissions.
     */
    public function create()
    {
        Permission::ensureDefaultPermissions();

        $allowedNames = Permission::allowedPermissionNames();

        $modules = MasterModel::with(['permissions' => function ($query) use ($allowedNames) {
            $query->whereIn('name', $allowedNames)
                  ->orderByRaw("FIELD(action, 'view', 'create', 'edit', 'delete')");
        }])->whereIn('id', [1, 2, 3, 4, 5])->orderBy('id')->get();

        return view('role-permissions.create', compact('modules'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => trim($request->name),
            'description' => $request->description,
            'status' => (bool) $request->status,
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('role-permissions.index')
            ->with('success', "Role '{$role->name}' created successfully with configured module permissions.");
    }

    /**
     * Show the form for editing an existing role.
     */
    public function edit(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()
                ->route('role-permissions.index')
                ->with('error', 'Super Admin is static and cannot be modified.');
        }

        Permission::ensureDefaultPermissions();

        $allowedNames = Permission::allowedPermissionNames();

        $modules = MasterModel::with(['permissions' => function ($query) use ($allowedNames) {
            $query->whereIn('name', $allowedNames)
                  ->orderByRaw("FIELD(action, 'view', 'create', 'edit', 'delete')");
        }])->whereIn('id', [1, 2, 3, 4, 5])->orderBy('id')->get();

        $selectedPermissions = $role->permissions->pluck('id')->toArray();

        return view('role-permissions.edit', compact(
            'role',
            'modules',
            'selectedPermissions'
        ));
    }

    /**
     * Update an existing role and its permissions.
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()
                ->route('role-permissions.index')
                ->with('error', 'Super Admin role is static and cannot be modified.');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name' => trim($request->name),
            'description' => $request->description,
            'status' => (bool) $request->status,
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('role-permissions.index')
            ->with('success', "Role '{$role->name}' updated successfully.");
    }

    /**
     * Delete an existing role.
     */
    public function destroy(Role $role)
    {
        if (in_array($role->name, ['Super Admin', 'Admin', 'User'])) {
            return redirect()
                ->route('role-permissions.index')
                ->with('error', "Default system role '{$role->name}' cannot be deleted.");
        }

        $roleName = $role->name;
        $role->permissions()->detach();
        $role->users()->detach();
        $role->delete();

        return redirect()
            ->route('role-permissions.index')
            ->with('success', "Role '{$roleName}' deleted successfully.");
    }
}