<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\RoleAssignmentController;
use App\Http\Controllers\RolePermissionController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Country
    |--------------------------------------------------------------------------
    */

    Route::get('/countries/data', [CountryController::class, 'data'])
        ->middleware('permission:country.view')
        ->name('countries.data');

    Route::get('/countries', [CountryController::class, 'index'])
        ->middleware('permission:country.view')
        ->name('countries.index');

    Route::get('/countries/create', [CountryController::class, 'create'])
        ->middleware('permission:country.create')
        ->name('countries.create');

    Route::post('/countries', [CountryController::class, 'store'])
        ->middleware('permission:country.create')
        ->name('countries.store');

    Route::get('/countries/{country}/edit', [CountryController::class, 'edit'])
        ->middleware('permission:country.edit')
        ->name('countries.edit');

    Route::put('/countries/{country}', [CountryController::class, 'update'])
        ->middleware('permission:country.edit')
        ->name('countries.update');

    Route::delete('/countries/{country}', [CountryController::class, 'destroy'])
        ->middleware('permission:country.delete')
        ->name('countries.destroy');


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    Route::get('/states/data', [StateController::class, 'data'])
        ->middleware('permission:state.view')
        ->name('states.data');

    Route::get('/states', [StateController::class, 'index'])
        ->middleware('permission:state.view')
        ->name('states.index');

    Route::get('/states/create', [StateController::class, 'create'])
        ->middleware('permission:state.create')
        ->name('states.create');

    Route::post('/states', [StateController::class, 'store'])
        ->middleware('permission:state.create')
        ->name('states.store');

    Route::get('/states/{state}/edit', [StateController::class, 'edit'])
        ->middleware('permission:state.edit')
        ->name('states.edit');

    Route::put('/states/{state}', [StateController::class, 'update'])
        ->middleware('permission:state.edit')
        ->name('states.update');

    Route::delete('/states/{state}', [StateController::class, 'destroy'])
        ->middleware('permission:state.delete')
        ->name('states.destroy');


    /*
    |--------------------------------------------------------------------------
    | City
    |--------------------------------------------------------------------------
    */

    Route::get('/cities/data', [CityController::class, 'data'])
        ->middleware('permission:city.view')
        ->name('cities.data');

    Route::get('/cities', [CityController::class, 'index'])
        ->middleware('permission:city.view')
        ->name('cities.index');

    Route::get('/cities/create', [CityController::class, 'create'])
        ->middleware('permission:city.create')
        ->name('cities.create');

    Route::post('/cities', [CityController::class, 'store'])
        ->middleware('permission:city.create')
        ->name('cities.store');

    Route::get('/cities/{city}/edit', [CityController::class, 'edit'])
        ->middleware('permission:city.edit')
        ->name('cities.edit');

    Route::put('/cities/{city}', [CityController::class, 'update'])
        ->middleware('permission:city.edit')
        ->name('cities.update');

    Route::delete('/cities/{city}', [CityController::class, 'destroy'])
        ->middleware('permission:city.delete')
        ->name('cities.destroy');


    /*
    |--------------------------------------------------------------------------
    | Area
    |--------------------------------------------------------------------------
    */

    Route::get('/areas/data', [AreaController::class, 'data'])
        ->middleware('permission:area.view')
        ->name('areas.data');

    Route::get('/areas', [AreaController::class, 'index'])
        ->middleware('permission:area.view')
        ->name('areas.index');

    Route::get('/areas/create', [AreaController::class, 'create'])
        ->middleware('permission:area.create')
        ->name('areas.create');

    Route::post('/areas', [AreaController::class, 'store'])
        ->middleware('permission:area.create')
        ->name('areas.store');

    Route::get('/areas/{area}/edit', [AreaController::class, 'edit'])
        ->middleware('permission:area.edit')
        ->name('areas.edit');

    Route::put('/areas/{area}', [AreaController::class, 'update'])
        ->middleware('permission:area.edit')
        ->name('areas.update');

    Route::delete('/areas/{area}', [AreaController::class, 'destroy'])
        ->middleware('permission:area.delete')
        ->name('areas.destroy');


    /*
    |--------------------------------------------------------------------------
    | Address Book
    |--------------------------------------------------------------------------
    */

    Route::get('/addressbooks/data', [AddressBookController::class, 'data'])
        ->middleware('permission:address_book.view')
        ->name('addressbooks.data');

    Route::get('/addressbooks', [AddressBookController::class, 'index'])
        ->middleware('permission:address_book.view')
        ->name('addressbooks.index');

    Route::get('/addressbooks/create', [AddressBookController::class, 'create'])
        ->middleware('permission:address_book.create')
        ->name('addressbooks.create');

    Route::post('/addressbooks', [AddressBookController::class, 'store'])
        ->middleware('permission:address_book.create')
        ->name('addressbooks.store');

    Route::get('/addressbooks/{addressbook}/edit', [AddressBookController::class, 'edit'])
        ->middleware('permission:address_book.edit')
        ->name('addressbooks.edit');

    Route::put('/addressbooks/{addressbook}', [AddressBookController::class, 'update'])
        ->middleware('permission:address_book.edit')
        ->name('addressbooks.update');

    Route::delete('/addressbooks/{addressbook}', [AddressBookController::class, 'destroy'])
        ->middleware('permission:address_book.delete')
        ->name('addressbooks.destroy');

    Route::get('/get-states/{countryId}', [AddressBookController::class, 'getStates'])
        ->middleware('permission:address_book.view');

    Route::get('/get-cities/{stateId}', [AddressBookController::class, 'getCities'])
        ->middleware('permission:address_book.view');

    Route::get('/get-areas/{cityId}', [AddressBookController::class, 'getAreas'])
        ->middleware('permission:address_book.view');


    /*
    |--------------------------------------------------------------------------
    | Users & Role Assignments
    |--------------------------------------------------------------------------
    */

    Route::get('/role-assignments', [RoleAssignmentController::class, 'index'])
        ->middleware('permission:role_assignment.view')
        ->name('role-assignments.index');

    Route::get('/users', [RoleAssignmentController::class, 'index'])
        ->middleware('permission:role_assignment.view')
        ->name('users.index');

    Route::get('/users/create', [RoleAssignmentController::class, 'create'])
        ->middleware('permission:role_assignment.create')
        ->name('users.create');

    Route::post('/users', [RoleAssignmentController::class, 'storeUser'])
        ->middleware('permission:role_assignment.create')
        ->name('users.store');

    Route::get('/users/{user}/edit', [RoleAssignmentController::class, 'edit'])
        ->middleware('permission:role_assignment.edit')
        ->name('users.edit');

    Route::put('/users/{user}', [RoleAssignmentController::class, 'updateUser'])
        ->middleware('permission:role_assignment.edit')
        ->name('users.update');

    Route::post('/role-assignments', [RoleAssignmentController::class, 'store'])
        ->middleware('permission:role_assignment.create')
        ->name('role-assignments.store');

    Route::delete('/role-assignments/{user}', [RoleAssignmentController::class, 'destroy'])
        ->middleware('permission:role_assignment.delete')
        ->name('role-assignments.destroy');

    /*
    |--------------------------------------------------------------------------
    | Roles & Module Permissions
    |--------------------------------------------------------------------------
    */

    Route::get('/role-permissions', [RolePermissionController::class, 'index'])
        ->middleware('permission:role_assignment.view')
        ->name('role-permissions.index');

    Route::get('/roles', [RolePermissionController::class, 'index'])
        ->middleware('permission:role_assignment.view')
        ->name('roles.index');

    Route::get('/role-permissions/create', [RolePermissionController::class, 'create'])
        ->middleware('permission:role_assignment.create')
        ->name('role-permissions.create');

    Route::get('/roles/create', [RolePermissionController::class, 'create'])
        ->middleware('permission:role_assignment.create')
        ->name('roles.create');

    Route::post('/role-permissions', [RolePermissionController::class, 'store'])
        ->middleware('permission:role_assignment.create')
        ->name('role-permissions.store');

    Route::get('/role-permissions/{role}/edit', [RolePermissionController::class, 'edit'])
        ->middleware('permission:role_assignment.view')
        ->name('role-permissions.edit');

    Route::put('/role-permissions/{role}', [RolePermissionController::class, 'update'])
        ->middleware('permission:role_assignment.edit')
        ->name('role-permissions.update');

    Route::delete('/role-permissions/{role}', [RolePermissionController::class, 'destroy'])
        ->middleware('permission:role_assignment.delete')
        ->name('role-permissions.destroy');

});

Route::get('/', function () {
    return redirect()->route('dashboard');
});
