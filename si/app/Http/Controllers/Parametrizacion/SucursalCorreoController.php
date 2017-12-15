<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\SucursalCorreo;

class SucursalCorreoController extends Controller
{
	public static function Consultar(Request $request) {

        return SucursalCorreo::consultarTodo($request);
    }

	public static function ConsultarActivos(Request $request) {

        return SucursalCorreo::consultarActivo();
    }

    public function Guardar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(new SucursalCorreo(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(SucursalCorreo::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function CambiarEstado(Request $request) {

    	$clase = SucursalCorreo::Find((int)$request->get('id'));

    	$clase->estado = $request->get('estado');

    	$mensaje = ['Se cambió el estado correctamente',
                    'Se encontraron problemas al cambiar el estado'];

    	return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return SucursalCorreo::eliminar($request);
    }


    private function insertarCampos($clase,$request) {

        $clase->id_sucursal = $request->get('id_sucursal');
        $clase->correo = $request->get('correo');

        return $clase;
    }


    public function verificacion($request){

        $campos = array(
            'correo' => 'Debe digitar el campo correo para continuar',
        );

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }
}