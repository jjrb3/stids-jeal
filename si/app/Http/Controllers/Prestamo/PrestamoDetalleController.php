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
     * @return object
     */
    public function ActualizarFecha(Request $request) {

        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'fecha' => 'Debe seleccionar una fecha poder actualizar los cambios',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Obtenemos
        $clase = PrestamoDetalle::Find((int)$request->get('id'));

        $clase->fecha_pago  = $request->get('fecha');

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'actualizar';


        #4. Actualizamos
        $resultado = self::$hs->Guardar($request, $clase, self::$hs->mensajeActualizar, self::$transaccion);


        #5. Actualizamos la fecha de todas las cuotas que sean mayores a la cuota actual
        PrestamoDetalle::ActualizarFechaDesdeCuota($request,$clase->id_prestamo,$clase->no_cuota,$request->get('fecha'));

        return $resultado;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-21 - 05:15 PM
     * @see: 1. PrestamoDetalle::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Elimina un dato por id.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Eliminar($request)
    {
        $clase = PrestamoDetalle::Find((int)$request->get('id'));

        $clase->estado = -1;

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,self::$transaccion);
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

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'crear';


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

            #2.1. Guardamos el pago en la cuota.
            $rPago[] = self::$hs->Guardar($request, $clase, self::$hs->mensajeGuardar, self::$transaccion);


            #2.2. Guardamos el pago en la tabla de pagos.
            $PDP = new PrestamoDetallePagoController();

            $rPago[] = $PDP->GuardarPago(
                $request,
                $saldoAtrasado->id,
                $estado,
                $saldoAtrasado->saldo,
                $observacion
            );
        }


        #3. Si paga mas de la cuenta o el pago es mayor de la fecha actual
        if ($valor > 0) {

            if (!$saldoAtrasado->fecha_pago) {

                $cuotas = PrestamoDetalle::ConsultarPorEmpresaPrestamo($request, $idEmpresa, $idPrestamo);
            }
            else {

                $cuotas = PrestamoDetalle::ConsultarPorEmpPreFecMay($request, $idEmpresa, $idPrestamo, $saldoAtrasado->fecha_pago);
            }


            if ($cuotas->count() > 0) {

                foreach ($cuotas as $cuota) {

                    if ($valor > 0 && $cuota->valor_pagado < $cuota->cuota) {


                        $calculo = 0;

                        if ($valor + $cuota->valor_pagado > $cuota->cuota) {

                            $calculo = $cuota->cuota;
                            $valor  -= $cuota->cuota - $cuota->valor_pagado;
                        }
                        else {
                            $calculo = $valor;
                            $valor   = 0;
                        }

                        $clase = PrestamoDetalle::find($cuota->id);

                        $clase->valor_pagado    = $calculo;
                        $clase->id_estado_pago  = 10;

                        $rPago[] = self::$hs->Guardar($request, $clase, self::$hs->mensajeGuardar, self::$transaccion);

                        $PDP = new PrestamoDetallePagoController();

                        $rPago[] = $PDP->GuardarPago(
                            $request,
                            $cuota->id,
                            10,
                            $calculo,
                            $observacion
                        );
                    }
                }
            }
        }

        #4. Actualizamos los datos de la tabla prestamo
        Prestamo::ActualizarDatosFinacieros($request, [$idPrestamo], false, date('Y-m-d H:i:s'), $estado);

        if ($valor > 0) {

            return response()->json([
                'resultado' => 2,
                'titulo'    => 'Informacion',
                'mensaje'   => 'Se guardó el pago correctamente pero sobró un total de $' . number_format($valor),
                'datos'     => $rPago
            ]);
        }
        else {
            return response()->json([
                'resultado' => 1,
                'titulo'    => 'Realizado',
                'mensaje'   => 'Se guardó el pago correctamente',
                'datos'     => $rPago
            ]);
        }
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 3.0
     * @date_create 2017-11-11 - 02:23 PM
     * @date_modify 2018-01-21 - 01:58 PM <Jeremy Reyes B.>
     * @see 1. PrestamoDetallePago::eliminarPorDetallePrestamo.
     *      2. HerramientaStidsController::ejecutarSave.
     *      3. Prestamo::actualizarDatosFinacieros.
     *
     * Borra el pago realizado
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json
     */
    public function BorrarPago($request){

        $idPrestamoDetalle = $request->get('id');

        #1. Eliminamos por el detalle del prestamo los pagos realizados.
        PrestamoDetallePago::eliminarPorDetallePrestamo($request,$idPrestamoDetalle);

        #2. Obtenemos la cuota seleccionada
        $prestamoDetalle = PrestamoDetalle::find($idPrestamoDetalle);

        $prestamoDetalle->valor_pagado = 0;

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        #3. Actualizamos en 0 el pago realizado
        $rPrestamoDetallePago = self::$hs->Guardar(
            $request,
            $prestamoDetalle,
            self::$hs->mensajeGuardar,
            self::$transaccion
        );


        #4. Actualizamos los datos financieros de este prestamo
        $rDatosFinancieros = Prestamo::ActualizarDatosFinacieros(
            $request,
            [$prestamoDetalle->id_prestamo],
            false,
            null,
            4
        );


        return response()->json([
            'resultado'             => 1,
            'titulo'                => 'Realiado',
            'mensaje'               => 'Se borró el pago realizado correctamente.',
            'prestamo_detalle_pago' => $rPrestamoDetallePago,
            'datos_financieros'     => $rDatosFinancieros
        ]);
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 3.0
     * @date_create 2017-11-11 - 02:23 PM
     * @date_modify 2018-01-21 - 01:58 PM <Jeremy Reyes B.>
     * @see 1. PrestamoDetallePago::eliminarPorDetallePrestamo.
     *      2. HerramientaStidsController::ejecutarSave.
     *      3. Prestamo::actualizarDatosFinacieros.
     *
     * Borra el pago realizado
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json
     */
    public function GuardarAmpliacion($request){

        $clase = PrestamoDetalle::find($request->get('id'));

        $clase->mora            += $request->get('valor');
        $clase->cuota            = $clase->abono_capital + $clase->intereses + $clase->mora;
        $clase->id_estado_pago   = 1;


        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        #3. Actualizamos en 0 el pago realizado
        $rPrestamoDetallePago = self::$hs->Guardar(
            $request,
            $clase,
            self::$hs->mensajeGuardar,
            self::$transaccion
        );

        #4. Actualizamos los datos financieros de este prestamo
        $rDatosFinancieros = Prestamo::ActualizarDatosFinacieros(
            $request,
            [$clase->id_prestamo],
            false,
            null,
            1
        );

        return response()->json([
            'resultado' => 1,
            'titulo'    => 'Realiado',
            'mensaje'   => 'Se realizó la ampliacion de la cuota correctamente.'
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-22 - 08:26 PM
     * @see: 1. PrestamoDetalle::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Elimina un dato por id.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function GuardarObservacion($request)
    {
        $clase = PrestamoDetalle::Find((int)$request->get('id'));

        $clase->observacion = $request->get('observacion');

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'actualizar';

        return self::$hs->Guardar(
            $request,
            $clase,
            self::$hs->mensajeGuardar,
            self::$transaccion
        );
    }
}