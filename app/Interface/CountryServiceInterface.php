<?php

namespace App\Interface;

interface CountryServiceInterface 
{
    /**
     * Create a new class instance.
     */
    
    public function getAllCountries();

    public function createCountries($data);

    public function getCountries($id);

    public function updateCountries($id,$data);

    public function deleteCountry($id);

    public function validateCountry($data);

    public function validateUpdateCountry($id,$data);

    public function getToastMessage($action, $status);

    

}

