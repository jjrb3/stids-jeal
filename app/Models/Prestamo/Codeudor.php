<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Codeudor extends Model
{
    public $timestamps = false;
    protected $table = "p_codeudor";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Codeudor';

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 07:55 PM
     *
     * Consultar todos con paginación
     *
     * @param request   $request:     Peticiones realizadas.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     * @param integer   $idCliente:   ID cliente.
     *
     * @return object
     */
    public static function consultarTodo($request, $buscar = null, $pagina = 1, $tamanhio = 10, $idCliente)
    {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            return Codeudor::whereRaw(
                    "
                    ( 
                        cedula like '%$buscar%'
                        OR nombres like '%$buscar%'
                        OR apellidos like '%$buscar%'
                        OR direccion like '%$buscar%'
                        OR telefono like '%$buscar%'
                        OR celular like '%$buscar%'
                    )
                "
                )
                ->where('estado', '1')
                ->where('id_cliente', $idCliente)
                ->orderBy('nombres')
                ->orderBy('apellidos')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO, self::MODELO, 'consultarTodo', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 12:02 PM
     *
     * Consulta el listado de codeudores por id del cliente
     *
     * @param integer $id: Id del cliente.
     *
     * @return array: Listado de coudeudores
     */
    public static function consultarPorIdCliente($id) {
        try {
            return Codeudor::where('id_cliente',$id)
                ->where('estado',1)
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 12:02 PM
     *
     * Consulta el listado de codeudores por id
     *
     * @param integer $id: Id codeudor.
     *
     * @return array: Codeudor
     */
    public static function consultarPorId($id) {

        try {
            return Codeudor::where('id',$id)
                ->where('estado',1)
                ->get()
                ->toArray()[0];
        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-23 - 3:26 PM
     * @see 1. HerramientaStidsController::guardarTransaccion.
     *
     * Eliminamos un codeudor y guarda la transacción.
     *
     * @param array     $request:   Peticiones realizadas.
     * @param integer   $id:        Id que se eliminará.
     *
     * @return array: Resultado de eliminar
     */
    public static function eliminarPorId($request,$id) {
        try {

            $clase = Codeudor::Find((int)$id);

            $clase->estado = -1;

            if ($clase->save()) {

                HerramientaStidsController::guardarTransaccion($request,31,5,$id,'p_codeudor');

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
}