<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Rol;

class RolController extends Controller
{
	public static function Consultar(Request $request) {

        return Rol::consultarTodo($request);
    }

	public static function ConsultarActivos(Request $request) {

        return Rol::consultarActivo($request);
    }

    public function Guardar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(new Rol(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
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