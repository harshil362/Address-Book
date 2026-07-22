<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //

     protected $fillable = [
        'country',
        'country_code',
        'status',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
