<?php

namespace App\Services;

use App\Interface\AddressBookServiceInterface;
use App\Models\AddressBook;
use App\Models\Country;
use App\Models\state;
use App\Models\City;
use App\Models\Area;
use App\RepositoryInterface\AddressBookRepositoryInterface;

class AddressBookService implements AddressBookServiceInterface
{
    /**
     * Create a new class instance.
     */
    private AddressBookRepositoryInterface $addressBookRepository;

    public function __construct(AddressBookRepositoryInterface $addressBookRepository)
    {
        $this->addressBookRepository = $addressBookRepository;
    }

    public function getAllAddressBooks()
    {
        return $this->addressBookRepository->getAllAddressBooks();
    }

    public function getActiveCountries()
    {
        return $this->addressBookRepository->getActiveCountries();
    }

    public function validateStoreAddressBook($data)
    {
        return validator($data, [

            'contact_type' => 'required',
            'name' => 'required',
            'mobile_no' => 'required|numeric|digits:10',
            'alternate_mobile' => 'nullable|digits:10',
            'email' => 'nullable|email',

            'country_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Country::where('id', $value)
                        ->where('status', 1)
                        ->exists()) {

                        $fail('The selected country is invalid or inactive.');
                    }
                },
            ],

            'state_id' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    if (!State::where('id', $value)
                        ->where('status', 1)
                        ->where('country_id', $data['country_id'])
                        ->exists()) {

                        $fail('The selected state is invalid or inactive.');
                    }
                },
            ],

            'city_id' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    if (!City::where('id', $value)
                        ->where('status', 1)
                        ->where('state_id', $data['state_id'])
                        ->exists()) {

                        $fail('The selected city is invalid or inactive.');
                    }
                },
            ],

            'area_id' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    if (!Area::where('id', $value)
                        ->where('status', 1)
                        ->where('city_id', $data['city_id'])
                        ->exists()) {

                        $fail('The selected area is invalid or inactive.');
                    }
                },
            ],

            'address_line_1' => 'required',
            'address_line_2' => 'nullable',
            'landmark' => 'nullable',
            'pincode' => 'required',
            'is_default_address' => 'required',
            'status' => 'required',
        ]);
    }

    public function createAddressBook($data)
    {
        return $this->addressBookRepository->createAddressBook($data);
    }

    public function getAddressBook($id)
    {
        return $this->addressBookRepository->getAddressBook($id);
    }

    public function validateUpdateAddressBook($data)
    {
        return validator($data, [

            'contact_type' => 'required',
            'name' => 'required',
            'mobile_no' => 'required|numeric|digits:10',
            'alternate_mobile' => 'nullable|digits:10',
            'email' => 'nullable|email',

            'country_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Country::where('id', $value)
                        ->where('status', 1)
                        ->exists()) {

                        $fail('The selected country is invalid or inactive.');
                    }
                },
            ],

            'state_id' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    if (!State::where('id', $value)
                        ->where('status', 1)
                        ->where('country_id', $data['country_id'])
                        ->exists()) {

                        $fail('The selected state is invalid or inactive.');
                    }
                },
            ],

            'city_id' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    if (!City::where('id', $value)
                        ->where('status', 1)
                        ->where('state_id', $data['state_id'])
                        ->exists()) {

                        $fail('The selected city is invalid or inactive.');
                    }
                },
            ],

            'area_id' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    if (!Area::where('id', $value)
                        ->where('status', 1)
                        ->where('city_id', $data['city_id'])
                        ->exists()) {

                        $fail('The selected area is invalid or inactive.');
                    }
                },
            ],

            'address_line_1' => 'required',
            'address_line_2' => 'nullable',
            'landmark' => 'nullable',
            'pincode' => 'required',
            'is_default_address' => 'required',
        ]);
    }


    public function updateAddressBook($id, $data)
    {
        return $this->addressBookRepository->updateAddressBook($id, $data);
    }

    public function deleteAddressBook($id)
    {
        return $this->addressBookRepository->deleteAddressBook($id);
    }

    public function getStates($countryId)
    {
        return $this->addressBookRepository->getStates($countryId);
    }

    public function getCities($stateId)
    {
        return $this->addressBookRepository->getCities($stateId);
    }

    public function getAreas($cityId)
    {
        return $this->addressBookRepository->getAreas($cityId);
    }

    public function getToastMessage($action, $status)
    {
        if ($action == 'status') {
            return $status == 1
                ? 'Address Book Status Active Successfully.'
                : 'Address Book inactive successfully.';
        }

        return 'Address Book updated successfully.';
    }
}
