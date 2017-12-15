<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Sucursal;


class SucursalController extends Controller
{
	public static function ConsultarActivos(Request $request) {

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
}