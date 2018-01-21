<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Prestamo\PrestamoDetallePago;
use Illuminate\Http\Request;

use App\Models\Prestamo\PrestamoDetalle;
use App\Models\Prestamo\Prestamo;


class PrestamoDetalleController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 32, '', 'p_prestamo_detalle'];
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date_create 2018-01-17 - 05:20 PM
     * @see 1. PrestamoDetalle::consultarTodo.
     *      2. self::$hs->jsonError.
     *
     * Consultamos todos los datos activos del prestamo
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarPorPrestamo(Request $request) {

        $objeto = PrestamoDetalle::ConsultarTodoPorPrestamo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->get('idPrestamo'),
            $request->session()->get('idEmpresa')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
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


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-18 - 03:41 PM
     *
     * Guardar detalle del prestamo por cadena.
     *
     * @param request $request:         Peticiones realizadas.
     * @param object  $idPrestamo:      ID del prestamo.
     * @param request $cadena:          Cadena de listado de cuotas a guardar.
     * @param request $idCliente:       ID del cliente.
     * @param request $idFormaPago:     ID de la forma de pago.
     * @param request $cuota:           Cuota.
     * @param request $refinanciacion:  Numero de refinanciación.
     *
     * @return array
     */
    public function GuardarPorCadena($request, $idPrestamo, $cadena, $idCliente, $idFormaPago, $cuota = 0, $refinanciacion = 0) {

        $columnas    = array_filter(explode('}',$cadena));
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
            $clase->saldo_inicial       = $data[2];
            $clase->cuota               = $data[3];
            $clase->intereses           = $data[4];
            $clase->abono_capital       = $data[5];
            $clase->saldo_final         = isset($data[6]) ? $data[6] : 0;
            $clase->no_refinanciacion   = $refinanciacion;

            self::$transaccion[0] = $request;
            self::$transaccion[2] = 'crear';

            $jsonResult[] = self::$hs->ejecutarSave($clase, self::$hs->mensajeGuardar, self::$transaccion)->original;
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


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2018-01-21 - 09:01 AM
     * @see 1. HerramientaStidsController::verificationDatas.
     *
     * Realiza un pago.
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return object
     */
    public function GuardarPago(Request $request) {

        #0. Inicializacion de variables
        $idEmpresa   = $request->session()->get('idEmpresa');
        $idPrestamo  = $request->get('id_prestamo');
        $valor       = $request->get('valor');
        $observacion = $request->get('observacion');
        $rPago       = [];
        $estado      = 10;  # Al dia


        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'valor' => 'Debe digitar el valor que desea pagar para poder guardar los cambios',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Verificamos si tiene pagos atrasados
        $saldoAtrasado = PrestamoDetalle::ConsultarSaldoAtrasado($request, $idEmpresa, $idPrestamo)[0];

        if ($saldoAtrasado->saldo > 0) {

            $clase = PrestamoDetalle::find($saldoAtrasado->id);

            #2.1. Si el valor a pagar es mayor que la deuda entonces
            if ($valor > $saldoAtrasado->saldo) {

                $valor -= $saldoAtrasado->saldo;
                $estado = 10; #Al dia
            }
            else {
                $estado = 12; #Atrasado
            }

            $clase->valor_pagado    = $saldoAtrasado->saldo;
            $clase->id_estado_pago  = $estado;

            self::$transaccion[0] = $request;
            self::$transaccion[2] = 'crear';

            #2.1. Guardamos el pago en la cuota.
            //$rPago[] = self::$hs->Guardar($request, $clase, self::$hs->mensajeGuardar, self::$transaccion);

            #2.2. Guardamos el pago en la tabla de pagos.
            $PDP = new PrestamoDetallePagoController();

            /*$rPago[] = $PDP->GuardarPago(
                $request,
                $saldoAtrasado->id,
                $estado,
                $saldoAtrasado->saldo,
                $observacion
            );*/
        }

        if ($valor > 0) {

            $cuotas = PrestamoDetalle::ConsultarPorFechaMayor();
        }

        die;
    }
}