<?php

namespace App\Repository;

use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\AddressBook;

use App\RepositoryInterface\AreaRepositoryInterface;

class AreaRepository implements AreaRepositoryInterface
{
    /**
     * Create a new class instance.
     */
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

    public function  getStatesByCountry($countryId)
    {
        return State::where('country_id', $countryId)
            ->where('status', 1)
            ->get();
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

    public function deleteArea($id)
    {
        $area = Area::findOrFail($id);

        return $area->delete();
    }
}
