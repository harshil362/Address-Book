<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\CountryRepository;
use App\RepositoryInterface\CountryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CountryRepositoryInterface::class,CountryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
