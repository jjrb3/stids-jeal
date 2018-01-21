<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Prestamo\PrestamoDetallePago;
use App\Models\Prestamo\PrestamoDetalle;
use App\Models\Prestamo\Prestamo;


class PrestamoDetallePagoController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 32, '', 'p_prestamo_detalle_pago'];
    }


    public function Add(Request $request) {

        if ($this->Check($request))
            return $this->Check($request);

        $loanDetail = PrestamoDetalle::Find($request->get('id_detail'));
        $loan       = Prestamo::Find($loanDetail->id_prestamo);

        //$mora       = 0;
        $datetime1  = date_create(date('Y-m-d'));
        $datetime2  = date_create($loanDetail->fecha_pago);
        $interval   = date_diff($datetime1, $datetime2);

        // Se crea la mora
        /*
        if ($interval->format('%R%a') < 0) {

            if ($loan->total_pagado == 0) {

                $mora = round((float)$loan->mora * $loan->monto_requerido / 100);
            }
            else {

                $totalPagado = $loan->total_pagado / 2;
                $capital     = $loan->monto_requerido - $totalPagado;

                $mora = $capital * $loan->mora / 100;
            }
        }*/


        $total = ($loanDetail->total) - (int)$loanDetail->valor_pagado;


        if ($request->get('monto_pagado') > $total) {

            return response()->json(array(
                'resultado' => 0,
                'mensaje'   => 'El valor no puede ser mayor que $' . number_format($total),
            ));
        }

        $class = $this->setFields(new PrestamoDetallePago(),$request);

        // Estado de pago
        if ($request->get('monto_pagado') < $total && $interval->format('%R%a') < 0) {

            $class->id_estado_pago = 1;
        }
        elseif ($request->get('monto_pagado') < $total && $interval->format('%R%a') >= 0) {

            $class->id_estado_pago = 9;
        }
        elseif ($request->get('monto_pagado') == $total && $interval->format('%R%a') >= 0) {

            $class->id_estado_pago = 10;
        }
        elseif ($request->get('monto_pagado') == $total && $interval->format('%R%a') < 0) {

            $class->id_estado_pago = 10;
        }

        $message = ['Se guardó correctamente','Se encontraron problemas al guardar'];

        $transaction = [$request,32,'crear','p_prestamo_detalle_pago'];
        $result['prestamo_detalle_pago'] = HerramientaStidsController::ejecutarSave($class,$message,$transaction);


        $loanDetail->valor_pagado   = (int)$loanDetail->valor_pagado + $request->get('monto_pagado');
        $loanDetail->id_estado_pago = $class->id_estado_pago;
        $loanDetail->observacion    = $request->get('observacion');


        $transaction = [$request,32,'actualizar','p_prestamo_detalle'];
        $result['prestamo_detalle'] = HerramientaStidsController::ejecutarSave($loanDetail,$message,$transaction);

        $loan->total_mora        = PrestamoDetalle::getMoraByLoan($request, $loan->id);
        $loan->total_pagado      = PrestamoDetalle::getTotalPayOutByLoan($request, $loan->id);
        $loan->total             = PrestamoDetalle::getTotalPaymentByLoan($request, $loan->id);
        $loan->id_estado_pago    = $class->id_estado_pago;
        $loan->total             = $loan->total_intereses + $loan->monto_requerido + $loan->total_mora;
        $loan->fecha_ultimo_pago = date('Y-m-d H:i:s');
        $loan->observacion       = $request->get('observacion');


        $transaction = [$request,32,'actualizar','p_prestamo'];
        $result['prestamo'] = HerramientaStidsController::ejecutarSave($loan,$message,$transaction);

        return response()->json(array(
            'resultado'             => 1,
            'mensaje'               => 'Se realizó el pago correctamente',
            'prestamo'              => $result['prestamo'],
            'prestamo_detalle'      => $result['prestamo_detalle'],
            'prestamo_detalle_pago' => $result['prestamo_detalle_pago'],
         ));
    }


    private function setFields($clase,$request) {

        $clase->id_empresa          = $request->session()->get('idEmpresa');
        $clase->id_prestamo_detalle = $request->get('id_detail');
        $clase->monto_pagado        = $request->get('monto_pagado');
        $clase->observacion         = $request->get('observacion');

        return $clase;
    }


    public function Check($request){

        $campos = array(
            'monto_pagado' => 'Debe digitar el valor a pagar para continuar',
        );

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
     * @date 2018-01-21 - 10:20 AM
     * @see 1. HerramientaStidsController::verificationDatas.
     *
     * Realiza un pago.
     *
     * @param array     $request:           Peticiones realizadas.
     * @param integer   $idPrestamoDetalle: ID prestamo detalle.
     * @param integer   $idEstadoPago:      ID estado pago.
     * @param integer   $valor:             Valor.
     * @param string    $observacion:       Observación.
     *
     * @return object
     */
    public function GuardarPago($request, $idPrestamoDetalle, $idEstadoPago, $valor, $observacion) {

        $clase = new PrestamoDetallePago();

        $clase->id_empresa          = $request->session()->get('idEmpresa');
        $clase->id_prestamo_detalle = $idPrestamoDetalle;
        $clase->id_estado_pago      = $idEstadoPago;
        $clase->monto_pagado        = $valor;
        $clase->observacion         = $observacion;


        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'crear';

        return self::$hs->Guardar($request, $clase, self::$hs->mensajeGuardar, self::$transaccion);
    }
}