<?php

namespace App\Http\Controllers;

use App\Models\state;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Validation\Rule;
use App\interface\StateServiceInterface;
use function Laravel\Prompts\select;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private StateServiceInterface $stateService;

    public function __construct(StateServiceInterface $stateService)
    {
        $this->stateService = $stateService;
    }

    public function index()
    {
        $states = $this->stateService->getAllStates();
        
        return view('states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = $this->stateService->getActiveCountries();

        return view('states.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = $this->stateService->validateStoreState($request->all());

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->stateService->cretaeState($request->all());
        //      State::create([ 
        //     'country_id' => $request->country_id,
        //     'state' => $request->state,
        //     'state_code' => $request->state_code,
        //     'status' => 1
        // ]);

        return redirect()->route('states.index')->with('success', 'State created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(state $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $state = $this->stateService->getState($id);

        $countries = $this->stateService->getActiveCountries();


        return view('states.edit', compact('state', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $validator = $this->stateService->validateUpdateState(
            $request->all(),
            $id
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // $this->stateService->updateState($id, [
        //     'country_id' => $request->country_id,
        //     'state' => $request->state,
        //     'state_code' => $request->state_code,
        //     'status' => $request->input('status', 1),
        // ]);

        $this->stateService->updateState($id, $request->all());
        
      $message = $this->stateService->getToastMessage(
            $request->action,
            $request->status
        );

        return redirect()
            ->route('states.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->stateService->deleteState($id);

        return redirect()->route('states.index')->with('success', 'State deleted successfully.');
    }
}
