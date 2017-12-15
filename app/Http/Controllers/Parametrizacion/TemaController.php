<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Tema;

class TemaController extends Controller
{
    public static function Consultar(Request $request) {

        return Tema::consultarTodo($request);
    }


    public static function ConsultarTodo(Request $request) {

        return Tema::consultar($request);
    }


    public static function ConsultarId(Request $request) {

        return response()->json(Tema::consultarId($request));
    }


    public function Guardar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(new Tema(),$request);

        
        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(Tema::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }
    

    public function CambiarEstado(Request $request) {

    	$clase = Tema::Find((int)$request->get('id'));

    	$clase->estado = $request->get('estado');

    	$mensaje = ['Se cambió el estado correctamente',
                    'Se encontraron problemas al cambiar el estado'];

    	return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return Tema::eliminar($request);
    }


    private function insertarCampos($clase,$request) {

        $clase->nombre                  = $request->get('nombre');
        $clase->nombre_usuario          = $request->get('nombre_usuario');
        $clase->nombre_administrador    = $request->get('nombre_administrador');
        $clase->nombre_logueo           = $request->get('nombre_logueo');

        return $clase;
    }


    public function verificacion($request){


        $campos = array(
            'nombre' => 'Debe digitar el campo nombre para continuar',
            'nombre_usuario' => 'Debe digitar el campo nombre de la sesión de usuario para continuar',
            'nombre_administrador' => 'Debe digitar el campo nombre de la sesión de administrador para continuar',
            'nombre_logueo' => 'Debe digitar el campo nombre de la sesión de logueo para continuar',
        );

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }
}