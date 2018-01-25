<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Prestamo extends Model
{
    public $timestamps = false;
    protected $table = "p_prestamo";

    const MODULO = 'Prestamo';
    const MODELO = 'Prestamo';


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
     * @param integer   $idEmpresa:   ID empresa.
     *
     * @return object
     */
    public static function ConsultarTodo($request, $buscar = null, $pagina = 1, $tamanhio = 10, $idEmpresa) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Prestamo::select(
                DB::raw("CONCAT(p_cliente.nombres,' ',p_cliente.apellidos) as cliente"),
                'p_prestamo.no_prestamo AS no',
                'p_cliente.identificacion',
                'p_forma_pago.nombre AS forma_pago',
                'p_estado_pago.descripcion AS estado_pago',
                'p_tipo_prestamo.nombre AS tipo_prestamo',
                'p_prestamo.*'
            )
                ->join('p_cliente','p_prestamo.id_cliente','=','p_cliente.id')
                ->join('p_forma_pago','p_prestamo.id_forma_pago','=','p_forma_pago.id')
                ->join('p_estado_pago','p_prestamo.id_estado_pago','=','p_estado_pago.id')
                ->join('p_tipo_prestamo','p_prestamo.id_tipo_prestamo','=','p_tipo_prestamo.id')

                ->whereRaw(
                    "( 
                        p_cliente.identificacion like '%$buscar%'
                        OR p_cliente.nombres like '%$buscar%'
                        OR p_cliente.apellidos like '%$buscar%'
                        OR p_forma_pago.nombre like '%$buscar%'
                        OR p_estado_pago.descripcion like '%$buscar%'
                        OR p_tipo_prestamo.nombre like '%$buscar%'
                        OR p_prestamo.no_prestamo like '%$buscar%'
                        OR p_prestamo.monto_requerido like '%$buscar%'
                        OR p_prestamo.total_intereses like '%$buscar%'
                        OR p_prestamo.fecha_pago_inicial like '%$buscar%'
                    )"
                )
                    ->where('p_prestamo.estado', '>', '-1')
                    ->where('p_prestamo.id_empresa',$idEmpresa)
                    //->where('p_prestamo.id_estado_pago','<>', 3)
                    ->orderBy('estado','desc')
                    ->orderBy('p_prestamo.id','desc')
                    ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarTodo', $e, $request);
        }
    }


    public static function obtenerNoPrestamo($request) {
        try {
            $resultado = Prestamo::select('no_prestamo')
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->orderBy('id','desc')
                ->get()
                ->toArray();

            return !$resultado ? 1 : 1 + (int)$resultado[0]['no_prestamo'];
        } catch (Exception $e) {
            return array();
        }
    }


    public static function consultarId($id) {
        try {
            return Prestamo::select(
                DB::raw("CONCAT(p_cliente.nombres,' ',p_cliente.apellidos) as cliente"),
                'p_cliente.identificacion',
                'p_forma_pago.descripcion AS forma_pago',
                'p_estado_pago.descripcion AS estado_pago',
                'p_tipo_prestamo.descripcion AS tipo_prestamo',
                'p_prestamo.*'
            )
                ->join('p_cliente','p_prestamo.id_cliente','=','p_cliente.id')
                ->join('p_forma_pago','p_prestamo.id_forma_pago','=','p_forma_pago.id')
                ->join('p_estado_pago','p_prestamo.id_estado_pago','=','p_estado_pago.id')
                ->join('p_tipo_prestamo','p_prestamo.id_tipo_prestamo','=','p_tipo_prestamo.id')
                ->where('p_prestamo.id','=',$id)
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }

    public static function eliminarPorId($request,$id) {
        try {

            $clase = Prestamo::Find((int)$id);

            $clase->estado = -1;

            if ($clase->save()) {

                HerramientaStidsController::guardarTransaccion($request,31,5,$id,'p_cliente');

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
        catch (Exception $e) {
            return array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            );
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-10 - 12:56 PM
     *
     * Actualizar todos los datos finaciones de un prestamo o varios
     *
     * @param array   $request:     Peticiones realizadas.
     * @param array   $idsPrestamo: Ids del prestamo.
     * @param bool    $sistema:     Si es el sisteman o agrega las transaccion.
     * @param string  $fechaPago:   Fecha del ultimo pago.
     *
     * @return object
     */
    public static function ActualizarDatosFinacieros($request, $idsPrestamo = array(), $sistema = false, $fechaPago = null, $idEstadoPago = null) {

        try {

            $listaPrestamo = PrestamoDetalle::select(
                DB::raw('
                            id_prestamo,
                            SUM(intereses)      AS total_intereses,
                            SUM(mora)           AS total_mora,
                            SUM(cuota)          AS total,
                            SUM(valor_pagado)   AS total_pagado'
                    )
                )
                ->where('id_empresa', $request->session()->get('idEmpresa'))
                ->where('estado', '>', '-1')
                ->groupBy('id_prestamo')
                ->get();

            if ($idsPrestamo) {
                $listaPrestamo = $listaPrestamo->whereIn('id_prestamo', $idsPrestamo);
            }

            $listaPrestamo = $listaPrestamo->toArray();

            $resultado = [];

            # Actualizamos todo los datos
            foreach ($listaPrestamo as $item) {

                $prestamo = Prestamo::Find($item['id_prestamo']);

                $prestamo->total_intereses  = $item['total_intereses'];
                $prestamo->total_mora       = $item['total_mora'];
                $prestamo->total            = $item['total'];
                $prestamo->total_pagado     = $item['total_pagado'];

                if ($fechaPago) {
                    $prestamo->fecha_ultimo_pago = $fechaPago;
                }

                $prestamo->id_estado_pago = $prestamo->total_pagado >= $prestamo->total ? 3 : $idEstadoPago;

                if ($prestamo->save()) {

                    # Si no es el sistema entonces agrega la transaccion
                    if (!$sistema) {
                        $resultado[] = HerramientaStidsController::guardarTransaccion($request,32,2,$item['id_prestamo'],'p_prestamo');
                    }

                    $resultado[] = array(
                        'resultado' => 1,
                        'id_prestamo' => $prestamo->id,
                        'numero_prestamo' => $prestamo->no_prestamo,
                        'mensaje'   => "Se actualizó el numero de prestamo {$prestamo->no_prestamo} correctamente.",
                    );
                }
                else {
                    $resultado[] = array(
                        'resultado' => 0,
                        'id_prestamo' => $prestamo->id,
                        'numero_prestamo' => $prestamo->no_prestamo,
                        'mensaje'   => "Se encontraron problemas al actualizar el numero de prestamo {$prestamo->no_prestamo}.",
                    );
                }
            }

            return $resultado;

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ActualizarDatosFinacieros', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-10 - 12:04 PM
     *
     * Prestamos realizados
     *
     * @param array     $request:       Peticiones realizadas.
     * @param integer   $idEmpresa:     ID empresa.
     *
     * @return object
     */
    public static function Realizados($request, $idEmpresa) {
        try {
            return Prestamo::where('id_empresa',$idEmpresa)
                ->where('estado','>','-1')
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'Realizados', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-10 - 12:04 PM
     *
     * Prestamos realizados
     *
     * @param array     $request:       Peticiones realizadas.
     * @param integer   $idEmpresa:     ID empresa.
     *
     * @return object
     */
    public static function Completados($request, $idEmpresa) {
        try {
            return Prestamo::where('id_empresa',$idEmpresa)
                ->where('estado','>','-1')
                ->where('id_estado_pago',3)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'Completados', $e, $request);
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
     * @param integer $idEmpresa:       ID empresa.
     *
     * @return object
     */
    public static function ConsultarTotalRecaudado($request, $idEmpresa)
    {
        try {
            return DB::select(
                "SELECT *,
                        ROUND(intereses/total_pagado * 100,2)       AS porcentaje_interes,
                        ROUND(abono_capital/total_pagado * 100,2)   AS porcentaje_capital,
                        ROUND(total_pagado/total_general * 100,2)   AS porcentaje_pagado,
                        ROUND(total_recaudar/total_general * 100,2) AS porcentaje_recaudar
                FROM (
                    SELECT IF(SUM(ppd.intereses) < SUM(ppd.valor_pagado),
                             SUM(ppd.intereses),
                             SUM(ppd.valor_pagado)
                          )                                               AS intereses,
                          IF(SUM(ppd.intereses) < SUM(ppd.valor_pagado),
                             SUM(ppd.valor_pagado) - SUM(ppd.intereses),
                             0
                          )                                               AS abono_capital,
                          SUM(ppd.valor_pagado)                           AS total_pagado,
                          IF(SUM(pp.total) - SUM(ppd.valor_pagado) > 0,
                              SUM(pp.total) - SUM(ppd.valor_pagado),
                              0
                          )                                               AS total_recaudar,
                          SUM(pp.total)                                   AS total_general
                          
                    FROM p_prestamo pp
                    INNER JOIN p_prestamo_detalle ppd       ON  pp.id             = ppd.id_prestamo
                                                            AND pp.id_empresa     = ppd.id_empresa
                                                            AND ppd.estado        > -1
                    INNER JOIN p_prestamo_detalle_pago ppdp ON  ppd.id            = ppdp.id_prestamo_detalle
                                                            AND ppd.id_empresa    = ppdp.id_empresa
                                                            AND ppdp.estado       = 1
                    INNER JOIN p_cliente pc                 ON  pp.id_cliente     = pc.id
                    INNER JOIN p_estado_pago pep            ON  pp.id_estado_pago = pep.id
                    INNER JOIN s_transacciones st           ON  ppdp.id           = st.id_alterado
                                                            AND st.id_permiso     = 1
                                                            AND st.id_modulo      = 32
                                                            AND st.nombre_tabla   = 'p_prestamo_detalle_pago'
                
                    WHERE pp.id_empresa = {$idEmpresa}
                ) transacciones"
            );

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarTotalRecaudado', $e, $request);
        }
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-27 - 12:40 PM
     *
     * Consulta el detalle de un prestamo por dia
     *
     * @param request $request:         Peticiones.
     * @param integer $idEmpresa:       ID empresa.
     * @param string  $fechaInicial:    Fecha inicial.
     * @param string  $fechaFinal:      Fecha final.
     *
     * @return object
     */
    public static function ConsultarDetallePagosPorDia($request, $idEmpresa, $fechaInicial, $fechaFinal)
    {
        try {
            return DB::select(
                "SELECT DATE_FORMAT(st.fecha_alteracion,'%Y-%m-%d')      AS fecha,
                        IF(SUM(ppd.intereses) < SUM(ppd.valor_pagado),
                            SUM(ppd.intereses),
                            SUM(ppd.valor_pagado)
                        )                                                AS interes,
                        IF(SUM(ppd.intereses) < SUM(ppd.valor_pagado),
                            SUM(ppd.valor_pagado) - SUM(ppd.intereses),
                            0
                        )                                                AS capital,
                        SUM(ppd.valor_pagado)                            AS total
                        
                    FROM p_prestamo pp
                    INNER JOIN p_prestamo_detalle ppd       ON  pp.id             = ppd.id_prestamo
                                                            AND pp.id_empresa     = ppd.id_empresa
                                                            AND ppd.estado        > -1
                    INNER JOIN p_prestamo_detalle_pago ppdp ON  ppd.id            = ppdp.id_prestamo_detalle
                                                            AND ppd.id_empresa    = ppdp.id_empresa
                                                            AND ppdp.estado       = 1
                    INNER JOIN p_cliente pc                 ON  pp.id_cliente     = pc.id
                    INNER JOIN p_estado_pago pep            ON  pp.id_estado_pago = pep.id
                    INNER JOIN s_transacciones st           ON  ppdp.id           = st.id_alterado
                                                            AND st.id_permiso     = 1
                                                            AND st.id_modulo      = 32
                                                            AND st.nombre_tabla   = 'p_prestamo_detalle_pago'
                    
                    WHERE pp.id_empresa = {$idEmpresa}
                    AND st.fecha_alteracion BETWEEN '{$fechaInicial}' AND '{$fechaFinal}'
                    
                    GROUP BY fecha
                    ORDER BY fecha"
            );

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarDetallePagosPorDia', $e, $request);
        }
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-27 - 12:40 PM
     *
     * Consulta total general a pagar
     *
     * @param request $request:         Peticiones.
     * @param integer $idEmpresa:       ID empresa.
     *
     * @return object
     */
    public static function ConsultarTotalGeneralAPagar($request, $idEmpresa)
    {
        try {
            return Prestamo::select(DB::raw('SUM(total) AS total'))
                ->where('id_empresa',$idEmpresa)
                ->where('estado',1)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarTotalGeneralAPagar', $e, $request);
        }
    }
}