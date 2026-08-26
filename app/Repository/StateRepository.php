<?php

namespace App\Repository;
use App\Models\state;
use App\Models\Country;
use App\RepositoryInterface\StateRepositoryInterface;
class StateRepository implements StateRepositoryInterface
{
    /**
     * Create a new class instance.
     */
   
    public function getAllStates()
    {
        return State::with('country')->get();
    }

    public function getActiveCountries()
    {
        return Country::where('status', 1)->get();
    }

    public function createState($data)
    {
        return State::create([
            'country_id' => $data['country_id'],
            'state' => $data['state'],
            'state_code' => $data['state_code'],
            'status' => 1,
        ]);
    }

    public function getState($id)
    {
        return State::find($id);
    }

    public function updateState($id,$data)
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

    public function deleteState($id)
    {
        $state = State::find($id);

        return $state->delete();
    }


}
