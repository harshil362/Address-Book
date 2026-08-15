<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::with('state')->get();
        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $countries = Country::where('status', 1)->get();

        $states = collect();
        $countryId = old('country_id', $request->country_id);

        if ($countryId) {
            $states = State::where('country_id', $countryId)
                ->where('status', 1)
                ->get();

               
        }

        return view('cities.create', compact('countries', 'states'));
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

                function ($attribute, $value, $fail) {
                    if (!State::where('id', $value)
                        ->where('status', 1)
                        ->where('country_id', request()->country_id)
                        ->exists()) {
                        $fail('The selected state is invalid or inactive.');
                    }
                },
            ],
            'city' => 'required|unique:cities,city',
            'city_code' => 'required|numeric|digits:6|unique:cities,city_code',
            //'status' => 'required',
        ]);

        City::create([
            'state_id' => $request->state_id,
            'city' => $request->city,
            'city_code' => $request->city_code,
            'status' => 1
        ]);

        return redirect()->route('cities.index')
            ->with('success', 'City added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request,)
    {
        $city = City::findOrFail($id);

        $countries = Country::where('status', 1)->get();

        if ($request->filled('country_id')) {
            $countryId = $request->country_id;
        } else {
            $countryId = $city->state->country_id;
        }

        $states = State::where('country_id', $countryId)
            ->where('status', 1)
            ->get();

        return view('cities.edit', compact('city', 'countries', 'states', 'countryId'));
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
            'state_id'   => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if (
                        !State::where('id', $value)
                            ->where('country_id', $request->country_id)
                            ->exists()
                    ) {
                        $fail('The selected state is invalid.');
                    }
                },

            ],
            'city'       => 'required|unique:cities,city,' . $id,
            'city_code'  => 'required|numeric|digits:6|unique:cities,city_code,' . $id,
        ]);

        $city = City::find($id);

        $city->update([
            'state_id'  => $request->state_id,
            'city'      => $request->city,
            'city_code' => $request->city_code,
            'status'    => $request->input('status', $city->status),
        ]);

        if ($request->action == 'status') {
            $message = $request->status == 1
                ? 'City Status Active Successfully.'
                : 'City status inactive successfully.';
        } else {
            $message = 'City updated successfully.';
        }
        return redirect()->route('cities.index')
            ->with('success', $message);
    }
    /** 
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::find($id);

        $city->delete();

        return redirect()->route('cities.index')
            ->with('success', 'City deleted successfully.');
    }
}
