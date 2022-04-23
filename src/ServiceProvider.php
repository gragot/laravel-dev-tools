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
        if ($this->app->runningInConsole())
        {
            $comandos = [
                ImportDB::class,
                RutaSinTest::class
            ];
            if(config('dev_tools.commands.dev:import_db') == true) {
                $comandos[] = DevUp::class;
            }
            $this->commands($comandos);
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
