<?php

namespace App\Interface;

interface AddressBookServiceInterface
{
    /**
     * Create a new class instance.
     */

    public function getAllAddressBooks();

    public function getActiveCountries();

    public function validateStoreAddressBook($data);

    public function createAddressBook($data);
    public function getAddressBook($id);

    public function validateUpdateAddressBook($data);

    public function updateAddressBook($id, $data);


    public function deleteAddressBook($id);

    public function getStates($countryId);
    public function getCities($stateId);
    
    public function getAreas($cityId);

    public function getToastMessage($action, $status);

}
