<?php

namespace Gragot\LaravelDevTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DevUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Levanta el entorno de desarrollo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        exec('docker-compose up -d');
        exec('cd "C:/laragon/bin/apache/httpd-2.4.35-win64-VC15/bin" && httpd.exe');
    }
}
