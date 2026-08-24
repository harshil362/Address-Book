<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Interface\AddressBookServiceInterface;

use function Laravel\Prompts\select;

class AddressBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private AddressBookServiceInterface $addressBookService;

    public function __construct(AddressBookServiceInterface $addressBookService)
    {
        $this->addressBookService = $addressBookService;
    }

    public function index()
    {
        $addressbooks = $this->addressBookService->getAllAddressBooks();

        return view('addressbooks.index', compact('addressbooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $countries = $this->addressBookService->getActiveCountries();

        return view('addressbooks.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->addressBookService->validateStoreAddressBook(
            $request->all()
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->addressBookService->createAddressBook(
            $request->all()
        );

        return redirect()
            ->route('addressbooks.index')
            ->with('success', 'Address Book created successfully.');
    }

    public function edit(string $id)
    {
        $addressBook = $this->addressBookService->getAddressBook($id);

        $countries = $this->addressBookService->getActiveCountries();

        return view('addressbooks.edit', compact('addressBook', 'countries'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $validator = $this->addressBookService->validateUpdateAddressBook(
        $request->all()
    );

    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }

    $this->addressBookService->updateAddressBook(
        $id,
        $request->all()
    );

    $message = $this->addressBookService->getToastMessage(
        $request->action,
        $request->status
    );

    return redirect()
        ->route('addressbooks.index')
        ->with('success', $message);
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $this->addressBookService->deleteAddressBook($id);

        return redirect()
            ->route('addressbooks.index')
            ->with('success', 'Address Book deleted successfully.');
    }

    public function getStates($countryId)
    {
        $states = $this->addressBookService->getStates($countryId);

        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $cities = $this->addressBookService->getCities($stateId);

        return response()->json($cities);
    }

    public function getAreas($cityId)
    {
        $areas = $this->addressBookService->getAreas($cityId);

        return response()->json($areas);
    }
}
