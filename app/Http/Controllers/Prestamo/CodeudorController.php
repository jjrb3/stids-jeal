<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Prestamo\Codeudor;


class CodeudorController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 31, '', 'p_codeudor'];
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-13 - 07:59 PM
     * @see: 1. Codeudor::consultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarPorClientePaginado(Request $request) {

        $objeto = Codeudor::consultarTodo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->get('id_cliente')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-13 - 12:45 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Codeudor::ConsultarPorEmpTipIdeNomApe.
     *       3. Codeudor::find.
     *       4. self::$hs->ejecutarSave.
     *
     * Crea o actualiza los datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CrearActualizar(Request $request)
    {
        #1. Verificamos los datos enviados
        $id         = $request->get('id');
        $idCliente  = $request->get('id_cliente');

        #1.1. Datos obligatorios
        $datos = [
            'cedula' => 'Debe digitar la cedula para poder guardar los cambios',
            'nombres' => 'Debe digitar los nombres para poder guardar los cambios',
            'apellidos' => 'Debe digitar los apellidos para poder guardar los cambios',
            'direccion' => 'Debe digitar la dirección para poder guardar los cambios',
            'celular' => 'Debe digitar el celular para poder guardar los cambios'
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Si no es actualización consultamos si existe
        if (!$id) {
            $existeRegistro = Codeudor::ConsultarPorCliCedNomApe(
                $request,
                $idCliente,
                $request->get('cedula'),
                $request->get('nombres'),
                $request->get('apellidos')
            );
        }
        else {
            $existeRegistro[] = Codeudor::find($id);
        }

        #3. Que no se encuentre ningun error
        if (!is_null($existeRegistro)) {

            #3.1. Si existe, no esta eliminado y no es una actualización
            if (!$id && $existeRegistro->count() && $existeRegistro[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado o es una actualizacion lo vuelve a activar y actualiza todos sus datos
            elseif ($id || $existeRegistro->count() && $existeRegistro[0]->estado < 0) {

                $clase = $this->insertarCampos(Codeudor::find($existeRegistro[0]->id), $request);

                self::$transaccion[0] = $request;
                self::$transaccion[2] = 'actualizar';

                return self::$hs->ejecutarSave(
                    $clase,
                    $id ? self::$hs->mensajeActualizar : self::$hs->mensajeGuardar,
                    self::$transaccion
                );
            }
            #3.3. Si no existe entonces se crea
            else {

                $clase = $this->insertarCampos(new Codeudor(), $request);

                self::$transaccion[0] = $request;
                self::$transaccion[2] = 'crear';

                return self::$hs->ejecutarSave($clase, self::$hs->mensajeGuardar, self::$transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 08:29 PM
     *
     * Insertar campos.
     *
     * @param object  $clase:   Clase a llenar.
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    private function insertarCampos($clase,$request) {

        $clase->id_cliente          = $request->get('id_cliente');
        $clase->cedula              = $request->get('cedula');
        $clase->fecha_expedicion    = $request->get('fecha_expedicion');
        $clase->nombres             = $request->get('nombres');
        $clase->apellidos           = $request->get('apellidos');
        $clase->direccion           = $request->get('direccion');
        $clase->telefono            = $request->get('telefono');
        $clase->celular             = $request->get('celular');
        $clase->estado              = 1;

        return $clase;
    }


}