<?php

namespace App\Http\Controllers\PaginaPublica;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\PaginaPublica\Planes;
use App\Models\PaginaPublica\PlanesCaracteristicas;

class PlanesController extends Controller
{
    public static function Consultar(Request $request) {

        return Planes::consultarTodo(
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhioPagina')
        );
    }


    public function Guardar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(new Planes(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(Planes::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return Planes::eliminarPorId($request->get('id'));
    }


    private function insertarCampos($clase,$request) {

        $clase->id_empresa  = $request->session()->get('idEmpresa');
        $clase->nombre      = $request->get('nombre');
        $clase->descripcion = $request->get('descripcion');
        $clase->valor       = $request->get('valor');

        return $clase;
    }


    public function verificacion($request){

        $campos = array(
            'nombre' => 'Debe digitar el campo nombre para continuar',
            'valor' => 'Debe digitar el campo precio para continuar',
        );

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }


    public static function Detalle(Request $request) {

        return PlanesCaracteristicas::consultarId($request->get('id'));
    }
}