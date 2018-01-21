<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class PrestamoDetalle extends Model
{
    public $timestamps = false;
    protected $table = "p_prestamo_detalle";

    const MODULO = 'Prestamo';
    const MODELO = 'PrestamoDetalle';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 12:07 PM
     *
     * Consultar todos con paginación
     *
     * @param request   $request:     Peticiones realizadas.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     * @param integer   $idPrestamo:  ID prestamp.
     * @param integer   $idEmpresa:   ID empresa.
     *
     * @return object
     */
    public static function ConsultarTodoPorPrestamo($request,$buscar,$pagina = 1,$tamanhioPagina = 100000, $idPrestamo, $idEmpresa) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return PrestamoDetalle::select(
                DB::raw(
                    "p_prestamo_detalle.*, 
                    IF(p_prestamo_detalle.cuota - p_prestamo_detalle.valor_pagado < 1, 0, p_prestamo_detalle.cuota - p_prestamo_detalle.valor_pagado) AS cuota_a_pagar,
                    p_prestamo_detalle.intereses + p_prestamo_detalle.mora AS total_intereses"
                ),
                'p_prestamo_detalle.no_cuota AS no',
                'p_estado_pago.descripcion AS estado_pago'
            )
                ->join('p_estado_pago','p_prestamo_detalle.id_estado_pago','=','p_estado_pago.id')
                ->whereRaw(
                "( 
                    p_prestamo_detalle.saldo_inicial like '%$buscar%'
                    OR p_prestamo_detalle.cuota like '%$buscar%'
                    OR p_prestamo_detalle.fecha_pago like '%$buscar%'
                    OR p_prestamo_detalle.intereses like '%$buscar%'
                  )"
                )
                ->where('p_prestamo_detalle.estado','=',1)
                ->where('p_prestamo_detalle.id_empresa',$idEmpresa)
                ->where('p_prestamo_detalle.id_prestamo',$idPrestamo)
                ->orderBy('p_prestamo_detalle.id','asc')
                ->paginate($tamanhioPagina);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarTodo', $e, $request);
        }
    }


    public static function getMoraByLoan($request, $idLoan) {
        try{
            $result = PrestamoDetalle::select(DB::raw("SUM(mora) AS mora"))
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->where('estado',1)
                ->where('id_prestamo',$idLoan)
                ->get()
                ->toArray();

            if ($result) {
                return $result[0]['mora'];
            }
            else {
                return 0;
            }
        } catch (\Exception $e) {
            return array();
        }
    }


    public static function getTotalPaymentByLoan($request, $idLoan) {
        try{
            $result = PrestamoDetalle::select(DB::raw("SUM(mora + total) AS mora"))
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->where('estado',1)
                ->where('id_prestamo',$idLoan)
                ->get()
                ->toArray();

            if ($result) {
                return $result[0]['mora'];
            }
            else {
                return 0;
            }
        } catch (\Exception $e) {
            return array();
        }
    }


    public static function getTotalPayOutByLoan($request, $idLoan) {
        try{
            $result = PrestamoDetalle::select(DB::raw("SUM(valor_pagado) AS mora"))
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->where('estado',1)
                ->where('id_prestamo',$idLoan)
                ->get()
                ->toArray();

            if ($result) {
                return $result[0]['mora'];
            }
            else {
                return 0;
            }
        } catch (\Exception $e) {
            return array();
        }
    }


    public static function obtenerNoPrestamo($request) {
        try {
            return Prestamo::select(DB::raw("CASE
                                              WHEN MAX(no_prestamo) > 0 THEN MAX(no_prestamo)
                                              ELSE 0
                                            END AS no_prestamo"))
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->get()
                ->toArray()[0]['no_prestamo'];
        } catch (\Exception $e) {
            return array();
        }
    }


    public static function ConsultById($id) {
        try {
            $result = PrestamoDetalle::select(DB::raw("CONCAT(s_usuario.nombres,' ',s_usuario.apellidos) AS usuario_modifico, 
                                                    s_transacciones.fecha_alteracion,
                                                    p_prestamo_detalle.*"))
                ->join('s_transacciones','p_prestamo_detalle.id','=','s_transacciones.id_alterado')
                ->join('s_usuario','s_transacciones.id_usuario','=','s_usuario.id')
                ->where('p_prestamo_detalle.id',(int)$id)
                ->where('p_prestamo_detalle.estado',1)
                ->where('s_transacciones.id_permiso',2)
                ->where('s_transacciones.id_modulo',32)
                ->where('s_transacciones.nombre_tabla','p_prestamo_detalle')
                ->orderBy('s_transacciones.id','DESC')
                ->limit(1)
                ->get()
                ->toArray();

            if ($result) {
                return $result[0];
            }
            else {
                $result = PrestamoDetalle::where('id',(int)$id)
                    ->where('estado',1)
                    ->get()
                    ->toArray();


                if ($result) {
                    $result[0]['usuario_modifico'] = '';
                    $result[0]['fecha_alteracion'] = '';

                    $result = $result[0];
                }

                return $result;
            }
        } catch (\Exception $e) {
            return array();
        }
    }

    public static function eliminarPorId($request,$id) {
        try {

            $clase = PrestamoDetalle::Find((int)$id);

            $clase->estado = -1;

            if ($clase->save()) {

                HerramientaStidsController::guardarTransaccion($request,33,5,$id,'p_prestamo_detalle');

                return array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                );
            }
            else {
                return array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar',
                );
            }
        }
        catch (\Exception $e) {
            return array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            );
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 12:02 PM
     *
     * Consultar cual es el prestamo y el numero de cuota que se pagará
     *
     * @param array     $request:    Peticiones realizadas.
     * @param integer   $valorPago:  Valor que se pagará.
     * @param integer   $idPrestamo: Id del prestamo.
     *
     * @return array: Resultado si se realizó el pago correctamente o no
     */
    public static function pagarCuota($request,$valorPago,$idPrestamo) {
        try {
            $resultado = DB::select(
                "CALL pagar_prestamo(
                    $valorPago,
                    {$request->session()->get('idEmpresa')},
                    $idPrestamo,
                    @resultado
                )"
            )[0];

            if ($resultado->resultado > 0) {
                HerramientaStidsController::guardarTransaccion($request,32,2,$idPrestamo,'p_prestamo_detalle');

                return array(
                    'resultado' => 1,
                    'mensaje'   => 'Se realizó el pago correctamente',
                );
            }
            else {
                return array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al realizar el pago',
                );
            }

        } catch (\Exception $e) {
            return array();
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-08 - 05:54 PM
     *
     * Obtendo el numero de cuota siguiente al que ya se le realizó el pago
     *
     * @param array     $request:    Peticiones realizadas.
     * @param integer   $idPrestamo: Id del prestamo.
     *
     * @return integer: Numero de la cuota
     */
    public static function obtenerSiguienteCuota($request,$idPrestamo) {
        try {

            $result = PrestamoDetalle::select('no_cuota')
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->where('id_prestamo',$idPrestamo)
                ->where('estado',1)
                ->where('valor_pagado',0)
                ->orderBy('id','ASC')
                ->limit(1)
                ->get()
                ->toArray();

            if ($result) {
                return $result[0]['no_cuota'];
            }
            else {
                return 0;
            }

        } catch (\Exception $e) {
            return 0;
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-08 - 05:54 PM
     *
     * Elimina las cuotas que sean mayores de una cuota dada
     *
     * @param array     $request:    Peticiones realizadas.
     * @param integer   $idPrestamo: Id del prestamo.
     * @param integer   $cuota:      cuota.
     *
     * @return array: Resultado de la eliminación
     */
    public static function eliminarCuotasMayores($request,$idPrestamo,$cuota) {
        try {

            $resultado = PrestamoDetalle::where('id_empresa',$request->session()->get('idEmpresa'))
                ->where('id_prestamo',$idPrestamo)
                ->where('no_cuota','>',$cuota)
                ->update(['estado' => -1]);

            if ($resultado > 0) {

                return array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                );
            }
            else {
                return array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar',
                );
            }
        }
        catch (\Exception $e) {
            return array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            );
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-10 - 12:04 PM
     *
     * Obtendo el numero de cuota siguiente al que ya se le realizó el pago
     *
     * @param array     $request:    Peticiones realizadas.
     * @param integer   $idPrestamo: Id del prestamo.
     *
     * @return integer: Numero de la cuota
     */
    public static function generarNumeroRefinanciacion($request,$idPrestamo) {
        try {

            $result = PrestamoDetalle::select(DB::raw('MAX(no_refinanciacion) + 1 AS refinanciacion'))
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->where('id_prestamo',$idPrestamo)
                ->where('estado',1)
                ->get()
                ->toArray();

            if ($result) {
                return $result[0]['refinanciacion'];
            }
            else {
                return 0;
            }

        } catch (\Exception $e) {
            return 0;
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-11 - 12:17 PM
     * @see: 1. PrestamoDetalle::consultarPorPrestamo.
     *       2. HerramientaStidsController::sumarDias.
     *
     * Actualizamos todas las fechas de los pagos desde la cuota que se envia hasta la ultima dependiendo del tipo
     * de fecha que sea.
     *
     * @param array     $request:       Peticiones realizadas.
     * @param integer   $idPrestamo:    Id del prestamo.
     * @param integer   $cuota:         Cuota desde donde iniciará.
     * @param string    $fecha:         Fecha asignada a la cuota.
     *
     * @return array: Resultado
     */
    public static function actualizarFechaDesdeCuota($request,$idPrestamo,$cuota,$fecha) {
        try {

            $prestamoDetalle = PrestamoDetalle::ConsultarTodoPorPrestamo($request,null,null,null, $idPrestamo);
            $resultado       = [];

            if ($prestamoDetalle) {

                $prestamo   = Prestamo::Find($idPrestamo);
                $cnt        = 1;

                foreach ($prestamoDetalle as $pd) {

                    if ($pd->no_cuota > $cuota) {

                        switch ($prestamo->id_forma_pago)
                        {
                            case 1:
                                $fechaActualizar = HerramientaStidsController::sumarDias($fecha,$cnt);
                                break;

                            case 2:
                                $fechaActualizar = HerramientaStidsController::sumarDias($fecha,$cnt * 7);
                                break;

                            case 3:
                                $fechaActualizar = HerramientaStidsController::sumarDias($fecha,$cnt * 15);
                                break;

                            case 4:
                                $fechaActualizar = HerramientaStidsController::sumarMeses($fecha,$cnt);
                                break;
                        }

                        $clase = PrestamoDetalle::Find($pd->id);

                        $clase->fecha_pago = $fechaActualizar;

                        if ($clase->save()) {

                            $resultado[] = [
                                'resultado' => 1,
                                'numero_cuota' => $pd->no_cuota,
                                'mensaje'   => "Se actualizó la fecha del numero de cuota {$pd->no_cuota} del prestamo {$prestamo->no_prestamo} a {$fecha}.",
                            ];
                        }
                        else {
                            $resultado[] = [
                                'resultado' => 0,
                                'numero_cuota' => $pd->no_cuota,
                                'mensaje'   => "No se pudo actualizar la fecha del numero de cuota {$pd->no_cuota} del prestamo {$prestamo->no_prestamo} a {$fecha}.",
                            ];
                        }

                        $cnt++;
                    }
                }
            }

            return $resultado;

        } catch (\Exception $e) {
            return [
                'resultado' => -1,
                'mensaje' => 'Se enconraron errores al realiar la consulta para actualizar las fechas'
            ];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-10 - 12:04 PM
     *
     * Obtengo la fecha y el saldo atrasado que se tiene que pagar
     *
     * @param array     $request:       Peticiones realizadas.
     * @param integer   $idEmpresa:     ID empresa.
     * @param integer   $idPrestamo:    ID prestamo.
     *
     * @return object
     */
    public static function ConsultarSaldoAtrasado($request, $idEmpresa, $idPrestamo) {
        try {

            return DB::select(
                "SELECT MAX(id)                           AS id,
                        MAX(fecha_pago)                   AS fecha_pago,
                        SUM(cuota) - SUM(valor_pagado)    AS saldo
                FROM p_prestamo_detalle
                WHERE id_empresa = {$idEmpresa}
                AND id_prestamo = {$idPrestamo}
                AND fecha_pago <= NOW()");

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarSaldoAtrasado', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-10 - 12:04 PM
     *
     * Obtengo la fecha y el saldo atrasado que se tiene que pagar
     *
     * @param array     $request:       Peticiones realizadas.
     * @param integer   $idEmpresa:     ID empresa.
     * @param integer   $idPrestamo:    ID prestamo.
     * @param string    $fecha:         Fecha.
     *
     * @return object
     */
    public static function ConsultarPorEmpPreFecMay($request, $idEmpresa, $idPrestamo, $fecha) {
        try {

            return PrestamoDetalle::where('id_empresa',$idEmpresa)
                ->where('id_prestamo',$idPrestamo)
                ->where('estado',1)
                ->where('fecha_pago', '>', $fecha)
                ->orderBy('id')
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorEmpPreFM', $e, $request);
        }
    }
}