<?php

namespace App\Interface;

interface AreaServiceInterface
{
    /**
     * Create a new class instance.
     */

    public function getAllAreas();

    public function getActiveCountries();

    public function getStatesAndCities($countryId, $stateId);

    public function validateStoreArea($data);

    public function createArea($data);

    public function getArea($id);

    public function getCountryId($area, $countryId);

    public function getStatesByCountry($countryId);

    public function getStateId($area, $stateId, $countryChanged);

    public function getCitiesByState($stateId);

    public function validateUpdateArea($id, $data);

    public function updateArea($id, $data);

    public function getToastMessage($action, $status);

    public function deleteArea($id);
}
