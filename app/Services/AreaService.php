<?php

namespace App\Services;

use App\Interface\AreaServiceInterface;
use App\Models\Area;
use App\Models\City;
use App\Models\state;
use App\Models\Country;
use App\Models\AddressBook;

class AreaService implements AreaServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllAreas()
    {

        return Area::with('city.state.country')->get();
    }


    public function getActiveCountries()
    {
        return Country::where('status', 1)->get();
    }

    public function getStatesAndCities($countryId, $stateId)
    {
        $states = collect();
        $cities = collect();

        if ($countryId) {
            $states = State::where('country_id', $countryId)
                ->where('status', 1)
                ->whereHas('country', function ($q) {
                    $q->where('status', 1);
                })
                ->get();
        }

        if ($stateId) {
            $cities = City::where('state_id', $stateId)
                ->where('status', 1)
                ->whereHas('state', function ($q) {
                    $q->where('status', 1)
                        ->whereHas('country', function ($q2) {
                            $q2->where('status', 1);
                        });
                })
                ->get();
        }

        return [
            'states' => $states,
            'cities' => $cities,
        ];
    }

    public function validateStoreArea($data)
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

            'city_id' => [
                'required',

                function ($attribute, $value, $fail) use ($data) {
                    if (!City::where('id', $value)
                        ->where('status', 1)
                        ->where('state_id', $data['state_id'])
                        ->exists()) {

                        $fail('The selected city is invalid or inactive.');
                    }
                },
            ],

            'area' => 'required|unique:areas,area',

            'pincode' => 'required|numeric|digits:6|unique:areas,pincode',
        ]);
    }

    public function createArea($data)
    {
        return Area::create([
            'city_id' => $data['city_id'],
            'area' => $data['area'],
            'pincode' => $data['pincode'],
            'status' => 1,
        ]);
    }

    public function getArea($id)
    {
        return Area::findOrFail($id);
    }


    public function getCountryId($area, $countryId)
    {
        if ($countryId) {
            return $countryId;
        }

        return $area->city->state->country_id;
    }

    public function getStatesByCountry($countryId)
    {
        return State::where('country_id', $countryId)
            ->where('status', 1)
            ->get();
    }

    public function getStateId($area, $stateId, $countryChanged)
    {
        if (!$stateId && !$countryChanged) {
            return $area->city->state_id;
        }

        return $stateId;
    }

    public function getCitiesByState($stateId)
    {
        if ($stateId) {
            return City::where('state_id', $stateId)
                ->where('status', 1)
                ->get();
        }

        return collect();
    }

    public function validateUpdateArea($id, $data)
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

            'state_id' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    if (!State::where('id', $value)
                        ->where('country_id', $data['country_id'])
                        ->exists()) {

                        $fail('The selected state is invalid.');
                    }
                },
            ],

            'city_id' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    if (!City::where('id', $value)
                        ->where('state_id', $data['state_id'])
                        ->exists()) {

                        $fail('The selected city is invalid.');
                    }
                },
            ],

            'area' => 'required|unique:areas,area,' . $id,

            'pincode' => 'required|numeric|digits:6|unique:areas,pincode,' . $id,
        ]);
    }

    public function updateArea($id, $data)
    {
        $area = Area::findOrFail($id);

        $area->update([
            'city_id' => $data['city_id'],
            'area' => $data['area'],
            'pincode' => $data['pincode'],
            'status' => $data['status'] ?? $area->status,
        ]);

        AddressBook::where('area_id', $area->id)
            ->update([
                'pincode' => $data['pincode'],
            ]);

        return $area;
    }

    public function getToastMessage($action, $status)
    {
        if ($action == 'status') {
            return $status == 1
                ? 'Area Status Active Successfully.'
                : 'Area status inactive successfully.';
        }

        return 'Area updated successfully.';
    }

    public function deleteArea($id)
    {
        $area = Area::findOrFail($id);

        return $area->delete();
    }
}
