<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterModel extends Model
{
    use HasFactory;

    protected $table = 'mastermodels';

    protected $fillable = [
        'id',
        'name',
    ];

    /**
     * Permissions belonging to this model/module.
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'model_id');
    }
}
