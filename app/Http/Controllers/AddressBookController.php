<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Area;


class AddressBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addressbooks = AddressBook::with('country', 'state', 'city', 'area')->get();

        return view('addressbooks.index', compact('addressbooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $countries = Country::where('status', 1)->get();

        return view('addressbooks.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contact_type'       => 'required',
            'name'               => 'required',
            'mobile_no'          => 'required|numeric|digits:10',
            'alternate_mobile'   => 'nullable|digits:10',
            'email'              => 'nullable|email',

            'country_id'         => [
                'required',
                // Rule::exists('countries', 'id')->where('status', 1),
                function ($attribute, $value, $fail) {
                    if (!Country::where('id', $value)->where('status', 1)->exists()) {
                        $fail('The selected country is invalid or inactive.');
                    }
                },
            ],
            'state_id'           => [
                'required',
                // Rule::exists('states', 'id')
                //     ->where('status', 1)
                //     ->where('country_id', $request->country_id),
                function ($attribute, $value, $fail) use ($request) {
                    if (!State::where('id', $value)
                        ->where('status', 1)
                        ->where('country_id', $request->country_id)
                        ->exists()) {

                        $fail('The selected state is invalid or inactive.');
                    }
                },

            ],

            'city_id'            => [
                'required',
                // Rule::exists('cities', 'id')
                //     ->where('status', 1)
                //     ->where('state_id', $request->state_id),

                function ($attribute, $value, $fail) use ($request) {
                    if (!City::where('id', $value)
                        ->where('status', 1)
                        ->where('state_id', $request->state_id)
                        ->exists()) {

                        $fail('The selected city is invalid or inactive.');
                    }
                },
            ],

            'area_id'            => [
                'required',
                // Rule::exists('areas', 'id')
                //     ->where('status', 1)
                //     ->where('city_id', $request->city_id),

                function ($attribute, $value, $fail) use ($request) {
                    if (!Area::where('id', $value)
                        ->where('status', 1)
                        ->where('city_id', $request->city_id)
                        ->exists()) {

                        $fail('The selected area is invalid or inactive.');
                    }
                },
            ],

            'address_line_1'     => 'required',
            'address_line_2'     => 'nullable',
            'landmark'           => 'nullable',
            'pincode'            => 'required',

            'is_default_address' => 'required',
            'status'             => 'required',
        ]);

        AddressBook::create([
            'contact_type'       => $request->contact_type,
            'name'               => $request->name,
            'mobile'             => $request->mobile_no,
            'alternate_mobile'   => $request->alternate_mobile,
            'email'              => $request->email,

            'country_id'         => $request->country_id,
            'state_id'           => $request->state_id,
            'city_id'            => $request->city_id,
            'area_id'            => $request->area_id,

            'address1'           => $request->address_line_1,
            'address2'           => $request->address_line_2,
            'landmark'           => $request->landmark,
            'pincode'            => $request->pincode,

            'is_default'         => $request->is_default_address,
            'status'             => $request->status,
        ]);

        return redirect()
            ->route('addressbooks.index')
            ->with('success', 'Address Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AddressBook $addressBook)
    {
        //
    }

    public function edit(string $id)
    {
        $addressBook = AddressBook::findOrFail($id);
        $countries = Country::where('status', 1)->get();

        return view('addressbooks.edit', compact('addressBook', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $addressBook = AddressBook::findOrFail($id);

        // Status toggle from index page
        if ($request->has('_status_toggle')) {
            $addressBook->update([
                'status' => $request->status,
            ]);

            // $statusMsg = $request->status == 1
            //     ? 'Address Book status active successfully.'
            //     : 'Address Book status inactive successfully.';
            if ($request->action == 'status') {
                $message = $request->status == 1
                    ? 'Address Book Status Active Successfully.'
                    : 'Address Book inactive successfully.';
            } else {
                $message = 'Address Book updated successfully.';
            }
            return redirect()
                ->route('addressbooks.index')
                ->with('success', $message);
        }

        $request->validate([
            'contact_type'       => 'required',
            'name'               => 'required',
            'mobile_no'          => 'required|numeric|digits:10',
            'alternate_mobile'   => 'nullable|digits:10',
            'email'              => 'nullable|email',

            'country_id'         => [
                'required',
                //Rule::exists('countries', 'id')->where('status', 1),
                function ($attribute, $value, $fail) {
                    if (!Country::where('id', $value)
                        ->where('status', 1)
                        ->exists()) {

                        $fail('The selected country is invalid or inactive.');
                    }
                },

            ],
            'state_id'           => [
                'required',
                // Rule::exists('states', 'id')
                //     ->where('status', 1)
                //     ->where('country_id', $request->country_id),
                function ($attribute, $value, $fail) use ($request) {
                    if (!State::where('id', $value)
                        ->where('status', 1)
                        ->where('country_id', $request->country_id)
                        ->exists()) {

                        $fail('The selected state is invalid or inactive.');
                    }
                },
            ],
            'city_id'            => [
                'required',
                // Rule::exists('cities', 'id')
                //     ->where('status', 1)
                //     ->where('state_id', $request->state_id),

                function ($attribute, $value, $fail) use ($request) {
                    if (!City::where('id', $value)
                        ->where('status', 1)
                        ->where('state_id', $request->state_id)
                        ->exists()) {

                        $fail('The selected city is invalid or inactive.');
                    }
                },
            ],
            'area_id'            => [
                'required',
                // Rule::exists('areas', 'id')
                //     ->where('status', 1)
                //     ->where('city_id', $request->city_id),

                function ($attribute, $value, $fail) use ($request) {
                    if (!Area::where('id', $value)
                        ->where('status', 1)
                        ->where('city_id', $request->city_id)
                        ->exists()) {

                        $fail('The selected area is invalid or inactive.');
                    }
                },

            ],

            'address_line_1'     => 'required',
            'address_line_2'     => 'nullable',
            'landmark'           => 'nullable',
            'pincode'            => 'required',

            'is_default_address' => 'required',
        ]);

        $addressBook->update([
            'contact_type'       => $request->contact_type,
            'name'               => $request->name,
            'mobile'             => $request->mobile_no,
            'alternate_mobile'   => $request->alternate_mobile,
            'email'              => $request->email,

            'country_id'         => $request->country_id,
            'state_id'           => $request->state_id,
            'city_id'            => $request->city_id,
            'area_id'            => $request->area_id,

            'address1'           => $request->address_line_1,
            'address2'           => $request->address_line_2,
            'landmark'           => $request->landmark,
            'pincode'            => $request->pincode,

            'is_default'         => $request->is_default_address,
        ]);

        return redirect()
            ->route('addressbooks.index')
            ->with('success', 'Address Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $addressBook = AddressBook::findOrFail($id);
        $addressBook->delete();

        return redirect()
            ->route('addressbooks.index')
            ->with('success', 'Address Book deleted successfully.');
    }

    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)
            ->where('status', 1)
            ->get();

        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)
            ->where('status', 1)
            ->get();

        return response()->json($cities);
    }

    public function getAreas($cityId)
    {
        $areas = Area::where('city_id', $cityId)
            ->where('status', 1)
            ->get();

        return response()->json($areas);
    }
}
