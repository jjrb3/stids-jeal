<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Prestamo\PrestamoDetallePago;
use Illuminate\Http\Request;

use App\Models\Prestamo\PrestamoDetalle;
use App\Models\Prestamo\Prestamo;


class PrestamoDetalleController extends Controller
{
    public static function ConsultarPorPrestamo(Request $request) {

        return PrestamoDetalle::consultarPorPrestamo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhioPagina'),
            $request->get('id')
        );
    }

    public static function ConsultById(Request $request) {

        $result = PrestamoDetalle::ConsultById(
            $request->get('id')
        );

        return response()->json(array(
            'data' => $result,
            'success' => $result ? true : false,
        ));
    }


    public static function guardarPorCadena($idPrestamo, $cadena, $request,$idCliente,$idFormaPago, $cuota = 0, $refinanciacion = 0) {

        $columnas    = array_filter(explode('}',$cadena));
        $mensaje     = ['Se guardó correctamente','Se encontraron problemas al guardar'];
        $transaccion = [$request,32,'crear','p_prestamo_detalle'];
        $jsonResult  = [];


        foreach ($columnas as $columna) {

            $data = array_filter(explode(';',$columna));

            $clase = new PrestamoDetalle();

            $clase->id_empresa          = $request->session()->get('idEmpresa');
            $clase->id_cliente          = $idCliente;
            $clase->id_prestamo         = $idPrestamo;
            $clase->id_forma_pago       = $idFormaPago;
            $clase->id_estado_pago      = $refinanciacion > 0 ? 11 : 4;
            $clase->no_cuota            = $data[0] + $cuota;
            $clase->fecha_pago          = $data[1];
            $clase->capital             = $data[2];
            $clase->amortizacion        = $data[3];
            $clase->intereses           = $data[4];
            $clase->total               = $data[5];
            $clase->no_refinanciacion   = $refinanciacion;

            $jsonResult[] = HerramientaStidsController::ejecutarSave($clase,$mensaje,$transaccion);

        }

        return $jsonResult;
    }


    public function Guardar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(new Prestamo(),$request);

        $clase->no_prestamo = Prestamo::obtenerNoPrestamo($request) + 1;

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        $transaccion = [$request,32,'crear','p_prestamo'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje,$transaccion);
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-08 - 10:57 am
     * @see 1. HerramientaStidsController::verificationDatas.
     *
     * Agrega un pago con valor superior al saldo de la fecha de pago.
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return array
     */
    public function AddPaymentWithHigherValue(Request $request)
    {
        $result = HerramientaStidsController::verificationDatas(
            $request,
            array(
                'saldo' => 'Debe digitar el saldo para continuar',
            )
        );

        if ($result) {return $result;}

        return PrestamoDetalle::pagarCuota(
            $request,
            $request->get('saldo'),
            $request->get('id_prestamo')
        );
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 2.0
     * @date 2017-11-11 - 11:19 AM
     * @see 1. HerramientaStidsController::verificationDatas.
     *      2. HerramientaStidsController::ejecutarSave.
     *      3. PrestamoDetalle::actualizarFechaDesdeCuota.
     *
     * Actualiza la información de un pago
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json
     */
    public function UpdateModal(Request $request) {

        #1. Verificamos los campos
        if ($resultado = HerramientaStidsController::verificacionCampos(
                $request,
                'fecha_pago',
                'Debe digitar la fecha de pago para continuar'
            )) {
            return $resultado;
        }


        #2. Asignamos el valor de la mora
        $mora = $request->get('mora') ? (int)$request->get('mora') : 0;


        #3. Obtenemos
        $clase = PrestamoDetalle::Find((int)$request->get('id'));

        $clase->total       = $clase->amortizacion + $clase->intereses + $mora;
        $clase->fecha_pago  = $request->get('fecha_pago');
        $clase->mora        = $mora;
        $clase->total       = $clase->amortizacion + $clase->intereses + $clase->mora;
        $clase->observacion = $request->get('observacion');

        $mensaje     = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
        $transaccion = [$request,32,'actualizar','p_prestamo_detalle'];


        #4. Actualizamos
        $resultado = HerramientaStidsController::ejecutarSave($clase,$mensaje,$transaccion);


        #5. Actualizamos la fecha de todas las cuotas que sean mayores a la cuota actual
        PrestamoDetalle::actualizarFechaDesdeCuota($request,$clase->id_prestamo,$clase->no_cuota,$request->get('fecha_pago'));

        return $resultado;
    }


    public function Eliminar($request)
    {
        return PrestamoDetalle::eliminarPorId($request,$request->get('id'));
    }


    private function insertarCampos($clase,$request) {

        if (!$request->get('actualizacionRapida')) {

            $clase->id_empresa          = $request->session()->get('idEmpresa');
            $clase->id_cliente          = $request->get('id_cliente');
            $clase->id_forma_pago       = $request->get('id_forma_pago');
            $clase->id_estado_pago      = 4;
            $clase->id_tipo_prestamo    = $request->get('id_tipo_prestamo');
            $clase->monto_requerido     = $request->get('monto_requerido');
            $clase->intereses           = $request->get('interes');
            $clase->no_cuotas           = $request->get('no_cuotas');
            $clase->total_intereses     = $request->get('total_intereses');
            $clase->total               = $request->get('total');
            $clase->fecha_pago_inicial  = $request->get('fecha_pago_inicial');
        }
        else {
            $clase->fecha_pago = $request->get('fecha_pago');
        }

        return $clase;
    }


    public function verificacion($request){

        $camposRapidos = array(
            'fecha_pago' => 'Debe digitar la fecha de pago para continuar',
        );

        $camposCompletos = array(
            'id_cliente'         => 'Debe seleccionar el cliente para continuar',
            'monto_requerido'    => 'Debe digitar el monto requerido para continuar',
            'interes'            => 'Debe digitar el campo interes para continuar',
            'id_forma_pago'      => 'Debe seleccionar la forma de pago para continuar',
            'no_cuotas'          => 'Debe digitar el numero de cuotas para continuar',
            'fecha_pago_inicial' => 'Debe digitar el campo fecha de pago inicial para continuar para continuar',
        );

        $campos = $request->get('actualizacionRapida') ? $camposRapidos : array_merge($camposCompletos,$camposRapidos);

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }
}