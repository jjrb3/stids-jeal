<?php

namespace App\Models\Prestamo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reportes extends Model
{
    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-27 - 11:52 AM
     *
     * Consulta la relacion de prestamo por rango de fecha
     *
     * @param request $request:         Peticiones.
     * @param string  $fechaInicial:    Fecha inicial.
     * @param string  $fechaFinal:      Fecha final.
     *
     * @return array
     */
    public static function ConsultarRelacionPrestamoPorFechas($request, $fechaInicial, $fechaFinal)
    {
        try {
            return DB::select(
                "SELECT pc.identificacion                     AS identificacion,
                        CONCAT(pc.nombres,' ',pc.apellidos)   AS cliente,
                        pc.telefono,
                        st.fecha_alteracion                   AS fecha_prestamo,
                        pp.no_cuotas                          AS cuotas,
                        (
                            SELECT ppd.fecha_pago
                            FROM p_prestamo_detalle ppd
                            WHERE ppd.id_prestamo = pp.id
                            ORDER BY ppd.id DESC
                            LIMIT 1
                        )                                     AS fecha_vencimiento,
                        CONCAT(su.nombres,' ',su.apellidos)   AS creado_por,
                        pep.descripcion                       AS estado,
                        pp.monto_requerido                    AS valor,
                        pp.total_intereses + pp.total_mora    AS intereses,
                        pp.total                              AS valor_total,
                        pp.total - pp.total_pagado            AS deuda
                
                FROM p_prestamo pp
                INNER JOIN p_cliente        pc  ON  pp.id_cliente     = pc.id
                                                AND pp.estado         = pc.estado
                INNER JOIN s_transacciones  st  ON  st.id_alterado    = pp.id
                                                AND st.nombre_tabla   = 'p_prestamo'
                                                AND st.id_permiso     = 1
                INNER JOIN s_usuario        su  ON  st.id_usuario     = su.id
                INNER JOIN p_estado_pago    pep ON  pp.id_estado_pago = pep.id
                
                WHERE st.fecha_alteracion BETWEEN '$fechaInicial' AND '$fechaFinal'
                AND pp.id_empresa = {$request->session()->get('idEmpresa')}
                AND pp.estado = 1
                ORDER BY cliente ASC"
            );

        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-27 - 12:40 PM
     *
     * Consulta los prestamos que estan sin completar por rango de fecha
     *
     * @param request $request:         Peticiones.
     * @param string  $fechaInicial:    Fecha inicial.
     * @param string  $fechaFinal:      Fecha final.
     *
     * @return array
     */
    public static function ConsultarPrestamosSinCompletar($request, $fechaInicial, $fechaFinal)
    {
        try {
            return DB::select(
                "SELECT pc.identificacion                     AS identificacion,
                        CONCAT(pc.nombres,' ',pc.apellidos)   AS cliente,
                        pc.telefono,
                        st.fecha_alteracion                   AS fecha_prestamo,
                        pp.no_cuotas                          AS cuotas,
                        (
                            SELECT ppd.fecha_pago
                            FROM p_prestamo_detalle ppd
                            WHERE ppd.id_prestamo = pp.id
                            ORDER BY ppd.id DESC
                            LIMIT 1
                        )                                     AS fecha_vencimiento,
                        CONCAT(su.nombres,' ',su.apellidos)   AS creado_por,
                        pep.descripcion                       AS estado,
                        pp.monto_requerido                    AS valor,
                        pp.total_intereses + pp.total_mora    AS intereses,
                        pp.total                              AS valor_total,
                        pp.total - pp.total_pagado            AS deuda
                
                FROM p_prestamo pp
                INNER JOIN p_cliente        pc  ON  pp.id_cliente     = pc.id
                                                AND pp.estado         = pc.estado
                INNER JOIN s_transacciones  st  ON  st.id_alterado    = pp.id
                                                AND st.nombre_tabla   = 'p_prestamo'
                                                AND st.id_permiso     = 1
                INNER JOIN s_usuario        su  ON  st.id_usuario     = su.id
                INNER JOIN p_estado_pago    pep ON  pp.id_estado_pago = pep.id
                
                WHERE pp.fecha_ultimo_pago BETWEEN '$fechaInicial' AND '$fechaFinal'
                AND pp.id_empresa = {$request->session()->get('idEmpresa')}
                AND pp.estado = 1
                AND pp.id_estado_pago <> 3
                ORDER BY cliente ASC"
            );

        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-27 - 12:40 PM
     *
     * Consulta los prestamos que esta finalizados por rago de fecha
     *
     * @param request $request:         Peticiones.
     * @param string  $fechaInicial:    Fecha inicial.
     * @param string  $fechaFinal:      Fecha final.
     *
     * @return array
     */
    public static function ConsultarPrestamosFinalizadosPorFechas($request, $fechaInicial, $fechaFinal)
    {
        try {
            return DB::select(
                "SELECT pc.identificacion                     AS identificacion,
                        CONCAT(pc.nombres,' ',pc.apellidos)   AS cliente,
                        pc.telefono,
                        st.fecha_alteracion                   AS fecha_prestamo,
                        pp.no_cuotas                          AS cuotas,
                        (
                            SELECT ppd.fecha_pago
                            FROM p_prestamo_detalle ppd
                            WHERE ppd.id_prestamo = pp.id
                            ORDER BY ppd.id DESC
                            LIMIT 1
                        )                                     AS fecha_vencimiento,
                        CONCAT(su.nombres,' ',su.apellidos)   AS creado_por,
                        pep.descripcion                       AS estado,
                        pp.monto_requerido                    AS valor,
                        pp.total_intereses + pp.total_mora    AS intereses,
                        pp.total                              AS valor_total,
                        pp.total - pp.total_pagado            AS deuda
                
                FROM p_prestamo pp
                INNER JOIN p_cliente        pc  ON  pp.id_cliente     = pc.id
                                                AND pp.estado         = pc.estado
                INNER JOIN s_transacciones  st  ON  st.id_alterado    = pp.id
                                                AND st.nombre_tabla   = 'p_prestamo'
                                                AND st.id_permiso     = 1
                INNER JOIN s_usuario        su  ON  st.id_usuario     = su.id
                INNER JOIN p_estado_pago    pep ON  pp.id_estado_pago = pep.id
                
                WHERE pp.fecha_ultimo_pago BETWEEN '$fechaInicial' AND '$fechaFinal'
                AND pp.id_empresa = {$request->session()->get('idEmpresa')}
                AND pp.estado = 1
                AND pp.id_estado_pago = 3
                ORDER BY cliente ASC"
            );

        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-27 - 12:40 PM
     *
     * Consulta el recaudo por fecha
     *
     * @param request $request: Peticiones.
     * @param string  $fecha:   Fecha.
     *
     * @return array
     */
    public static function ConsultarRecaudoDiarioPorFecha($request, $fecha)
    {
        try {
            return DB::select(
                "SELECT pc.identificacion,
                        pc.nombres,
                        pc.apellidos,
                        pc.telefono,
                        pp.no_prestamo,
                        pp.monto_requerido                    AS valor,
                        pp.total_intereses + pp.total_mora    AS intereses,
                        pp.total                              AS valor_total,
                        pp.total - pp.total_pagado            AS deuda,
                        pp.fecha_ultimo_pago                  AS fecha_abonado
                
                FROM p_prestamo pp
                INNER JOIN p_cliente        pc  ON  pp.id_cliente     = pc.id
                                                AND pp.estado         = pc.estado
                
                WHERE pp.id_empresa = {$request->session()->get('idEmpresa')}
                AND pp.estado = 1
                AND DATE_FORMAT(pp.fecha_ultimo_pago,'%Y-%m-%d') = '$fecha'
                ORDER BY pc.nombres ASC,
                         pc.apellidos ASC"
            );

        } catch (Exception $e) {
            return array();
        }
    }
}