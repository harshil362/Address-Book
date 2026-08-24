<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

use App\Interface\CountryServiceInterface;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $countryService;

    public function __construct(CountryServiceInterface $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index()
    {
        $countries = $this->countryService->getAllCountries();

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
        $validator = $this->countryService->validateCountry($request->all());

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // $this->countryService->createCountries([
        //     'country' => $request->country,
        //     'country_code' => $request->country_code, 
        //     //'status' => $request->status,
        // ]);

        $this->countryService->createCountries($request->all());

        return redirect()
            ->route('countries.index')
            ->with('success', 'countries created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $country = $this->countryService->getCountries($id);

        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = $this->countryService->validateUpdateCountry(
            $id,
            $request->all()
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->countryService->getCountries($id);

        $this->countryService->updateCountries($id, $request->all());


        $message = $this->countryService->getToastMessage(
            $request->action,
            $request->status
        );

        return redirect()->route('countries.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->countryService->deleteCountry($id);

        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
