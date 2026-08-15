<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\AddressBook;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */  
    public function index()
    {
        $areas = Area::with('city.state.country')->get();
        return view('areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $countries = Country::where('status', 1)->get();

        $states = collect();
        $cities = collect();

        $countryId = old('country_id', $request->country_id);
        $stateId = old('state_id', $request->state_id);

        if ($countryId) {
            $states = State::where('country_id', $countryId)
                ->where('status', 1)
                ->whereHas('country', function ($q) {
                    $q->where('status', 1);
                })
                ->get();
                        
        }

        if ($stateId) {
            $cities = City::where('state_id', $stateId)
                ->where('status', 1)
                ->whereHas('state', function ($q) {
                    $q->where('status', 1)->whereHas('country', function ($q2) {
                        $q2->where('status', 1);
                    });
                })
                ->get();
        }

        return view('areas.create', compact('countries', 'states', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
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
                
                function ($attribute, $value, $fail) use ($request) { //attribute
                    if (!State::where('id', $value)
                        ->where('status', 1)
                        ->where('country_id', $request->country_id)
                        ->exists()) {
                        $fail('The selected state is invalid or inactive.');//fail
                    }
                },
            ],
            'city_id' => [
                'required',
              
                function ($attribute, $value, $fail) use ($request) {
                    if (!City::where('id', $value)
                        ->where('status', 1)
                        ->where('state_id', $request->state_id)
                        ->exists()) {

                        $fail('The selected city is invalid or inactive.');
                    }
                },

            ],
            'area' => 'required|unique:areas,area',
            'pincode' => 'required|numeric|digits:6|unique:areas,pincode',
            //'status' => 'required',
        ]);

        Area::create([
            'city_id'  => $request->city_id,
            'area'     => $request->area,
            'pincode'  => $request->pincode,
            'status'   => 1
        ]);

        return redirect()->route('areas.index')
            ->with('success', 'Area created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $area = Area::find($id);

        $countries = Country::where('status', 1)->get();

        $countryId = $request->country_id ?? $area->city->state->country_id;
        $countryChanged = $countryId != $area->city->state->country_id;

        $states = State::where('country_id', $countryId)
            ->where('status', 1)
            ->get();

        $stateId = $request->state_id;
        if (!$stateId && !$countryChanged) {
            $stateId = $area->city->state_id;
        }

        $cities = collect();
        if ($stateId) {
            $cities = City::where('state_id', $stateId)
                ->where('status', 1)
                ->get();
        }

        return view('areas.edit', compact('area','countries','states', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'country_id' => [
                'required',
               
                function ($attribute, $value, $fail) {
                    if (!Country::where('id', $value)->exists()) {
                        $fail('The selected country is invalid.');
                    }
                },
            ],
            'state_id' => [
                'required',
                
                function ($attribute, $value, $fail) use ($request) {
                    if (!State::where('id', $value)
                        ->where('country_id', $request->country_id)
                        ->exists()) {

                        $fail('The selected state is invalid.');
                    }
                },
            ],
            'city_id' => [
                'required',
               
                function ($attribute, $value, $fail) use ($request) {
                    if (!City::where('id', $value)
                        ->where('state_id', $request->state_id)
                        ->exists()) {

                        $fail('The selected city is invalid.');
                    }
                },

            ],
            'area' => 'required|unique:areas,area,' . $id,
            'pincode' => 'required|numeric|digits:6|unique:areas,pincode,' . $id,
        ]);

        $area = Area::find($id);

        $area->update([
            'city_id'  => $request->city_id,
            'area'     => $request->area,
            'pincode'  => $request->pincode,
            'status'   => $request->input('status', $area->status),
        ]);
        
        AddressBook::where('area_id', $area->id)
            ->update([
                'pincode' => $request->pincode,
            ]); 

        if ($request->action == 'status') {
            $message = $request->status == 1
                ? 'Area Status Active Successfully.'
                : 'Area status inactive successfully.';
        } else {
            $message = 'Area updated successfully.';
        }
        return redirect()->route('areas.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = Area::find($id);

        $area->delete();

        return redirect()->route('areas.index')
            ->with('success', 'Area deleted successfully.');
    }
}
