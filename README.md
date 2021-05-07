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

# Configuración

Crear el archivo **dev_tools.php** en **app/config** con el siguiente contenido:

```
<?php

return [
    'pro_db_database' => env('PRO_DB_DATABASE'),
    'dev_backups_db' => env('DEV_BACKUPS_DB'),
    'pro_host' => env('PRO_HOST'),
    'ssh_pro_user' => env('SSH_PRO_USER'),
    'mysqldump_opciones' => env('DEV_TOOLS_MYSQLDUMP_OPCIONES', false),
];

```

Añadir el service provider en el archivo **config/app.php** en la seccion **providers**

```
'providers' => [
    ...
    \Gragot\LaravelDevTools\ServiceProvider::class
    ...
]
```

Es posible que tengas que refrescar la configuracion cacheada

``` 
php artisan config:cache
```

Para poder realizar las exportaciones de base de datos de pro es necesario crear un archivo .my.cnf con el siguiente contenido:

```
[mysqldump]
user=*El usuario de la base de datos*
password=*La contraseña de la base de datos*
```

## Variables de entorno

Es necesario configurar las variables de entorno en el fichero **.env**:

pro_db_database: El nombre de la base de datos de produccion
dev_backups_db: La ruta donde se ubica el dump de la base de datos
pro_host: La ip o el dominio de producción
ssh_pro_user: El usuario ssh de produccion

# Uso

Para importar el dump de la base de datos que tenemos en local

```
php artisan dev:import_db
```

Para importar la base de datos de producción

```
php artisan dev:import_db --u
```