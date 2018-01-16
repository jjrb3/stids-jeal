<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\EmpresaValores;

class EmpresaValoresController extends Controller
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
     * @date: 2018-01-04 - 05:15 PM
     * @see: 1. EmpresaValores::consultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function Consultar(Request $request) {

        $objeto = EmpresaValores::ConsultarTodo(
            $request,
            $request->get('id_empresa'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-04 - 05:20 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. EmpresaValores::ConsultarPorNombreEmpresa.
     *       3. EmpresaValores::find.
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
        $existeRegistro = EmpresaValores::ConsultarPorNombreEmpresa(
            $request,
            $request->get('nombre'),
            $request->session()->get('id_empresa')
        );


        #3. Que no se encuentre ningun error
        if (!is_null($existeRegistro)) {

            #3.1. Si existe y no esta eliminado
            if ($existeRegistro->count() && $existeRegistro[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado entonces lo vuelve a activar
            elseif ($existeRegistro->count() && $existeRegistro[0]->estado < 0) {

                $clase = EmpresaValores::find($existeRegistro[0]->id);

                $clase->estado = 1;

                $transaccion = [$request,6,'actualizar','s_empresa_valores'];

                return self::$hs->ejecutarSave($clase,self::$hs->mensajeGuardar,$transaccion);
            }
            #3.3. Si no existe entonces se crea
            else {

                $clase = new EmpresaValores();

                $clase->nombre      = $request->get('nombre');
                $clase->id_empresa  = $request->get('id_empresa');

                $transaccion = [$request,6,'crear','s_empresa_valores'];

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
     * @date: 2018-01-04 - 05:38 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. EmpresaValores::find.
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
        $clase = EmpresaValores::find((int)$request->get('id'));

        $clase->nombre = $request->get('nombre');

        $transaccion = [$request, 6, 'actualizar', 's_empresa_valores'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeActualizar,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-04 - 05:39 PM
     * @see: 1. EmpresaValores::find.
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
        $clase = EmpresaValores::Find((int)$request->get('id'));

        $clase->estado = -1;

        $transaccion = [$request,6,'eliminar','s_empresa_valores'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,$transaccion);
    }
}