<?php

namespace App\Repository;

use App\RepositoryInterface\AddressBookRepositoryInterface;
use App\Models\AddressBook;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Area;

class AddressBookRepository implements AddressBookRepositoryInterface
{
    /**
     * Create a new class instance.
     */

    public function getAllAddressBooks()
    {

        return AddressBook::with('country', 'state', 'city', 'area')->get();
    }

    public function getActiveCountries()
    {
        return Country::where('status', 1)->get();
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
}
