<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Sucursal;


class SucursalController extends Controller
{
    public static $hs;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
    }


	public static function ConsultarPorEmpresa(Request $request) {

        return Empresa::consultarActivo();
    }
    

    public static function Consultar(Request $request) {

        return Empresa::consultarTodo($request);
    }


    public static function ConsultarId(Request $request) {

        return response()->json(Empresa::consultarId($request->get('id')));
    }


    public static function ConsultarEmpresaSistema(Request $request) {

        return Empresa::sistema();
    }


    public function Guardar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }


        $clase = $this->insertarCampos(new Sucursal(),$request);

        
        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Actualizar(Request $request)
    {
        if (!Sucursal::consultarIdEmpresa((int)$request->get('id_empresa'))) {
            return $this->Guardar($request);
        }
        else {

            if ($this->verificacion($request)) {
                return $this->verificacion($request);
            }


            $clase = $this->insertarCampos(Sucursal::consultarIdEmpresa((int)$request->get('id_empresa'))[0],$request);

            $mensaje = ['Se actualizó correctamente',
                        'Se encontraron problemas al actualizar'];

            return HerramientaStidsController::ejecutarSave($clase,$mensaje);
        }
    }


    private function insertarCampos($clase,$request) {
        
        $clase->id_empresa     	= $request->get('id_empresa');
        $clase->id_municipio    = $request->get('id_municipio');
        $clase->codigo          = $request->get('codigo');
        $clase->nombre          = $request->get('nombre');
        $clase->telefono        = $request->get('telefono');
        $clase->direccion       = $request->get('direccion');
        $clase->quienes_somos   = $request->get('quienes_somos');
        $clase->que_hacemos     = $request->get('que_hacemos');
        $clase->mision          = $request->get('mision');
        $clase->vision          = $request->get('vision');


        return $clase;
    }


    public function verificacion($request) {

        $campos = array(
            'id_municipio' => 'Debe seleccionar el municipio para continuar',
            'codigo' => 'Debe digitar el campo codigo para continuar',
            'nombre' => 'Debe digitar el campo nombre para continuar',
        );

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 04:45 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Sucursal::ConsultarPorEmpresa.
     *       3. Sucursal::find.
     *       4. self::$hs->ejecutarSave.
     *
     * Actualizar datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function ActualizarPorEmpresa(Request $request)
    {
        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'codigo'        => 'Digite el codigo para poder guardar los cambios',
            'id_municipio'  => 'Seleccione una ciudad para poder guardar los cambios',
            'nombre'        => 'Seleccione un nombre de sucursal para poder guardar los cambios'
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Consultamos si existe
        $existeRegistro = Sucursal::ConsultarPorEmpresa(
            $request,
            $request->get('id_empresa')
        );


        #3. Que no se encuentre ningun error
        if (!is_null($existeRegistro)) {

            #3.1. Si existe el registro se actualiza
            if ($existeRegistro->count()) {

                $clase = Sucursal::find($existeRegistro[0]->id);

                $transaccion = [$request,6,'actualizar','s_sucursal'];
            }
            #3.2. Si no existe entonces se crea
            else {

                $clase = new Sucursal();

                $transaccion = [$request,6,'crear','s_sucursal'];
            }

            $clase->id_empresa      = $request->get('id_empresa');
            $clase->id_municipio    = $request->get('id_municipio');
            $clase->codigo          = $request->get('codigo');
            $clase->nombre          = $request->get('nombre');
            $clase->telefono        = $request->get('telefono');
            $clase->direccion       = $request->get('direccion');
            $clase->quienes_somos   = $request->get('quienes_somos');
            $clase->que_hacemos     = $request->get('que_hacemos');
            $clase->mision          = $request->get('mision');
            $clase->vision          = $request->get('vision');
            $clase->estado          = 1;

            return self::$hs->ejecutarSave($clase,self::$hs->mensajeGuardar,$transaccion);
        }
        else {
            return response()->json(self::$hs->jsonError);
        }
    }
}