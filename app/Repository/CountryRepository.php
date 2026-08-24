<?php

namespace App\Repository;

use App\RepositoryInterface\CountryRepositoryInterface;
use App\Models\Country;

class CountryRepository implements CountryRepositoryInterface
{
    /**
     * Create a new class instance.
     */

    public function getAllCountries()
    {
        return Country::all();
    }

     public function createCountries($data)
    {
        return Country::create([
            'country' => $data['country'],
            'country_code' => $data['country_code'],
        ]);
    }

    public function getCountry($id)
    {
        return Country::find($id);
    }

    public function updateCountries($id, $data)
    {
        $country = Country::findOrFail($id);

        $country->update([
            'country' => $data['country'],
            'country_code' => $data['country_code'],
            'status' => $data['status'] ?? $country->status,
        ]);

        return $country;
    }

    public function deleteCountry($id)
    {
        $country = Country::find($id);

        return $country->delete();
    }
}
