<?php

namespace Gragot\LaravelDevTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Route as Ruta;
use Illuminate\Support\Facades\Route;

class RutaSinTest extends Command
{
    protected $signature = 'ruta_sin_test';

    private $controladorMetodoString;

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
     *
     * @return mixed
     */
    public function handle()
    {
        $routeCollection = Route::getRoutes(); /** @var Ruta $ruta */

        foreach ($routeCollection as $ruta)
        {

            try {

                if(substr($ruta->getAction()['controller'], 0, 3) != 'App' || $ruta->action['prefix'] == 'api') {
                    // Descartamos los controladores que nos son de la aplicacción
                    // Descartamos la rutas que son de api
                    continue;
                }

                $this->controladorMetodoString = $ruta->action['controller'];
                $controladorMetodo = explode('@', $ruta->action['controller']);
                $metodo = $controladorMetodo[1];
                $rutaControlador = str_replace('App\Http\Controllers\\', '', $controladorMetodo[0]);
                $rutaControlador = explode('\\', $rutaControlador);

                $ultimaSeccion = $rutaControlador[count($rutaControlador) - 1];

                $rutaActual = base_path('tests'.DIRECTORY_SEPARATOR.'Feature');
                $metodoTransformado = $this->transformarTexto($metodo);

                foreach ($rutaControlador as $rutaSeccion)
                {
                    $rutaActual .= DIRECTORY_SEPARATOR . $this->transformarTexto($rutaSeccion);

                    if($ultimaSeccion == $rutaSeccion) {
                        if(!file_exists($rutaActual)) {
                            $this->dumpRuta($ruta);
                            dd('No existe la ruta: ' . $rutaActual . ' para el controlador '. $rutaSeccion);
                        } else {
                            $metodoTransformado = $this->barrasBajasPorPrimeraMayuscula($metodoTransformado);
                            $rutaActual .= DIRECTORY_SEPARATOR . ucfirst($metodoTransformado) . 'Test.php';
                            if(!file_exists($rutaActual)) {
                                $this->dumpRuta($ruta);
                                dd('No existe el archivo: ' . $rutaActual . ' para el controlador '. $rutaSeccion . 'y método ' . $metodoTransformado);
                            }
                        }

                    } else {
                        if(!file_exists($rutaActual)) {
                            dd('No existe la ruta: '.$rutaActual);
                        }
                    }
                }

            } catch (\Exception $e) {

                throw $e;

            }
        }
    }

    public function barrasBajasPorPrimeraMayuscula($texto)
    {
        $textoTransformado = '';

        $mayuscula = true;
        for ($i = 0; $i < strlen($texto); $i++)
        {
            if($texto[$i] == '_') {
                $mayuscula = true;
                continue;
            }

            if($mayuscula) {
                $textoTransformado .= ucfirst($texto[$i]);
                $mayuscula = false;
            } else {
                $textoTransformado .= $texto[$i];
            }
        }

        return $textoTransformado;
    }

    public function transformarTexto($texto)
    {
        $rutaSeccionMinuscula = lcfirst($texto);
        $seccionTransformada = '';

        for ($i = 0; $i < strlen($texto); $i++)
        {
            $letra = $rutaSeccionMinuscula[$i];
            if(ctype_upper($letra)) {
                $letra = strtoupper($letra);
            }
            $seccionTransformada .= $letra;
        }

        return $seccionTransformada;
    }

    public function dumpRuta($ruta) {
        dump($ruta->getName());
        dump($this->controladorMetodoString);
    }
}
