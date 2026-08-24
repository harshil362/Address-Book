<?php

namespace App\interface;

interface StateServiceInterface
{
    /**
     * Create a new class instance.
     */
   public function getAllStates();

   public function getActiveCountries();

   public function cretaeState($data);

   public function getState($id);

   public function updateState($id, $data);

   public function deleteState($id);

  public function validateStoreState($data);

  public function validateUpdateState($data,$id);


  public function getToastMessage($action, $status);

}
