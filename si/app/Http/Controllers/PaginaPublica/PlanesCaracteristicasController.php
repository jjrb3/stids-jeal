<?php

namespace App\Http\Controllers\PaginaPublica;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\PaginaPublica\PlanesCaracteristicas;

class PlanesCaracteristicasController extends Controller
{
    public function Guardar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(new PlanesCaracteristicas(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(PlanesCaracteristicas::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return response()->json(PlanesCaracteristicas::eliminarPorId($request->get('id')));
    }


    private function insertarCampos($clase,$request) {

        if (!$request->get('id')) {
            $clase->id_planes = $request->get('id_planes_caracteristicas');
        }

        $clase->titulo      = $request->get('titulo');
        $clase->descripcion = $request->get('descripcion');

        return $clase;
    }


    public function verificacion($request){

        $campos = array(
            'titulo' => 'Debe digitar el campo titulo para continuar',
            'descripcion' => 'Debe digitar el campo descripcion para continuar',
        );

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }
}