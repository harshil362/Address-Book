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

    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('addressbooks', AddressBookController::class);
});


Route::get('/', function () {
    return redirect()->route('dashboard');
});


/*
|--------------------------------------------------------------------------
| Dynamic dropdown helper API routes (no auth needed)
|--------------------------------------------------------------------------
*/
// Route::get('api/countries/{country}/states', function ($countryId) {
//     return App\Models\State::where('country_id', $countryId)
//         ->where('status', 1)
//         //.->whereHas('country', fn($q) => $q->where('status', 1))
//         ->get();
// });

// Route::get('api/states/{state}/cities', function ($stateId) {
//     return App\Models\City::where('state_id', $stateId)
//         ->where('status', 1)
//         ->whereHas('state', fn($q) => $q->where('status', 1)->whereHas('country', fn($q2) => $q2->where('status', 1)))
//         ->get();
// });

// Route::get('api/cities/{city}/areas', function ($cityId) {
//     return App\Models\Area::where('city_id', $cityId)
//         ->where('status', 1)
//         ->whereHas('city', fn($q) => $q->where('status', 1)
//             ->whereHas('state', fn($q2) => $q2->where('status', 1)
//                 ->whereHas('country', fn($q3) => $q3->where('status', 1))
//             )
//         )
//         ->get();
// });