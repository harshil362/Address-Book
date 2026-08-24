<?php

namespace App\Services;

use App\Interface\CountryServiceInterface;
use App\RepositoryInterface\CountryRepositoryInterface;
use App\Models\Country;

class CountryService implements CountryServiceInterface
{
    /**
     * Create a new class instance.
     */
  private CountryRepositoryInterface $countryRepository;

public function __construct(CountryRepositoryInterface $countryRepository)
{
    $this->countryRepository = $countryRepository;
}

    public function getAllCountries()
    {
        //return Country::all();
         return $this->countryRepository->getAllCountries();

    }

    public function createCountries($data)
    {
        return $this->countryRepository->createCountries($data);

    }

    public function getcountries($id)
    {
        return $this->countryRepository->getCountry($id);

    }

public function updateCountries($id, $data)
{
     return $this->countryRepository->updateCountries($id, $data);

}


    public function deleteCountry($id)
    {
     return $this->countryRepository->deleteCountry($id);

    }

    public function validateCountry($data)
    {
        return validator($data, [
            'country' => 'required|unique:countries,country',
            'country_code' => 'required|numeric|digits:6|unique:countries,country_code',
        ]);
    }

    public function validateUpdateCountry($id, $data)
{
    return validator($data, [
        'country' => 'required|unique:countries,country,' . $id,
        'country_code' => 'required|numeric|digits:6|unique:countries,country_code,' . $id,
    ]);
}


    public function getToastMessage($action, $status)
    {
        if ($action == 'status') {
            return $status == 1
                ? 'Country status active successfully.'
                : 'Country status inactive successfully.';
        }

        return 'Country updated successfully.';
    }
}
