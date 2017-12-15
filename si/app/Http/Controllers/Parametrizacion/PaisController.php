<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Pais;

class PaisController extends Controller
{
	public static function ConsultarTodo(Request $request) {

        return Pais::consultarTodo();
    }

    public static function Consultar(Request $request) {

        return Pais::consultar($request);
    }

    public function Guardar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(new Pais(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(Pais::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return Pais::eliminar($request);
    }


    private function insertarCampos($clase,$request) {

        $clase->nombre = $request->get('nombre');

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