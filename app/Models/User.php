<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Permission;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User belongs to many roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withTimestamps();
    }

    /**
     * User has direct permissions.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user')
            ->withTimestamps();
    }

    public function hasRole(string $role): bool
    {
        if ($this->relationLoaded('roles')) {
            return $this->roles->contains('name', $role);
        }

        return $this->roles()
            ->where('name', $role)
            ->exists();
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('Super Admin') || strtolower($this->email) === 'superadmin@admin.com';
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isRegularUser(): bool
    {
        return $this->hasRole('User') || (!$this->isSuperAdmin() && !$this->isAdmin());
    }

    public function hasPermission(string $permission): bool
    {
        // 1. Super Admin has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        // 2. Admin can access role assignment / permission management
        if (str_starts_with($permission, 'role_assignment.') && $this->isAdmin()) {
            return true;
        }

        $variants = array_unique([
            $permission,
            str_replace('.', '-', $permission),
            str_replace(['.', '_'], ['-', '-'], $permission),
            str_replace('-', '.', $permission),
            str_replace(['-', '_'], ['.', '.'], $permission),
        ]);

        // 3. Direct user permissions
        if ($this->relationLoaded('permissions')) {
            if ($this->permissions->whereIn('name', $variants)->isNotEmpty()) {
                return true;
            }
        } else {
            if ($this->permissions()->whereIn('name', $variants)->exists()) {
                return true;
            }
        }

        // 4. Inherited via assigned roles
        if ($this->relationLoaded('roles')) {
            foreach ($this->roles as $role) {
                if ($role->relationLoaded('permissions')) {
                    if ($role->permissions->whereIn('name', $variants)->isNotEmpty()) {
                        return true;
                    }
                } else {
                    if ($role->permissions()->whereIn('name', $variants)->exists()) {
                        return true;
                    }
                }
            }
        } else {
            if ($this->roles()->whereHas('permissions', fn($q) => $q->whereIn('name', $variants))->exists()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all unique permissions (direct + role inherited).
     */
    public function allPermissions()
    {
        if ($this->isSuperAdmin()) {
            return Permission::all();
        }

        $perms = collect();

        // Direct
        $directPermissions = $this->relationLoaded('permissions') 
            ? $this->permissions 
            : $this->permissions()->get();
        $perms = $perms->merge($directPermissions);

        // Roles
        $roles = $this->relationLoaded('roles') ? $this->roles : $this->roles()->with('permissions')->get();
        foreach ($roles as $role) {
            $rolePerms = $role->relationLoaded('permissions') ? $role->permissions : $role->permissions()->get();
            $perms = $perms->merge($rolePerms);
        }

        return $perms->unique('id');
    }
}
