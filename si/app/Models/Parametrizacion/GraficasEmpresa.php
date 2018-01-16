<?php
/**
 * Created by PhpStorm.
 * User: Jose Barrios
 * Date: 2017/11/27
 * Time: 1:46 PM
 */

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class GraficasEmpresa extends Model
{
    public $timestamps = false;
    protected $table = 's_graficas_empresa';

    const MODULO = 'Parametrizacion';
    const MODELO = 'GraficasEmpresa';

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-29 - 08:26 AM
     *
     * Consulta todas las graficas activas por empresa
     *
     * @param request $request:         Peticiones realizadas.
     * @param string  $buscar:          Texto que se buscará.
     * @param integer $pagina:          Posición de la pagina.
     * @param integer $tamanhioPagina:  Tamaño de la pagina.
     * @param integer $idEmpresa:       Id de la empresa.
     *
     * @return object
     */
    public static function ConsultarPorEmpresa($request, $buscar = '',$pagina = 1,$tamanhioPagina = 10, $idEmpresa) {

        try {
            $currentPage = $pagina;

            # Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return GraficasEmpresa::select(DB::raw('s_modulo.nombre AS modulo, s_graficas.*'))

                ->join('s_graficas','s_graficas_empresa.id_graficas','s_graficas.id')
                ->join('s_modulo','s_graficas.id_modulo','s_modulo.id')
                ->join('s_modulo_empresa','s_modulo.id','s_modulo_empresa.id_modulo')

                ->whereRaw(
                    "( s_modulo.nombre LIKE '%$buscar%' 
                    OR s_graficas.nombre LIKE '%$buscar%')"
                )
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->where('s_graficas.estado','1')
                ->where('s_modulo.estado','1')
                ->orderBy('s_modulo.nombre','ASC')
                ->orderBy('s_graficas.nombre','ASC')
                ->paginate($tamanhioPagina);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorEmpresa', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 01:26 PM
     *
     * Obtener id por grafica y empresa
     *
     * @param integer $idGrafica:       Id de la grafica.
     * @param integer $idEmpresa:       Id de la empresa.
     *
     * @return integer
     */
    public static function ObtenerIdPorGraficaEmpresa($idGrafica, $idEmpresa) {

        try {

            $resultado = GraficasEmpresa::select('id')
                ->where('id_empresa',$idEmpresa)
                ->where('id_graficas',$idGrafica)
                ->get();

            return $resultado->count() ? $resultado[0]->id : 0;
        }
        catch (\Exception $e) {

            return (object)[
                'resultado' => -2,
                'mensaje' => 'Grave error: ' . $e,
            ];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-05 - 12:18 PM
     *
     * Obtiene los permisos de la grafica por sesion por empresa
     *
     * @param integer $idModulo:  Id del módulo.
     * @param integer $idEmpresa: Id de la empresa.
     *
     * @return array
     */
    public static function PermisoGraficaPorEmpresa($idModulo,$idEmpresa) {
        try {
            $resultado = DB::select(
                "SELECT sg.*
                FROM s_modulo sm
                INNER JOIN s_modulo_empresa     sme ON  sme.id_modulo        = sm.id
                                                    AND sm.estado = 1
                INNER JOIN s_graficas           sg  ON  sg.id_modulo = sm.id
                                                    AND sg.estado = 1
                INNER JOIN s_graficas_empresa   sge ON  sge.id_graficas      = sg.id
                                                    AND sge.id_empresa       = sme.id_empresa
                WHERE sm.id = $idModulo
                AND sge.id_empresa = $idEmpresa"
            );

            return isset($resultado[0]) ? $resultado : [];
        }
        catch (\Exception $e) {
            return [
                'resultado' => -1,
                'mensaje' => 'Grave error, comuniquese con el administrador del sistema',
                'error' => $e
            ];
        }
    }
}