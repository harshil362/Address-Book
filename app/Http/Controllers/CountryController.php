<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return "Country List";

        $countries = Country::all();

        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|unique:countries,country',
            'country_code' => 'required|unique:countries,country_code',
        ]);

        Country::create([
            'country' => $request->country,
            'country_code' => $request->country_code,
            'status' => $request->status,
        ]);

        return redirect()->route('countries.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $country = Country::find($id);

        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $country = Country::find($id);

        $country->update([
            'country' => $request->country,
            'country_code' => $request->country_code,
            'status' => $request->status,
        ]);

        return redirect()->route('countries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::find($id);

        $country->delete();

        return redirect()->route('countries.index');
    }
}
