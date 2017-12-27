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


class ModulosDashboard extends Model
{
    public $timestamps = false;
    protected $table = 's_modulos_dashboard';

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-29 - 08:26 AM
     *
     * Borra todas las preguntas por id del usuario
     *
     * @param string  $buscar:          Texto que se buscará.
     * @param integer $pagina:          Posición de la pagina.
     * @param integer $tamanhioPagina:  Tamaño de la pagina.
     * @param integer $idUsuario:       Id de usuario.
     *
     * @return object
     */
    public static function ConsultarPorUsuario($buscar = '',$pagina = 1,$tamanhioPagina = 10,$idUsuario) {

        try {
            $currentPage = $pagina;

            # Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return ModulosDashboard::join('s_modulo_empresa','s_modulos_dashboard.id_modulo_empresa','s_modulo_empresa.id')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')
                ->whereRaw("(s_modulo.nombre like '%$buscar%' OR s_modulo.descripcion like '%$buscar%')")
                ->where('s_modulos_dashboard.id_usuario',$idUsuario)
                ->where('s_modulo.estado','1')
                ->orderBy('s_modulos_dashboard.orden','ASC')
                ->paginate($tamanhioPagina);
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
     * @date: 2017-11-29 - 02:57 PM
     *
     * Devuelve el ultimo Orden que tendra un nuevo modulo
     *
     * @param integer $idUsuario: Id de usuario.
     *
     * @return integer
     */
    public static function ObtenerUltimoOrden($idUsuario) {

        try {

            $resultado = ModulosDashboard::select(DB::raw('MAX(orden) AS orden'))
                ->where('s_modulos_dashboard.id_usuario',$idUsuario)
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
     * @date: 2017-11-30 - 10:29 AM
     *
     * Obtiene todos los modulos por usuario
     *
     * @param integer $idUsuario: Id de usuario.
     *
     * @return object
     */
    public static function ObtenerPorUsuario($idUsuario) {

        try {

            return ModulosDashboard::where('id_usuario',$idUsuario)
                ->orderBy('orden','ASC')
                ->get();
        }
        catch (\Exception $e) {

            return null;
        }
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 09:29 AM
     *
     * Obtener por modulo
     *
     * @param integer $idUsuario: Id de usuario.
     * @param integer $idModulo:  Id del modulo.
     *
     * @return object
     */
    public static function ObtenerPorUsuarioModulo($idUsuario,$idModulo) {

        try {

            $resultados = ModulosDashboard::select('s_modulos_dashboard.*')
                ->join('s_modulo_empresa','s_modulos_dashboard.id_modulo_empresa','s_modulo_empresa.id')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')
                ->where('s_modulo.id',$idModulo)
                ->where('s_modulos_dashboard.id_usuario',$idUsuario)
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
     * @date: 2017-11-29 - 02:57 PM
     *
     * Devuelve el ultimo Orden que tendra un nuevo modulo
     *
     * @param integer $idUsuario: Id de usuario.
     * @param integer $idModulo:  Id del módulo.
     *
     * @return integer
     */
    public static function obtenerOrdenPorUsuarioModulo($idUsuario,$idModulo) {

        try {

            $resultado = ModulosDashboard::select('s_modulos_dashboard.orden AS orden')
                ->join('s_modulo_empresa','s_modulos_dashboard.id_modulo_empresa','s_modulo_empresa.id')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')
                ->where('s_modulo.id',$idModulo)
                ->where('s_modulos_dashboard.id_usuario',$idUsuario)
                ->get();

            return $resultado ? $resultado[0]->orden : 0;
        }
        catch (\Exception $e) {

            return 0;
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-27 - 01:50 PM
     *
     * Borra un modulo del listado
     *
     * @param integer $idUsuario: Id de usuario para borrar
     * @param integer $idModulo:  Id de modulo para borrar
     *
     * @return array
     */
    public static function EliminarPorUsuarioModulo($idUsuario,$idModulo) {

        try {
            if (ModulosDashboard::where('id_usuario',$idUsuario)->where('id_modulo_empresa',$idModulo)->delete()) {
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
     * @date: 2017-11-27 - 01:50 PM
     *
     * Borrar por id modulo
     *
     * @param integer $idModulo:  Id de modulo para borrar
     *
     * @return array
     */
    public static function EliminarPorModulo($idModulo) {

        try {
            if (ModulosDashboard::where('id_modulo_empresa',$idModulo)->delete()) {
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
}