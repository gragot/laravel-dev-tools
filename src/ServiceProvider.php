<?php

namespace Gragot\LaravelDevTools;

use Gragot\LaravelDevTools\Console\Commands\DevUp;
use Gragot\LaravelDevTools\Console\Commands\ImportDB;
use Gragot\LaravelDevTools\Console\Commands\RutaSinTest;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ImportDB::class,
                DevUp::class,
                RutaSinTest::class
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
