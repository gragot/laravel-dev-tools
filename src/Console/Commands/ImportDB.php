<?php

namespace Gragot\LaravelDevTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:import_db {--u}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporta la base de datos de pro (por defecto) y la importa en dev';

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
        if(!empty(config('dev_tools.dev_db_host'))) {
            config(['database.connections.mysql.host' => config('dev_tools.dev_db_host')]);
        }
        $dev_db_host = config('dev_tools.dev_db_host');
        if(!empty(config('dev_tools.dev_db_port'))) {
            config(['database.connections.mysql.port' => config('dev_tools.dev_db_port')]);
        }
        $dev_db_port = config('database.connections.mysql.port');
        DB::purge('mysql');

        $dev_nombre_tabla_usuarios = 'users';
        if(!empty(config('dev_tools.dev_nombre_tabla_usuarios'))) {
            $dev_nombre_tabla_usuarios = config('dev_tools.dev_nombre_tabla_usuarios');
        }

        $pro_db_database = config('dev_tools.pro_db_database');
        if(empty($pro_db_database)) {
            die('La variable de entorno PRO_DB_DATABASE no esta definida');
        }

        $ruta_dump = config('dev_tools.dev_backups_db_path');
        if(empty($ruta_dump)) {
            $ruta_dump = storage_path('database_dumps');
            if(!file_exists(storage_path('database_dumps'))) {
                $this->crearDirectorioDump();
            }
        }

        $ruta_mysql = config('dev_tools.dev_mysql_path');
        if(empty($ruta_dump)) {
            die('La variable de entorno DEV_MYSQL_PATH no esta definida');
        }

        $dev_db_name = config('database.connections.mysql.database');

        try {
            $db = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dev_db_name'");
            if (empty($db)) {
                die("La base de datos de dev $dev_db_name no esta definida");
            }
        } catch (\Throwable $e) {
            dump($e->getMessage());
            die("La base de datos de dev $dev_db_name no esta definida");
        }

        $ruta_dump = $ruta_dump.DIRECTORY_SEPARATOR.$dev_db_name.'.sql';

        if($this->option('u') || !file_exists($ruta_dump)) {

            echo "Exportando base de datos... \n";

            $pro_host = config('dev_tools.pro_host');
            if(empty($pro_host)) {
                die('La variable de entorno PRO_HOST no esta definida');
            }
            $ssh_pro_user = config('dev_tools.pro_ssh_user');
            if(empty($ssh_pro_user)) {
                die('La variable de entorno PRO_SSH_USER no esta definida');
            }

            $export = 'ssh ssh_user@ssh_host "mysqldump --defaults-extra-file=.my.cnf opciones pro_db_database" > "db_dump.sql"';
            $export = str_replace('ssh_host', $pro_host, $export);
            $export = str_replace('ssh_user', $ssh_pro_user, $export);
            $export = str_replace('pro_db_database', $pro_db_database, $export);
            $export = str_replace('db_dump.sql', $ruta_dump, $export);
            if(config('dev_tools.mysqldump_opciones')) {
                $export = str_replace('opciones', config('dev_tools.mysqldump_opciones'), $export);
            } else {
                $export = str_replace('opciones', '', $export);
            }

            exec($export);
            echo "Exportación finalizada \n";
        }

        exec("$ruta_mysql --user=root --password= --host=$dev_db_host --port=$dev_db_port -e \"drop database $dev_db_name\"");
        exec("$ruta_mysql --user=root --password= --host=$dev_db_host --port=$dev_db_port -e \"create schema $dev_db_name\"");
        exec("$ruta_mysql --user=root --password= --database=$dev_db_name --host=$dev_db_host --port=$dev_db_port < ".$ruta_dump);
        $hashPass = '\'$2a$10$RNE0mO2IOu9hjaHThM09hOvXS78nxO805MhezmjgaTENGm5vw7meG\'';
        DB::statement("UPDATE $dev_nombre_tabla_usuarios SET password = $hashPass");
        echo 'Importación finalizada';
    }

    private function crearDirectorioDump() {
        mkdir(storage_path('database_dumps'));
    }
}
