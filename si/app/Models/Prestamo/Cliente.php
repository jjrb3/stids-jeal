<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    public $timestamps = false;
    protected $table = "p_cliente";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Cliente';


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
    public static function consultarTodo($request, $buscar = null, $pagina = 1, $tamanhio = 10, $idEmpresa) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Cliente::select(
                DB::raw(
                    "IF(p_cliente.id_municipio <> null OR p_cliente.id_municipio <> '',
                           (
                              SELECT CONCAT(sp.nombre,', ',sd.nombre,', ',sm.nombre)
                              FROM s_municipio sm
                              INNER JOIN s_departamento sd ON sd.id = sm.id_departamento
                              INNER JOIN s_pais         sp ON sp.id = sd.id_pais
                              WHERE sm.id = p_cliente.id_municipio
                           ),
                          ''
                        ) AS ciudad,
                        p_cliente.*
                    "
                )
            )
                ->whereRaw(
                "( identificacion like '%$buscar%'
                OR nombres like '%$buscar%'
                OR apellidos like '%$buscar%'
                OR direccion like '%$buscar%'
                OR telefono like '%$buscar%'
                OR celular like '%$buscar%')"
            )
                ->where('estado','>','-1')
                ->where('id_empresa',$idEmpresa)
                ->orderBy('estado','desc')
                ->orderBy('nombres')
                ->orderBy('apellidos')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarTodo', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 03:50 PM
     *
     * Consultar por tipo de empresa, identificacion, documento, nombres y apellidos
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     *
     * @return object
     */
    public static function ConsultarPorEmpTipIdeNomApe($request, $idEmpresa, $idTipoIdentificacion, $identificacion, $nombres, $apellidos) {
        try {
            return Cliente::where('id_empresa',$idEmpresa)
                ->where('id_tipo_identificacion',$idTipoIdentificacion)
                ->where('identificacion',$identificacion)
                ->where('nombres',$nombres)
                ->where('apellidos',$apellidos)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorEmpTipIdeNomApe', $e, $request);
        }
    }


    public static function consultarActivo($request) {
        try {
            return Cliente::select(DB::raw("CONCAT(p_cliente.nombres,' ',p_cliente.apellidos) as nombre"),'p_cliente.*')
                ->where('estado',1)
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-16 - 06:35 AM
     *
     * Consultar información por id del cliente
     *
     * @param request $request: Peticiones realizadas.
     * @param string  $id:      ID Cliente.
     *
     * @return object
     */
    public static function ConsultarInformacionPorId($request, $id) {
        try {
            return Cliente::select(
                'p_cliente.*',
                's_tipo_identificacion.nombre AS nombre_tipo_identificacion',
                'p_estado_civil.nombre AS nombre_estado_civil',
                's_banco.nombre AS nombre_banco',
                'p_ocupacion.nombre AS nombre_ocupacion',
                DB::raw(
                    "IF(p_cliente.id_municipio <> null OR p_cliente.id_municipio <> '',
                           (
                              SELECT CONCAT(sp.nombre,', ',sd.nombre,', ',sm.nombre)
                              FROM s_municipio sm
                              INNER JOIN s_departamento sd ON sd.id = sm.id_departamento
                              INNER JOIN s_pais         sp ON sp.id = sd.id_pais
                              WHERE sm.id = p_cliente.id_municipio
                           ),
                          ''
                        ) AS ciudad
                    "
                )
            )
                ->join('s_tipo_identificacion','p_cliente.id_tipo_identificacion','s_tipo_identificacion.id')
                ->leftJoin('p_estado_civil','p_cliente.id_estado_civil','p_estado_civil.id')
                ->leftJoin('s_banco','p_cliente.id_banco_cliente','s_banco.id')
                ->leftJoin('p_ocupacion','p_cliente.id_ocupacion','p_ocupacion.id')

                ->where('p_cliente.id',$id)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarInformacionPorId', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-16 - 2:24 PM
     *
     * Obtiene nuevo codigo
     *
     * @param request   $request:   Peticiones realizadas.
     * @param integer   $idEmpresa: ID Empresa.
     *
     * @return object
     */
    public static function ObtenerNuevoCodigo($request, $idEmpresa) {
        try {
            $resultado = Cliente::select(DB::raw('MAX(codigo) AS codigo'))
                ->where('id_empresa',$idEmpresa)
                ->get();

            return $resultado[0]->codigo + 1;
        }
        catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarInformacionPorId', $e, $request);
        }
    }
}