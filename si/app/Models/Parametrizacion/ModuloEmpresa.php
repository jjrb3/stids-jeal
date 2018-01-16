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
use Illuminate\Support\Facades\DB;


class ModuloEmpresa extends Model
{
    public $timestamps = false;
    protected $table = 's_modulo_empresa';

    public static $hs;
    const MODULO = 'Parametrizacion';
    const MODELO = 'ModuloEmpresa';

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-29 - 02:57 PM
     *
     * Obtenemos el id del modulo que puede ver las empresa
     *
     * @param integer $idModulo: Id de usuario para borrar.
     * @param integer $empresa:  Id de la empresa.
     *
     * @return integer
     */
    public static function ObtenerIdPorModuloEmpresa($idModulo,$idEmpresa) {

        try {

            $resultado = ModuloEmpresa::select('id')
                ->where('id_modulo',$idModulo)
                ->where('id_empresa',$idEmpresa)
                ->get();

            return $resultado->count() ? $resultado[0]->id : 0;
        }
        catch (\Exception $e) {

            return 0;
        }
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 2.0
     * @date: 2017-11-29 - 02:57 PM
     * @modify: 2017-12-06 - 05:50 PM - Jeremy Reyes B.
     *
     * Obtenemos el id del modulo que puede ver las empresa
     *
     * @param integer $empresa:  Id de la empresa.
     * @param integer $idPadre:  Id de padre.
     *
     * @return array
     */
    public static function ObtenerIdPorModuloEmpresaPadre($idEmpresa, $idPadre) {

        try {

            return ModuloEmpresa::select('s_modulo_empresa.id AS id')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')
                ->where('s_modulo.id_padre',$idPadre)
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->get();
        }
        catch (\Exception $e) {

            return [];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-07 - 12:15 PM
     *
     * Consulta el listado de modulos activos por Usuario
     *
     * @param request $request:   Peticiones realizadas.
     * @param integer $idEmpresa: Id empresa.
     *
     * @return object
     */
    public static function SelectModulosPorEmpresa($request, $idEmpresa) {
        try {
            return ModuloEmpresa::select(DB::raw("CONCAT((SELECT sm.nombre FROM s_modulo sm WHERE sm.id = s_modulo.id_padre),' / ',`s_modulo`.`nombre`) AS nombre"),'s_modulo_empresa.id')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')
                ->where('s_modulo.estado','1')
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->orderBy('s_modulo.nombre')
                ->where('id_padre','>',0)
                ->whereNull('s_modulo.enlace_usuario')
                ->get();
        } catch (\Exception $e) {
            return self::$hs->Log(self::MODULO,self::MODELO,'SelectModulosPorEmpresa', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-03 - 10:00 AM
     *
     * Obtiene el id de modulos por empresa y el nombre del modulo
     *
     * @param request $request:   Peticiones realizadas.
     * @param integer $idEmpresa: Id empresa.
     *
     * @return object
     */
    public static function ObtenerModulosPorEmpresa($request, $idEmpresa) {
        try {
            return ModuloEmpresa::select('s_modulo_empresa.id','s_modulo.nombre')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')
                ->where('s_modulo.estado','1')
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->orderBy('s_modulo.nombre')
                ->whereNull('s_modulo.id_padre')
                ->whereNull('s_modulo.enlace_usuario')
                ->get();
        } catch (\Exception $e) {
            return self::$hs->Log(self::MODULO,self::MODELO,'ObtenerModulosPorEmpresa', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-03 - 10:18 AM
     *
     * Obtiene el id de la sesion por empresa y modulo
     *
     * @param request $request:   Peticiones realizadas.
     * @param integer $idEmpresa: Id empresa.
     *
     * @return object
     */
    public static function ObtenerSesionPorEmpresaModulo($request, $idEmpresa, $idModulo) {
        try {
            return ModuloEmpresa::select('s_modulo_empresa.id','s_modulo.nombre')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')
                ->where('s_modulo.estado','1')
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->where('s_modulo.id_padre',$idModulo)
                ->whereNull('s_modulo.enlace_usuario')
                ->orderBy('s_modulo.nombre')
                ->get();
        } catch (\Exception $e) {
            return self::$hs->Log(self::MODULO,self::MODELO,'ObtenerSesionPorEmpresaModulo', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-27 - 01:50 PM
     *
     * Borrar por id
     *
     * @param integer $id
     *
     * @return array
     */
    public static function EliminarPorModulo($id) {

        try {
            if (ModuloEmpresa::where('id',$id)->delete()) {
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