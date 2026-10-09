<?php

namespace App\Http\Controllers;

use App\Models\MasterModel;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RoleAssignmentController extends Controller
{
    /**
     * Check if current user is allowed to manage roles/permissions.
     */
    protected function checkAdminAuthorization()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || (!$user->isSuperAdmin() && !$user->isAdmin())) {
            abort(403, 'Only Super Admin and Admin can assign roles and permissions.');
        }
    }

    /**
     * Display users and role assignments list.
     */
    public function index()
    {
        $this->checkAdminAuthorization();

        $users = User::with(['roles.permissions', 'permissions'])->get();

        // Allowed assignable roles: all active roles except Super Admin
        $roles = Role::where('name', '!=', 'Super Admin')
            ->where('status', true)
            ->withCount('permissions')
            ->get();

        return view('role-assignments.index', compact('users', 'roles'));
    }

    /**
     * Quick role assignment for existing user.
     */
    public function store(Request $request)
    {
        $this->checkAdminAuthorization();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->isSuperAdmin()) {
            return redirect()
                ->route('role-assignments.index')
                ->with('error', 'Super Admin account is static and cannot be modified.');
        }

        $role = Role::findOrFail($request->role_id);

        if ($role->name === 'Super Admin') {
            return redirect()
                ->route('role-assignments.index')
                ->with('error', 'Super Admin role is static and cannot be manually assigned.');
        }

        $user->roles()->sync([$role->id]);

        return redirect()
            ->route('role-assignments.index')
            ->with('success', "Role '{$role->name}' assigned to '{$user->name}' successfully.");
    }

    /**
     * Show form to create user with role and permissions.
     */
    public function create()
    {
        $this->checkAdminAuthorization();

        Permission::ensureDefaultPermissions();

        $roles = Role::where('name', '!=', 'Super Admin')
            ->where('status', true)
            ->get();

        $modules = MasterModel::with(['permissions' => function ($query) {
            $query->orderByRaw("FIELD(action, 'view', 'create', 'edit', 'delete')");
        }])->whereIn('id', [1, 2, 3, 4, 5])->orderBy('id')->get();

        return view('role-assignments.create', compact('roles', 'modules'));
    }

    /**
     * Store new user with assigned role and optional direct permissions.
     */
    public function storeUser(Request $request)
    {
        $this->checkAdminAuthorization();

        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role_id);

        if ($role->name === 'Super Admin') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Super Admin role cannot be manually assigned.');
        }

        $user = User::create([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->sync([$role->id]);

        $user->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('role-assignments.index')
            ->with('success', "User '{$user->name}' created successfully with role '{$role->name}'.");
    }

    /**
     * Show form to edit user role and permissions.
     */
    public function edit(User $user)
    {
        $this->checkAdminAuthorization();

        if ($user->isSuperAdmin()) {
            return redirect()
                ->route('role-assignments.index')
                ->with('error', 'Super Admin account is static and cannot be modified.');
        }

        Permission::ensureDefaultPermissions();

        $roles = Role::where('name', '!=', 'Super Admin')
            ->where('status', true)
            ->get();

        $modules = MasterModel::with(['permissions' => function ($query) {
            $query->orderByRaw("FIELD(action, 'view', 'create', 'edit', 'delete')");
        }])->whereIn('id', [1, 2, 3, 4, 5])->orderBy('id')->get();

        $currentRoleId = $user->roles->first()?->id;
        $selectedPermissions = $user->allPermissions()->pluck('id')->toArray();

        return view('role-assignments.edit', compact(
            'user',
            'roles',
            'modules',
            'currentRoleId',
            'selectedPermissions'
        ));
    }

    /**
     * Update user role and permissions.
     */
    public function updateUser(Request $request, User $user)
    {
        $this->checkAdminAuthorization();

        if ($user->isSuperAdmin()) {
            return redirect()
                ->route('role-assignments.index')
                ->with('error', 'Super Admin account cannot be modified.');
        }

        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role_id);

        if ($role->name === 'Super Admin') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Super Admin role cannot be manually assigned.');
        }

        $user->name = trim($request->name);
        $user->email = strtolower(trim($request->email));

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $user->roles()->sync([$role->id]);

        $user->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('role-assignments.index')
            ->with('success', "User '{$user->name}' updated successfully.");
    }

    /**
     * Delete user account.
     */
    public function destroy(User $user)
    {
        $this->checkAdminAuthorization();

        if ($user->isSuperAdmin()) {
            return redirect()
                ->route('role-assignments.index')
                ->with('error', 'Super Admin account is static and cannot be deleted.');
        }

        $name = $user->name;
        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();

        return redirect()
            ->route('role-assignments.index')
            ->with('success', "User '{$name}' deleted successfully.");
    }
}
