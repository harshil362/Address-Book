<?php

namespace App\Services;

use App\Interface\AddressBookServiceInterface;
use App\Models\AddressBook;
use App\Models\Country;
use App\Models\state;
use App\Models\City;
use App\Models\Area;

class AddressBookService implements AddressBookServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllAddressBooks()
    {
        return AddressBook::with('country', 'state', 'city', 'area')->get();

    }

    public function getActiveCountries()
    {
        return Country::where('status', 1)->get();
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
        return AddressBook::create([
            'contact_type' => $data['contact_type'],
            'name' => $data['name'],
            'mobile' => $data['mobile_no'],
            'alternate_mobile' => $data['alternate_mobile'],
            'email' => $data['email'],

            'country_id' => $data['country_id'],
            'state_id' => $data['state_id'],
            'city_id' => $data['city_id'],
            'area_id' => $data['area_id'],

            'address1' => $data['address_line_1'],
            'address2' => $data['address_line_2'],
            'landmark' => $data['landmark'],
            'pincode' => $data['pincode'],

            'is_default' => $data['is_default_address'],
            'status' => $data['status'],
        ]);
    }

    public function getAddressBook($id)
    {
        return AddressBook::findOrFail($id);
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
        $addressBook = AddressBook::findOrFail($id);

        $addressBook->update([
            'contact_type' => $data['contact_type'],
            'name' => $data['name'],
            'mobile' => $data['mobile_no'],
            'alternate_mobile' => $data['alternate_mobile'],
            'email' => $data['email'],

            'country_id' => $data['country_id'],
            'state_id' => $data['state_id'],
            'city_id' => $data['city_id'],
            'area_id' => $data['area_id'],

            'address1' => $data['address_line_1'],
            'address2' => $data['address_line_2'],
            'landmark' => $data['landmark'],
            'pincode' => $data['pincode'],

            'is_default' => $data['is_default_address'],

         'status' => $data['status'] ?? $addressBook->status,
         

        ]);

        return $addressBook;
    }

    public function deleteAddressBook($id)
    {
        $addressBook = AddressBook::findOrFail($id);

        return $addressBook->delete();
    }

    public function getStates($countryId)
    {
        return State::where('country_id', $countryId)
            ->where('status', 1)
            ->get();
    }

    public function getCities($stateId)
    {
        return City::where('state_id', $stateId)
            ->where('status', 1)
            ->get();
    }

    public function getAreas($cityId)
    {
        return Area::where('city_id', $cityId)
            ->where('status', 1)
            ->get();
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
