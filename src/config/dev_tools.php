<?php

return [
    'pro_db_database' => env('PRO_DB_DATABASE'),
    'pro_host' => env('PRO_HOST'),
    'pro_ssh_user' => env('PRO_SSH_USER'),
    'dev_db_host' => env('DEV_DB_HOST'),
    'dev_db_port' => env('DEV_DB_PORT'),
    'dev_backups_db_path' => env('DEV_BACKUPS_DB_PATH'),
    'dev_mysql_path' => env('DEV_MYSQL_PATH'),
    'mysqldump_opciones' => env('DEV_TOOLS_MYSQLDUMP_OPCIONES', false),
];