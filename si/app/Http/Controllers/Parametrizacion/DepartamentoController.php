<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Departamento;

class DepartamentoController extends Controller
{
    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-15 - 09:23 AM
     * @see: 1. Departamento::consultarPorPais.
     *
     * Consultar los departamentos por pais
     *
     * @param request $request:     Peticiones realizadas.
     *
     * @return object
     */
	public static function ConsultarPorPais(Request $request) {

        return Departamento::ConsultarPorPais(
            $request,
            $request->get('id_pais'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );
    }


    public function Guardar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(new Departamento(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(Departamento::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return Departamento::eliminar($request);
    }


    private function insertarCampos($clase,$request) {

    	$request->get('id_pais') ? $clase->id_pais = $request->get('id_pais') : '';
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