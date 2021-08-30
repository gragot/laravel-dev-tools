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
    \Gragot\LaravelDevTools\ServiceProvider::class
    ...
]
```

# Configuración

Crear el archivo **dev_tools.php** en **app/config** con el siguiente contenido:

```
<?php

return [
    'pro_host' => env('PRO_HOST'),
    'pro_ssh_user' => env('PRO_SSH_USER'),
    'pro_db_database' => env('PRO_DB_DATABASE'),
    'dev_backups_db_path' => env('DEV_BACKUPS_DB_PATH'),
    'dev_mysql_path' => env('DEV_MYSQL_PATH'),
    'mysqldump_opciones' => env('DEV_TOOLS_MYSQLDUMP_OPCIONES', false),
];

```

Configura las las claves del archivo .env

Es posible que tengas que refrescar la configuracion cacheada

``` 
php artisan config:cache
```

Para poder realizar las exportaciones de base de datos de pro ``` dev:import_db --u ``` es necesario crear un archivo .my.cnf en el directorio principal con el siguiente contenido:

```
[mysqldump]
user=*El usuario de la base de datos*
password=*La contraseña de la base de datos*
```

## Variables de entorno

Es necesario configurar las variables de entorno en el fichero **.env**:

pro_db_database: El nombre de la base de datos de produccion
dev_backups_db_path: La ruta donde se ubica el dump de la base de datos
pro_host: La ip o el dominio de producción
pro_ssh_user: El usuario ssh de produccion

# Comandos

```
php artisan dev:import_db
```

Importa el dump de la base de datos que tenemos en local al entorno de desarrollo

Opciones:

* --u Realiza un dump de la base de datos de produccion y actualiza el dump local

```
php artisan dev:up
```

Levanta el entorno de desarollo