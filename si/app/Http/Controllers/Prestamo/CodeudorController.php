<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Prestamo\Codeudor;


class CodeudorController extends Controller{

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 10:10 AM
     * @see: 1. Codeudor::consultarPorIdCliente.
     *
     * Consulta el listado de codeudores por el cliente
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return json: Codeudor
     */
    public static function ConsultarPorIdCliente(Request $request) {

        return response()->json(Codeudor::consultarPorIdCliente($request->get('id')));
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 11:59 AM
     * @see: 1. Codeudor::consultarPorId.
     *
     * Consulta el listado de codeudores por id
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return json: Codeudor
     */
    public static function ConsultarPorId(Request $request) {

        return response()->json(Codeudor::consultarPorId($request->get('id')));
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-23 - 10:57 am
     * @see 1. HerramientaStidsController::verificationDatas.
     *      2. HerramientaStidsController::ejecutarSave.
     *
     * Guardamos un codeudor.
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json: Resultado de guardar
     */
    public function Guardar(Request $request)
    {
        $result = HerramientaStidsController::verificationDatas(
            $request,
            array(
                'cedula'            => 'Debe digitar la cedula para continuar',
                'fecha_expedicion'  => 'Debe digitar la fecha de expedición para continuar',
                'nombres'           => 'Debe digitar los nombres para continuar',
                'apellidos'         => 'Debe digitar los apellidos para continuar',
                'direccion'         => 'Debe digitar la dirección para continuar',
            )
        );


        if ($result) {return $result;}


        $transaccion    = [$request,31,'crear','p_codeudor'];
        $message        = ['Se guardó correctamente','Se encontraron problemas al guardar'];


        $codeudor = new Codeudor();

        $codeudor->id_cliente       = trim($request->get('id_cliente'));
        $codeudor->cedula           = trim($request->get('cedula'));
        $codeudor->fecha_expedicion = trim($request->get('fecha_expedicion'));
        $codeudor->nombres          = trim($request->get('nombres'));
        $codeudor->apellidos        = trim($request->get('apellidos'));
        $codeudor->direccion        = trim($request->get('direccion'));
        $codeudor->telefono         = trim($request->get('telefono'));
        $codeudor->celular          = trim($request->get('celular'));

        return HerramientaStidsController::ejecutarSave($codeudor,$message,$transaccion);
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-23 - 10:57 am
     * @see 1. HerramientaStidsController::verificationDatas.
     *      2. HerramientaStidsController::ejecutarSave.
     *
     * Actualizamos un codeudor.
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json: Resultado de actualizar
     */
    public function Actualizar(Request $request)
    {
        $result = HerramientaStidsController::verificationDatas(
            $request,
            array(
                'cedula'            => 'Debe digitar la cedula para continuar',
                'fecha_expedicion'  => 'Debe digitar la cedula para continuar',
                'nombres'           => 'Debe digitar la cedula para continuar',
                'apellidos'         => 'Debe digitar la cedula para continuar',
                'direccion'         => 'Debe digitar la cedula para continuar',
            )
        );


        if ($result) {return $result;}


        $transaccion    = [$request,31,'actualizar','p_codeudor'];
        $message        = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];


        $codeudor = Codeudor::Find((int)trim($request->get('id')));

        $codeudor->id_cliente       = trim($request->get('id_cliente'));
        $codeudor->cedula           = trim($request->get('cedula'));
        $codeudor->fecha_expedicion = trim($request->get('fecha_expedicion'));
        $codeudor->nombres          = trim($request->get('nombres'));
        $codeudor->apellidos        = trim($request->get('apellidos'));
        $codeudor->direccion        = trim($request->get('direccion'));
        $codeudor->telefono         = trim($request->get('telefono'));
        $codeudor->celular          = trim($request->get('celular'));

        return HerramientaStidsController::ejecutarSave($codeudor,$message,$transaccion);
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-23 - 3:23 PM
     * @see 1. Codeudor::eliminarPorId.
     *
     * Eliminamos un codeudor.
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json: Resultado de eliminar
     */
    public function Eliminar($request)
    {
        return Codeudor::eliminarPorId($request,$request->get('id'));
    }
}