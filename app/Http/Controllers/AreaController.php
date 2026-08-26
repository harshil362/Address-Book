<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\AddressBook;
use App\Interface\AreaServiceInterface;
class AreaController extends Controller
{

    private AreaServiceInterface $areaService;

    public function __construct(AreaServiceInterface $areaService)
    {
        $this->areaService = $areaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = $this->areaService->getAllAreas();

        return view('areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $countries = $this->areaService->getActiveCountries();

        $countryId = old('country_id', $request->country_id);
        $stateId = old('state_id', $request->state_id);

        $data = $this->areaService->getStatesAndCities($countryId, $stateId);

        $states = $data['states'];
        $cities = $data['cities'];

        return view('areas.create', compact('countries', 'states', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->areaService->validateStoreArea(
            $request->all()
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->areaService->createArea($request->all());

        return redirect()->route('areas.index')
            ->with('success', 'Area created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Request $request, string $id)
    {
        $area = $this->areaService->getArea($id);

        $countries = $this->areaService->getActiveCountries();

        $countryId = $this->areaService->getCountryId($area, $request->country_id);

        $countryChanged = $countryId != $area->city->state->country_id;

        $states = $this->areaService->getStatesByCountry($countryId);

        $stateId = $this->areaService->getStateId($area, $request->state_id, $countryChanged);

        $cities = $this->areaService->getCitiesByState($stateId);

        return view('areas.edit', compact('area', 'countries', 'states', 'cities'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $this->areaService->validateUpdateArea(
            $id,
            $request->all()
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $area = $this->areaService->updateArea($id, $request->all());

        AddressBook::where('area_id', $area->id)
            ->update([
                'pincode' => $request->pincode,
            ]);

        $message = $this->areaService->getToastMessage(
            $request->action,
            $request->status
        );

        return redirect()->route('areas.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->areaService->deleteArea($id);


        return redirect()->route('areas.index')
            ->with('success', 'Area deleted successfully.');
    }
}
