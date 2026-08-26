<?php

namespace App\Services;

use App\Interface\CityServiceInterface;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\RepositoryInterface\CityRepositoryInterface;
class CityService implements CityServiceInterface
{
    /**
     * Create a new class instance.
     */

    private CityRepositoryInterface $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
{
    $this->cityRepository = $cityRepository;
}

    public function getAllCities()
    {
       return  $this->cityRepository->getAllCities();
    }

    public function getActiveCountries()
    {
        return $this->cityRepository->getActiveCountries();

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
         return $this->cityRepository->getActiveStates($countryId);

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
        return $this->cityRepository->createCity($data);

    }

    public function getCity($id)
    {
        return $this->cityRepository->getCity($id);

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

     return $this->cityRepository->updateCity($id, $data);

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
        return $this->cityRepository->deleteCity($id);

    }

    
}
