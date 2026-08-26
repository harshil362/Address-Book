<?php

namespace App\Services;

use App\Interface\AreaServiceInterface;
use App\Models\Area;
use App\Models\City;
use App\Models\state;
use App\Models\Country;
use App\Models\AddressBook;
use App\RepositoryInterface\AreaRepositoryInterface;
class AreaService implements AreaServiceInterface
{
    /**
     * Create a new class instance.
     */
   
    private AreaRepositoryInterface $areaRepository;

    public function __construct(AreaRepositoryInterface $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    public function getAllAreas()
    {

        //return Area::with('city.state.country')->get();
        return $this->areaRepository->getAllAreas();
    }


    public function getActiveCountries()
    {
        return $this->areaRepository->getActiveCountries();

    }

    public function getStatesAndCities($countryId, $stateId)
    {
        return $this->areaRepository->getStatesAndCities($countryId, $stateId);

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
         return $this->areaRepository->createArea($data);
    }


    public function getArea($id)
    {
        return $this->areaRepository->getArea($id);

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
        return $this->areaRepository->getStatesByCountry($countryId);
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
        return $this->areaRepository->getCitiesByState($stateId);
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
        return $this->areaRepository->updateArea($id,$data);
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
        return $this->areaRepository->deleteArea($id);
    }
    
}
