<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Interface\CityServiceInterface;


class CityController extends Controller
{

    private CityServiceInterface $cityService;

    public function __construct(CityServiceInterface $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$cities = City::with('state')->get();

        $cities = $this->cityService->getAllCities();

        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        //$countries = Country::where('status', 1)->get();

        $countries = $this->cityService->getActiveCountries();

        $states = collect();
        $countryId = old('country_id', $request->country_id);

        if ($countryId) {
            $states = $this->cityService->getActiveStates($countryId);
        }

        return view('cities.create', compact('countries', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = $this->cityService->validateStoreCity(
            $request->all()
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->cityService->createCity($request->all());

        return redirect()->route('cities.index')
            ->with('success', 'City added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id, Request $request,)
    {
        $city = $this->cityService->getCity($id);

        $countries = $this->cityService->getActiveCountries();

        $countryId = $this->cityService->getCountryId(
            $city,
            $request->country_id
        );

        $states = $this->cityService->getActiveStates($countryId);

        return view('cities.edit', compact('city', 'countries', 'states', 'countryId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $this->cityService->validateUpdateCity(
            $request->all(),
            $id
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $city = $this->cityService->getCity($id);
        
        $this->cityService->updateCity($id, $request->all());

        $message = $this->cityService->getToastMessage(
            $request->action,
            $request->status
        );
        return redirect()->route('cities.index')
            ->with('success', $message);
    }
    /** 
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cityService->deleteCity($id);

        return redirect()->route('cities.index')
            ->with('success', 'City deleted successfully.');
    }
}
