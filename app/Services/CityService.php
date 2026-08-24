<?php

namespace App\Services;

use App\Interface\CityServiceInterface;
use App\Models\City;
use App\Models\Country;
use App\Models\State;

class CityService implements CityServiceInterface
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

    public function getCountryId($city, $countryId)
    {
        if ($countryId) {
            return $countryId;
        } else {
            return $city->state->country_id;
        }
    }
    public function getActiveStates($countryId)
    {
        return State::where('country_id', $countryId)
            ->where('status', 1)
            ->get();
    }

    public function validateStoreCity($data)
    {
        return validator($data, [
            'country_id' => [
                'required',

                function ($attribute, $value, $fail) {
                    if (!Country::where('id', $value)
                        ->where('status', 1)
                        ->exists()) {

                        $fail('The selected country is invalid or inactive.');
                    }
                },

            ],

            'state_id' => [
                'required',

                function ($attribute, $value, $fail) use ($data) {
                    if (!State::where('id', $value)
                        ->where('status', 1)
                        ->where('country_id', $data['country_id'])
                        ->exists()) {
                        $fail('The selected state is invalid or inactive.');
                    }
                },
            ],
            'city' => 'required|unique:cities,city',
            'city_code' => 'required|numeric|digits:6|unique:cities,city_code',
        ]);
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

    public function getCity($id)
    {
        return City::findOrFail($id);
    }

    public function validateUpdateCity($data, $id)
    {
        return validator($data, [
            'country_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Country::where('id', $value)->exists()) {
                        $fail('The selected country is invalid.');
                    }
                },
            ],
            'state_id'   => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    if (
                        !State::where('id', $value)
                            ->where('country_id', $data['country_id'])
                            ->exists()
                    ) {
                        $fail('The selected state is invalid.');
                    }
                },

            ],
            'city'       => 'required|unique:cities,city,' . $id,
            'city_code'  => 'required|numeric|digits:6|unique:cities,city_code,' . $id,
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


    public function getToastMessage($action, $status)
    {
        if ($action == 'status') {
            return $status == 1
                ? 'City Status Active Successfully.'
                : 'City status inactive successfully.';
        }

        return 'City updated successfully.';
    }

    public function deleteCity($id)
    {
        $city = City::findOrFail($id);

        $city->delete();
    }
}
