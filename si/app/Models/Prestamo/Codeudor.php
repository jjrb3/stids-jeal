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
     * @date: 2018-01-15 - 08:28 PM
     *
     * Consultar por cliente, cedula, nombres y apellidos
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $idCliente:   ID cliente.
     * @param string  $cedula:      Cedula.
     * @param string  $nombres:     Nombres.
     * @param string  $apellidos:   Apellidos.
     *
     * @return object
     */
    public static function ConsultarPorCliCedNomApe($request, $idCliente, $cedula, $nombres, $apellidos) {
        try {
            return Codeudor::where('id_cliente',$idCliente)
                ->where('cedula',$cedula)
                ->where('nombres',$nombres)
                ->where('apellidos',$apellidos)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorCliCedNomApe', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 12:02 PM
     *
     * Consulta el listado de codeudores por id del cliente
     *
     * @param request $request: Peticiones realizadas.
     * @param integer $id:      Id del cliente.
     *
     * @return object
     */
    public static function ConsultarPorIdCliente($request, $id) {
        try {
            return Codeudor::where('id_cliente',$id)
                ->where('estado',1)
                ->orderBy('nombres')
                ->orderBy('apellidos')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorIdCliente', $e, $request);
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
}