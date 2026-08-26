<?php

namespace App\Repository;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\RepositoryInterface\CityRepositoryInterface;

class CityRepository implements CityRepositoryInterface
{
    /**
     * Create a new class instance.
     */

    public function getAllCities()
    {
        return City::with('state')->get();
    }

     public function getActiveCountries()
    {
        return Country::where('status', 1)->get();
    }

    public function getActiveStates($countryId)
    {
        return State::where('country_id', $countryId)
            ->where('status', 1)
            ->get();
    }
     public function getCity($id)
    {
        return City::findOrFail($id);
    }

     public function createCity($data)
    {
        return City::create([
            'state_id' => $data['state_id'],
            'city' => $data['city'],
            'city_code' => $data['city_code'],
            'status' => 1,
        ]);
    }

    public function updateCity($id, $data)
    {
        $city = City::findOrFail($id);

        $city->update([
            'state_id'  => $data['state_id'],
            'city'      => $data['city'],
            'city_code' => $data['city_code'],
            'status'    => $data['status'] ?? $city->status,
        ]);

        return $city;
    }

    public function deleteCity($id)
    {
        $city = City::findOrFail($id);

        return $city->delete();
    }
}

