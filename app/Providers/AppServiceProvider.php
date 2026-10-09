<?php

namespace App\Providers;

use App\Interface\AddressBookServiceInterface;
use App\Interface\AreaServiceInterface;
use App\Interface\CityServiceInterface;
use App\Interface\CountryServiceInterface;
use App\interface\StateServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\AddressBookService;
use App\Services\AreaService;
use App\Services\CityService;
use App\Services\CountryService;
use App\services\StateService;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {    
        $this->app->bind(CountryServiceInterface::class,CountryService::class);
        
        $this->app->bind(StateServiceInterface::class,StateService::class);

        $this->app->bind(CityServiceInterface::class, CityService::class );

        $this->app->bind(AreaServiceInterface::class,AreaService::class);
                        
        $this->app->bind(AddressBookServiceInterface::class, AddressBookService::class);
        
    }

    /**
     * Bootstrap any application services.
     */
        public function boot(): void
        {
            Gate::before(function (User $user, string $ability) {

                if ($user->hasRole('Super Admin')) {
                    return true;
                }

                return $user->hasPermission($ability);
            });
        }
}


