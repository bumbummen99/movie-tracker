<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use aharen\OMDbAPI;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* Register the OMDbAPI-Client */
        $this->app->singleton(OMDbAPI::class, function ($app) {
            return new OMDbAPI(Config::get('movie-tracker.omdb.api-key'), false, true);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
