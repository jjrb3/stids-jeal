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
}