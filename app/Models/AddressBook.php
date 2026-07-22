<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    //

    protected $fillable = [
        'contact_type',
        'name',
        'mobile',
        'alternate_mobile',
        'email',
        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'address1',
        'address2',
        'landmark',
        'pincode',
        'is_default',
        'status',
    ];

    // Address Book belongs to Country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Address Book belongs to State
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    // Address Book belongs to City
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // Address Book belongs to Area
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
