<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Rol;

class RolController extends Controller
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
     * @date: 2017-12-20 - 11:50 AM
     * @see: 1. Rol::consultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
	public static function Consultar(Request $request) {

	    $idEmpresa = $request->get('id_empresa') ? $request->get('id_empresa') : $request->session()->get('idEmpresa');

        $objeto  = Rol::consultarTodo(
            $request,
            $idEmpresa,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto ;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 12:01 PM
     * @see: 1. Rol::consultarActivo.
     *
     * Consultar activos
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
	public static function ConsultarActivos(Request $request) {

        $idEmpresa = $request->get('id_empresa') ? $request->get('id_empresa') : $request->session()->get('idEmpresa');

        $objeto = Rol::consultarActivo(
            $request,
            $idEmpresa
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 11:49 AM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Rol::ConsultarPorNombreEmpresa.
     *       3. Rol::find.
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

        $idEmpresa = $request->get('id_empresa') ? $request->get('id_empresa') : $request->session()->get('idEmpresa');

        #2. Consultamos si existe
        $R = Rol::ConsultarPorNombreEmpresa(
            $request,
            $request->get('nombre'),
            $idEmpresa
        );


        #3. Que no se encuentre ningun error
        if (!is_null($R)) {

            #3.1. Si existe y no esta eliminado
            if ($R->count() && $R[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado entonces lo vuelve a activar
            elseif ($R->count() && $R[0]->estado < 0) {

                $clase = Rol::find($R[0]->id);

                $clase->estado = 1;

                $transaccion = [$request,4,'actualizar','s_rol'];

                return self::$hs->ejecutarSave($clase,self::$hs->mensajeGuardar,$transaccion);
            }
            #3.3. Si no existe entonces se crea
            else {

                $clase = new Rol();

                $clase->id_empresa  = $idEmpresa;
                $clase->nombre      = $request->get('nombre');
                $clase->estado      = 1;

                $transaccion = [$request,4,'crear','s_rol'];

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
     * @date: 2017-12-13 - 11:42 AM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Rol::find.
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
        $clase = Rol::find((int)$request->get('id'));

        $clase->nombre = $request->get('nombre');

        $transaccion = [$request, 4, 'actualizar', 's_rol'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeActualizar,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 01:15 PM
     * @see: 1. Rol::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Cambia de estado datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CambiarEstado(Request $request) {

        $clase  = Rol::Find((int)$request->get('id'));

        if ($clase->estado === 1) {
            $clase->estado = 0;
        }
        elseif ($clase->estado === 0) {
            $clase->estado = 1;
        }

        $transaccion = [$request,4,self::$hs->estados[$clase->estado],'s_rol'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEstado,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 01:23 PM
     * @see: 1. Rol::find.
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
        $clase = Rol::Find((int)$request->get('id'));

        $clase->estado = -1;

        $transaccion = [$request,4,'eliminar','s_rol'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,$transaccion);
    }
}