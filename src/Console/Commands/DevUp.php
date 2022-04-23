<?php

namespace Gragot\LaravelDevTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

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
        exec('docker-compose -f docker/docker-compose.yml up -d');
        // TODO: Indicar url
        // echo 'http://localhost:90';
    }
}
