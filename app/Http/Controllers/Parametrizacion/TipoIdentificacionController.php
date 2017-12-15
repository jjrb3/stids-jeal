<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\TipoIdentificacion;

class TipoIdentificacionController extends Controller
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
     * @date: 2017-12-13 - 10:16 AM
     * @see: 1. TipoIdentificacion::consultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function Consultar(Request $request) {

        return TipoIdentificacion::consultarTodo(
            $request,
            $request->session()->get('idEmpresa'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-13 - 10:16 AM
     * @see: 1. TipoIdentificacion::consultarActivo.
     *
     * Consultar activos
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarActivos(Request $request) {

        return TipoIdentificacion::consultarActivo(
            $request,
            $request->session()->get('idEmpresa')
        );
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-13 - 10:49 AM
     * @see: 1. self::$hs->verificationDatas.
     *       2. TipoIdentificacion::ConsultarPorNombreEmpresa.
     *       3. TipoIdentificacion::find.
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
        $TI = TipoIdentificacion::ConsultarPorNombreEmpresa(
            $request,
            $request->get('nombre'),
            $request->session()->get('idEmpresa')
        );

        #3. Que no se encuentre ningun error
        if (!is_null($TI)) {

            #3.1. Si existe y no esta eliminado
            if ($TI->count() && $TI[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado entonces lo vuelve a activar
            elseif ($TI->count() && $TI[0]->estado < 0) {

                $clase = TipoIdentificacion::find($TI[0]->id);

                $clase->estado = 1;

                $transaccion = [$request,4,'actualizar','s_tipo_identificacion'];

                return self::$hs->ejecutarSave($clase,self::$hs->mensajeGuardar,$transaccion);
            }
            #3.3. Si no existe entonces se crea
            else {

                $clase = new TipoIdentificacion();

                $clase->id_empresa  = $request->session()->get('idEmpresa');
                $clase->nombre      = $request->get('nombre');
                $clase->estado      = 1;

                $transaccion = [$request,4,'crear','s_tipo_identificacion'];

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
     *       2. TipoIdentificacion::find.
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
        $clase = TipoIdentificacion::find((int)$request->get('id'));

        $clase->nombre = $request->get('nombre');

        $transaccion = [$request, 4, 'actualizar', 's_tipo_identificacion'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeActualizar,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-13 - 11:57 AM
     * @see: 1. TipoIdentificacion::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Cambia de estado datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CambiarEstado(Request $request) {

        $clase  = TipoIdentificacion::Find((int)$request->get('id'));

        if ($clase->estado === 1) {
            $clase->estado = 0;
        }
        elseif ($clase->estado === 0) {
            $clase->estado = 1;
        }

        $transaccion = [$request,4,self::$hs->estados[$clase->estado],'s_tipo_identificacion'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEstado,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-13 - 11:57 AM
     * @see: 1. TipoIdentificacion::find.
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
        $clase = TipoIdentificacion::Find((int)$request->get('id'));

        $clase->estado = -1;

        $transaccion = [$request,4,'eliminar','s_tipo_identificacion'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,$transaccion);
    }
}