<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerFacades();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Disallow
        Model::shouldBeStrict();
    }

    private function registerFacades()
    {
        $this->app->singleton('places', function () {
            return new \App\Services\PlacesService();
        });

        $this->app->singleton('weather', function () {
            return new \App\Services\WeatherService();
        });
    }
}
