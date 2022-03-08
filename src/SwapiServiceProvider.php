<?php

namespace Weemple\SwapiImporter;

use Illuminate\Support\ServiceProvider;
use Weemple\SwapiImporter\Commands\ImportData;

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
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ImportData::class
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }
}
