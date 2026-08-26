<?php

namespace App\RepositoryInterface;

interface StateRepositoryInterface
{
    public function getAllStates();

    public function getActiveCountries();

    public function createState($data);

    public function getState($id);

    public function updateState($id, $data);

    public function deleteState($id);

}
