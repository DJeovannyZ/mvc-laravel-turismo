<?php

namespace App\Providers;

use App\Repositories\TouristPlaceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            TouristPlaceRepository::class,
            fn () => new TouristPlaceRepository(storage_path('app/data/lugares.json'))
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
