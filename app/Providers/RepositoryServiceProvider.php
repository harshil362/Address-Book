<?php

namespace App\Providers;

use App\Models\state;
use App\Repository\AddressBookRepository;
use App\Repository\AreaRepository;
use App\Repository\CityRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\CountryRepository;
use App\Repository\StateRepository;
use App\RepositoryInterface\AddressBookRepositoryInterface;
use App\RepositoryInterface\AreaRepositoryInterface;
use App\RepositoryInterface\CityRepositoryInterface;
use App\RepositoryInterface\CountryRepositoryInterface;
use App\RepositoryInterface\StateRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CountryRepositoryInterface::class,CountryRepository::class);

        $this->app->bind(StateRepositoryInterface::class,StateRepository::class);

        $this->app->bind(CityRepositoryInterface::class,CityRepository::class);
        
        $this->app->bind(AreaRepositoryInterface::class,AreaRepository::class);

        $this->app->bind(AddressBookRepositoryInterface::class, AddressBookRepository::class);
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
