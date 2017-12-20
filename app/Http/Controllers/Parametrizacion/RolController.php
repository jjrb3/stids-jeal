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

        $objeto  = Rol::consultarTodo(
            $request,
            $request->session()->get('idEmpresa'),
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

        $objeto = Rol::consultarActivo(
            $request,
            $request->session()->get('idEmpresa')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 11:49 AM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Rol::ConsultarPorNombreEmpresa.
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
        $R = Rol::ConsultarPorNombreEmpresa(
            $request,
            $request->get('nombre'),
            $request->session()->get('idEmpresa')
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

                $clase->id_empresa  = $request->session()->get('idEmpresa');
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


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(Rol::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function CambiarEstado(Request $request) {

    	$clase = Rol::Find((int)$request->get('id'));

    	$clase->estado = $request->get('estado');

    	$mensaje = ['Se cambió el estado correctamente',
                    'Se encontraron problemas al cambiar el estado'];

    	return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return Rol::eliminar($request);
    }


    private function insertarCampos($clase,$request) {

        $clase->id_empresa = $request->session()->get('idEmpresa');
        $clase->nombre = $request->get('nombre');
        $clase->estado = 1;

        return $clase;
    }


    public function verificacion($request){

        $campos = array(
            'nombre' => 'Debe digitar el campo nombre para continuar',
        );

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }
}