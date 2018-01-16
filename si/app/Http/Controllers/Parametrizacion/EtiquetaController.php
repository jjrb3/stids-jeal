<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\Etiqueta;
use Illuminate\Http\Request;

use App\Models\Parametrizacion\Sexo;

class EtiquetaController extends Controller
{
    public static $hs;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 02:12 PM
     * @see: 1. Sexo::consultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    /*public static function Consultar(Request $request) {

        $objeto = Sexo::consultarTodo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }*/


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 02:15 PM
     * @see: 1. Sexo::consultarActivo.
     *
     * Consultar activos
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarActivos(Request $request) {

        $objeto = Etiqueta::consultarActivo(
            $request
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 02:17 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Sexo::ConsultarPorNombreEmpresa.
     *       3. Sexo::find.
     *       4. self::$hs->ejecutarSave.
     *
     * Guarda datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Guardar(Request $request)
    {
        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'nombre'   => 'Digite el nombre para poder guardar los cambios',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Consultamos si existe
        $S = Sexo::ConsultarPorNombreEmpresa(
            $request,
            $request->get('nombre')
        );


        #3. Que no se encuentre ningun error
        if (!is_null($S)) {

            #3.1. Si existe y no esta eliminado
            if ($S->count() && $S[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado entonces lo vuelve a activar
            elseif ($S->count() && $S[0]->estado < 0) {

                $clase = Sexo::find($S[0]->id);

                $clase->estado = 1;

                $transaccion = [$request,4,'actualizar','s_sexo'];

                return self::$hs->ejecutarSave($clase,self::$hs->mensajeGuardar,$transaccion);
            }
            #3.3. Si no existe entonces se crea
            else {

                $clase = new Sexo();

                $clase->nombre      = $request->get('nombre');
                $clase->estado      = 1;

                $transaccion = [$request,4,'crear','s_sexo'];

                return self::$hs->ejecutarSave($clase,self::$hs->mensajeGuardar,$transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 02:22 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Sexo::find.
     *       3. self::$hs->ejecutarSave.
     *
     * Actualiza datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Actualizar(Request $request)
    {
        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'nombre' => 'Digite el nombre para poder guardar los cambios',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Agregamos los nuevos parametros y actualizamos
        $clase = Sexo::find((int)$request->get('id'));

        $clase->nombre = $request->get('nombre');

        $transaccion = [$request, 4, 'actualizar', 's_sexo'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeActualizar,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 02:23 PM
     * @see: 1. Sexo::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Cambia de estado.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CambiarEstado(Request $request) {

        $clase  = Sexo::Find((int)$request->get('id'));

        if ($clase->estado === 1) {
            $clase->estado = 0;
        }
        elseif ($clase->estado === 0) {
            $clase->estado = 1;
        }

        $transaccion = [$request,4,self::$hs->estados[$clase->estado],'s_sexo'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEstado,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 02:23 PM
     * @see: 1. Sexo::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Elimina un dato por id.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Eliminar($request)
    {
        $clase = Sexo::Find((int)$request->get('id'));

        $clase->estado = -1;

        $transaccion = [$request,4,'eliminar','s_sexo'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,$transaccion);
    }
}