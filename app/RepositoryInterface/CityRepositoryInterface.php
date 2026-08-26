<?php

namespace App\RepositoryInterface;

interface CityRepositoryInterface
{
    public function getAllCities();

    public function getActiveCountries();

    public function getActiveStates($countryId);

    public function getCity($id);

     public function createCity($data);

    public function updateCity($id, $data);

    public function deleteCity($id);

}
