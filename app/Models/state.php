<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    //

    protected $fillable = [
        'country_id',
        'state',
        'state_code',
        'status',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
