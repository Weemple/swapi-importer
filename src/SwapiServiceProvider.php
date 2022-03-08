<?php

namespace Weemple\SwapiImporter;

use Illuminate\Support\ServiceProvider;

class SwapiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/migrations");
    }
}
