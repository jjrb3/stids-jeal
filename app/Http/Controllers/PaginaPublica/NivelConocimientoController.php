<?php

namespace App\Http\Controllers\PaginaPublica;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\PaginaPublica\NivelConocimiento;
use Illuminate\Http\Request;

use App\Models\PaginaPublica\PlanesCaracteristicas;

class NivelConocimientoController extends Controller
{
    public static function Consultar(Request $request) {

        return response()->json(
            NivelConocimiento::consultarTodo(
                $request->get('buscador'),
                $request->get('pagina'),
                $request->get('tamanhioPagina')
            )
        );
    }

    public function Guardar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(new NivelConocimiento(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return response()->json(NivelConocimiento::eliminarPorId($request->get('id')));
    }


    private function insertarCampos($clase,$request) {

        $clase->id_empresa  = $request->session()->get('idEmpresa');
        $clase->nombre      = $request->get('nombre');
        $clase->color       = $request->get('color');
        $clase->porcentaje  = $request->get('porcentaje');

        return $clase;
    }


    public function verificacion($request){

        $campos = array(
            'nombre' => 'Debe digitar el campo nombre para continuar',
            'color' => 'Debe digitar el campo color para continuar',
            'porcentaje' => 'Debe digitar el campo porcentaje para continuar',
        );

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }
}