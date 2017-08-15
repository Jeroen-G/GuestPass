<?php

namespace JeroenG\GuestPass;

use Illuminate\Support\ServiceProvider;

class GuestPassServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Make the migrations available.
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Register the routes.
        app('guestpass')->routes();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('guestpass', function ($app) {
            return new GuestPassService;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['guestpass'];
    }
}
