<?php
/**
 * Created by PhpStorm.
 * User: Jose Barrios
 * Date: 2017/11/27
 * Time: 1:46 PM
 */

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class GraficasDashboard extends Model
{
    public $timestamps = false;
    protected $table = 's_graficas_dashboard';

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-29 - 08:26 AM
     *
     * Consulta todas las graficas de un usuario
     *
     * @param string  $buscar:          Texto que se buscará.
     * @param integer $pagina:          Posición de la pagina.
     * @param integer $tamanhioPagina:  Tamaño de la pagina.
     * @param integer $idEmpresa:       Id de la empresa.
     * @param integer $idUsuario:       Id del usuario.
     *
     * @return object
     */
    public static function ConsultarPorEmpresaUsuario($buscar = '',$pagina = 1,$tamanhioPagina = 10, $idEmpresa, $idUsuario) {

        try {
            $currentPage = $pagina;

            # Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return GraficasDashboard::select(DB::raw('s_modulo.nombre AS modulo, s_graficas.*'))

                ->join('s_graficas_empresa','s_graficas_dashboard.id_graficas_empresa','s_graficas_empresa.id')
                ->join('s_graficas','s_graficas_empresa.id_graficas','s_graficas.id')
                ->join('s_modulo_empresa','s_graficas.id_modulo_empresa','s_modulo_empresa.id')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')

                ->whereRaw(
                    "( s_modulo.nombre LIKE '%$buscar%' 
                    OR s_graficas.nombre LIKE '%$buscar%')"
                )
                ->where('s_graficas_empresa.id_empresa',$idEmpresa)
                ->where('s_graficas_dashboard.id_usuario',$idUsuario)
                ->where('s_graficas.estado','1')
                ->where('s_modulo.estado','1')
                ->orderBy('s_graficas_dashboard.orden','ASC')
                ->paginate($tamanhioPagina);
        }
        catch (\Exception $e) {

            return (object)[
                'resultado' => -1,
                'mensaje' => 'Grave error: ' . $e,
            ];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 1:40 PM
     *
     * Devuelve el ultimo Orden que tendra una nueva grafica
     *
     * @param integer $idUsuario: Id de usuario.
     *
     * @return integer
     */
    public static function ObtenerUltimoOrden($idUsuario) {
        try {
            $resultado = GraficasDashboard::select(DB::raw('MAX(orden) AS orden'))
                ->where('id_usuario',$idUsuario)
                ->get();

            return $resultado[0]->orden + 1;
        }
        catch (\Exception $e) {

            return 0;
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 01:53 PM
     *
     * Borra una grafica del listado
     *
     * @param integer $idUsuario: Id de usuario para borrar
     * @param integer $idGrafica: Id de modulo para borrar
     *
     * @return array
     */
    public static function EliminarPorUsuarioGrafica($idUsuario,$idGrafica) {

        try {
            if (GraficasDashboard::where('id_usuario',$idUsuario)->where('id_graficas_empresa',$idGrafica)->delete()) {
                return [
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                ];
            }
            else {
                return [
                    'resultado' => 2,
                    'mensaje'   => 'No se encontraron datos para eliminar',
                ];
            }
        }
        catch (\Exception $e) {
            return [
                'resultado' => -2,
                'mensaje' => 'Grave error: ' . $e,
            ];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 2:10 PM
     *
     * Obtener por usuario y grafica
     *
     * @param integer $idUsuario: Id de usuario.
     * @param integer $idGrafica: Id de la grafica.
     *
     * @return object
     */
    public static function ObtenerPorUsuarioGrafica($idUsuario,$idGrafica) {
        try {
            $resultados = GraficasDashboard::select('s_graficas_dashboard.*')

                ->join('s_graficas_empresa','s_graficas_dashboard.id_graficas_empresa','s_graficas_empresa.id')
                ->join('s_graficas','s_graficas_empresa.id_graficas','s_graficas.id')
                ->join('s_modulo_empresa','s_graficas.id_modulo_empresa','s_modulo_empresa.id')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')

                ->where('s_graficas.id',$idGrafica)
                ->where('s_graficas_dashboard.id_usuario',$idUsuario)
                ->where('s_graficas.estado','1')
                ->where('s_modulo.estado','1')
                ->orderBy('s_modulo.nombre','ASC')
                ->orderBy('s_graficas.nombre','ASC')
                ->get();

            return $resultados ? $resultados[0] : [];
        }
        catch (\Exception $e) {

            return [];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 2:11 AM
     *
     * Obtiene todos las graficas por usuario
     *
     * @param integer $idUsuario: Id de usuario.
     *
     * @return object
     */
    public static function ObtenerPorUsuario($idUsuario) {

        try {

            return GraficasDashboard::where('id_usuario',$idUsuario)
                ->orderBy('orden','ASC')
                ->get();
        }
        catch (\Exception $e) {

            return null;
        }
    }
}