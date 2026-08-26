<?php

namespace App\services;

use App\interface\StateServiceInterface;
use App\Models\state;
use App\Models\Country;
use App\RepositoryInterface\StateRepositoryInterface;


class StateService implements StateServiceInterface

{
    /**
     * Create a new class instance.
     */
    private StateRepositoryInterface $stateRepository;

    public function __construct(StateRepositoryInterface $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function getAllStates()
    {
        //return State::with('country')->get();
        return $this->stateRepository->getAllStates();
    }

    public function getActiveCountries()
    {
        //return Country::where('status', 1)->get();
        return $this->stateRepository->getActiveCountries();

    }

    public function cretaeState($data)
    {
        return $this->stateRepository->createState($data);

    }
    public function getState($id)
    {
        return $this->stateRepository->getState($id);

    }

    public function updateState($id, $data)
{
    return $this->stateRepository->updateState($id, $data);

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
        return $this->stateRepository->deleteState($id);

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
