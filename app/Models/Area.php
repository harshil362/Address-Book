<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $fillable = [
        'city_id',
        'area',
        'pincode',
        'status',
    ];

    // An Area belongs to one City
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // An Area has many Address Books
    public function addressBooks()
    {
        return $this->hasMany(AddressBook::class);
    }
}
