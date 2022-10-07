# Instalación

Añadir al **composer.json** el respositorio en la sección **repositories**

``` 
"repositories": {
    ...
    "laravel-dev-tools": {
        "type": "vcs",
        "url": "https://github.com/gragot/laravel-dev-tools.git"
    }
    ...
}
```

Ejecutar

```
composer require gragot/laravel-dev-tools
```

Añadir el service provider en el archivo **config/app.php** en la seccion **providers**

```
'providers' => [
    ...
    \Gragot\LaravelDevTools\LaravelDevToolsServiceProvider::class
    ...
]
```

# Configuración

Crear el archivo **dev_tools.php** en **app/config** con el siguiente contenido:

```
<?php

return [
    'pro_ssh_user' => env('PRO_SSH_USER'),
    'pro_host' => env('PRO_HOST'),
    'pro_db_database' => env('PRO_DB_DATABASE'),
    'dev_db_host' => env('DEV_DB_HOST'),
    'dev_db_port' => env('DEV_DB_PORT'),
    'dev_backups_db_path' => env('DEV_BACKUPS_DB_PATH'),
    'dev_mysql_path' => null,
    'mysqldump_opciones' => env('DEV_TOOLS_MYSQLDUMP_OPCIONES', false),
    'commands' => [
        'dev:up' => false
    ]
];

```

Configura las las claves del archivo .env

Es posible que tengas que refrescar la configuracion cacheada

``` 
php artisan config:cache
```

## Variables de entorno

Es necesario configurar las variables de entorno en el fichero **.env**:

pro_db_database: El nombre de la base de datos de produccion
dev_backups_db_path: La ruta donde se ubica el dump de la base de datos
pro_host: La ip o el dominio de producción
pro_ssh_user: El usuario ssh de produccion

# Comandos

## php artisan dev:up

```
php artisan dev:up
```

Levanta el entorno de desarollo

### Requisitos

En el archivo de configuración "dev_tools.php" pon a true la clave "dev_tools.commands.dev:up"

## php artisan dev:import_db

```
php artisan dev:import_db
```

Importa el dump de la base de datos de producción que tenemos almacenado en local al entorno de desarrollo, si no tenemos copia local exporta la base de datos de produccion la guarda en local y la importa.

### Requisitos

Para poder realizar las exportaciones de base de datos de pro ``` dev:import_db --u ``` es necesario crear un archivo .my.cnf en el directorio principal con el siguiente contenido:

PRO_DB_DATABASE
DEV_BACKUPS_DB_PATH

```
[mysqldump]
user=*El usuario de la base de datos*
password=*La contraseña de la base de datos*
```

### Opciones:

* --u Realiza un dump de la base de datos de produccion y actualiza el dump local, despues lo importa a la base de datos de desarrollo
