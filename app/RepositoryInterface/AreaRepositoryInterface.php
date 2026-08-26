<?php

namespace App\RepositoryInterface;

interface AreaRepositoryInterface
{
    public function getAllAreas();

    public function getActiveCountries();

    public function getStatesAndCities($countryId, $stateId);

    public function createArea($data);

    public function getArea($id);

    public function getStatesByCountry($countryId);

    public function getCitiesByState($stateId);

    public function updateArea($id, $data);

    public function deleteArea($id);

}
