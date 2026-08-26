<?php

namespace App\RepositoryInterface;

interface AddressBookRepositoryInterface
{
    public function getAllAddressBooks();

    public function getActiveCountries();

    public function createAddressBook($data);

    public function getAddressBook($id);

    public function updateAddressBook($id, $data);

    public function deleteAddressBook($id);

    public function getStates($countryId);

    public function getCities($stateId);

    public function getAreas($cityId);
}
