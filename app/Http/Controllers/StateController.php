<?php

namespace App\Http\Controllers;

use App\Models\state;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\select;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = State::with('country')->get();
        return view('states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::where('status', 1)->get();

        return view('states.create', compact('countries'));
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
                    if (!Country::where('id', $value)->where('status', 1)->exists()) {
                        $fail('The selected country is invalid or inactive.');
                    }
                },
            ],
            'state' => 'required|unique:states,state',
            'state_code' => 'required|numeric|digits:6|unique:states,state_code',
        ]);

        State::create([
            'country_id' => $request->country_id,
            'state' => $request->state,
            'state_code' => $request->state_code,
            'status' => 1
        ]);

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
        $state = State::find($id);

        $countries = Country::where('status', 1)->get();

        return view('states.edit', compact('state', 'countries'));
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
                    if (!Country::where('id', $value)->where('status', 1)->exists()) {
                        $fail('The selected country is invalid or inactive.');
                    }
                },

            ],
            'state' => 'required|unique:states,state,' . $id,
            'state_code' => 'required|numeric|digits:6|unique:states,state_code,' . $id,
        ]);

        $state = State::find($id);

        $state->update([
            'country_id' => $request->country_id,
            'state' => $request->state,
            'state_code' => $request->state_code,
            'status' => $request->input('status', $state->status),
        ]);

        if ($request->action == 'status') {
            $message = $request->status == 1
                ? 'State status active successfully.'
                : 'State status inactive successfully.';
        } else {
            $message = 'State updated successfully.';
        }

        return redirect()->route('states.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $state = State::find($id);

        $state->delete();

        return redirect()->route('states.index')->with('success', 'State deleted successfully.');
    }
}
