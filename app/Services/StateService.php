<?php

namespace App\services;

use App\interface\StateServiceInterface;
use App\Models\state;
use App\Models\Country;

class StateService implements StateServiceInterface

{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllStates()
    {
        return State::with('country')->get();
    }

    public function getActiveCountries()
    {
        return Country::where('status', 1)->get();
    }

    public function cretaeState($data)
    {
        return State::create([
            'country_id' => $data['country_id'],
            'state' => $data['state'],
            'state_code' => $data['state_code'],
            'status' => 1
        ]);
    }
    public function getState($id)
    {
        return State::find($id);
    }

    // public function updateState($id, $data)
    // {
    //     $state = State::findOrFail($id);

    //     $state->update($data);

    //     return $state;
    // }

    public function updateState($id, $data)
{
    $state = State::findOrFail($id);

    $state->update([
        'country_id' => $data['country_id'],
        'state' => $data['state'],
        'state_code' => $data['state_code'],
        'status' => $data['status'] ?? $state->status,
    ]);

    return $state;
}

    public function validateStoreState($data)
    {
        return validator($data, [
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
    }


    public function validateUpdateState($data, $id)
    {
        return validator($data, [
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
            'state' => 'required|unique:states,state,' . $id,
            'state_code' => 'required|numeric|digits:6|unique:states,state_code,' . $id,
        ]);
    }

    public function deleteState($id)
    {
        $state = State::find($id);

        $state->delete();
    }

    public function getToastMessage($action, $status)
    {
        if ($action == 'status') {
            return $status == 1
                ? 'State status active successfully.'
                : 'State status inactive successfully.';
        }

        return 'Country updated successfully.';
    }
}
