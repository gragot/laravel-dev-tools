# Instalación

Añadir al composer.json el respositorio en la sección "repositories"

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

Crear el archivo dev_tools.php en app/config con el siguiente contenido:

```
<?php

return [
    'pro_db_database' => env('PRO_DB_DATABASE'),
    'dev_backups_db' => env('DEV_BACKUPS_DB'),
    'pro_host' => env('PRO_HOST'),
    'ssh_pro_user' => env('SSH_PRO_USER')
];

```

Añadir el service provider en el archivo "config/app.php" en la seccion "providers"

```
'providers' => [
    ...
    \Gragot\LaravelDevTools\ServiceProvider::class
    ...
]
```