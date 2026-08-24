<?php

namespace App\RepositoryInterface;

interface CountryRepositoryInterface
{
    public function getAllCountries();

    public function createCountries($data);

    public function getCountry($id);

    public function updateCountries($id, $data);

    public function deleteCountry($id);


}
