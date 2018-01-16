<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Municipio;

class MunicipioController extends Controller
{
	public static function ConsultarPorDepartamento(Request $request) {

        return Municipio::ConsultarPorDepartamento(
            $request,
            $request->get('id_departamento'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );
    }


 	public static function Consultar(Request $request) {

        return Municipio::consultar($request);
    }


    public function Guardar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(new Municipio(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(Municipio::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return Municipio::eliminar($request);
    }


    private function insertarCampos($clase,$request) {

    	$request->get('id_departamento') ? $clase->id_departamento = $request->get('id_departamento') : '';
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