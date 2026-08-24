<?php

namespace App\Interface;

interface CityServiceInterface
{
    /**
     * Create a new class instance.
     */
    
    public function getAllCities();

    public function getActiveCountries();

    public function getActiveStates($countryId);
  
    public function getCountryId($city, $countryId);
    public function validateStoreCity($data);

    public function createCity($data);

    public function getCity($id);

    public function validateUpdateCity($data,$id);

    public function updateCity($id,$data);

    public function getToastMessage($action, $status);

    public function deleteCity($id);
    
}
