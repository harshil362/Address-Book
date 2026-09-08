<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AddressBookController;



Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/countries/data', [CountryController::class, 'data'])
    ->name('countries.data');
    Route::resource('countries', CountryController::class);

    Route::get('/states/data', [StateController::class, 'data'])
    ->name('states.data');
    Route::resource('states', StateController::class);

    Route::get('/cities/data', [CityController::class, 'data'])
    ->name('cities.data');
    Route::resource('cities', CityController::class);

    Route::get('/areas/data', [AreaController::class, 'data'])
    ->name('areas.data');
    Route::resource('areas', AreaController::class);

    Route::get('/addressbooks/data', [AddressBookController::class, 'data'])
    ->name('addressbooks.data');
    Route::resource('addressbooks', AddressBookController::class);

    Route::get('/get-states/{countryId}', [AddressBookController::class, 'getStates']);
    Route::get('/get-cities/{stateId}', [AddressBookController::class, 'getCities']);
    Route::get('/get-areas/{cityId}', [AddressBookController::class, 'getAreas']);

});


Route::get('/', function () {
    return redirect()->route('dashboard');
});
