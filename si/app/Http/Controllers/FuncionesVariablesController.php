<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuncionesVariablesController extends Controller
{
    /**
     * Ejecuta controlador y metodo
     *
     * @param Request
     * @return  JSON del crud ejecutado
     */
    public static function AsignarFuncion(Request $request) {

        $carpeta = $request->get('carpetaControlador') ? $request->get('carpetaControlador') . '\\' : '';
        $controlador = 'App\Http\Controllers\\' . $carpeta . $request->get('controlador') . 'Controller';
        $metodo = $request->get('funcionesVariables');

        if (method_exists($controlador, $metodo)) {

            $clase = new $controlador();

            return $clase->$metodo($request);
        }
        else {
            return response()->json([]);
        }
    }
}
