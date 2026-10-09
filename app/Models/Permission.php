<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'model_id',
        'module',
        'action',
        'description',
    ];

    /**
     * Relationship to MasterModel (module).
     */
    public function masterModel()
    {
        return $this->belongsTo(MasterModel::class, 'model_id');
    }

    /**
     * Permission belongs to many roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role')
            ->withTimestamps();
    }

    /**
     * Permission belongs to many users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'permission_user')
            ->withTimestamps();
    }

    /**
     * List of the 20 allowed permission names.
     */
    public static function allowedPermissionNames(): array
    {
        return [
            'country-view', 'country-create', 'country-edit', 'country-delete',
            'state-view', 'state-create', 'state-edit', 'state-delete',
            'city-view', 'city-create', 'city-edit', 'city-delete',
            'area-view', 'area-create', 'area-edit', 'area-delete',
            'address-book-view', 'address-book-create', 'address-book-edit', 'address-book-delete', 'address-book-special',
        ];
    }

    /**
     * Ensure modules and only the specified model-based permissions exist in database.
     * Delegates directly to MainModuleSeeder and RolePermissionSeeder.
     */
    public static function ensureDefaultPermissions(): void
    {
        (new \Database\Seeders\MainModuleSeeder())->run();
        (new \Database\Seeders\RolePermissionSeeder())->run();
    }
}