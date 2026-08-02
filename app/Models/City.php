<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
     protected $fillable = [
        'state_id',
        'city',
        'city_code',
        'status',
    ];

    // A City belongs to one State
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    // A City has many Areas
    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
