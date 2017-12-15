<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PermisoUsuarioModulo extends Model
{
    public $timestamps = false;
    protected $table = "s_permiso_usuario_modulo";

    const MODULO = 'Parametrizacion';
    const MODELO = 'PermisoUsuarioModulo';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-12 - 03:25 PM
     *
     * Consultar permiso por modulo
     *
     * @param request $request:     Peticiones realizadas.
     * @param integer $idUsuario:   Id de usuario
     * @param integer $idModulo:    Id modulo
     *
     * @return object
     */
    public static function consultarPorUsuarioModulo($request, $idUsuario,$idModulo) {
        try {
            return PermisoUsuarioModulo::join('s_modulo_empresa','s_permiso_usuario_modulo.id_modulo_empresa','s_modulo_empresa.id')
                ->where('s_permiso_usuario_modulo.id_usuario','=',(int)$idUsuario)
                ->where('s_modulo_empresa.id_modulo','=',$idModulo)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'SelectUsuarioPorEmpresa', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-11 - 03:59 PM
     *
     * Consulta listado de usuarios que tienen permisos
     *
     * @param request $request:   Peticiones realizadas.
     * @param integer $idEmpresa: Id empresa.
     *
     * @return object
     */
    public static function SelectUsuarioPorEmpresa($request, $idEmpresa) {
        try {
            return PermisoUsuarioModulo::select(DB::raw("DISTINCT s_usuario.id, CONCAT(s_usuario.nombres,' ',s_usuario.apellidos) AS nombre"))
                ->join('s_usuario','s_permiso_usuario_modulo.id_usuario','s_usuario.id')
                ->where('s_usuario.id_empresa',$idEmpresa)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'SelectUsuarioPorEmpresa', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-11 - 04:30 PM
     *
     * Consulta si existe permisos para el usuario
     *
     * @param request $request:         Peticiones realizadas.
     * @param integer $idUsuario:       Id usuario.
     * @param integer $idPermiso:       Id permiso.
     * @param integer $idModuloEmpresa: Id modulo empresa.
     *
     * @return object
     */
    public static function ConsultarSiExiste($request, $idUsuario, $idPermiso, $idModuloEmpresa) {
        try {
            return PermisoUsuarioModulo::select('id')
                ->where('id_usuario',$idUsuario)
                ->where('id_permiso',$idPermiso)
                ->where('id_modulo_empresa',$idModuloEmpresa)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarSiExiste', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-12 - 10:17 PM
     *
     * Consultar permisos espeicales por usuario
     *
     * @param request $request:   Peticiones realizadas.
     * @param integer $idUsuario: Id usuario.
     *
     * @return object
     */
    public static function ConsultarPorUsuario($request, $idUsuario) {
        try {
            return DB::select(
                "SELECT spum.id_modulo_empresa,
                        (SELECT CONCAT(mp.nombre,' / ',sm.nombre) FROM s_modulo mp WHERE mp.id = sm.id_padre) AS modulo,
                        group_concat(spum.id_permiso ORDER BY spum.id_permiso)                                AS permisos
                FROM s_permiso_usuario_modulo spum
                INNER JOIN s_modulo_empresa sme ON spum.id_modulo_empresa = sme.id
                INNER JOIN s_modulo sm          ON sme.id_modulo = sm.id
                WHERE spum.id_usuario = $idUsuario
                GROUP BY  modulo,
                          spum.id_modulo_empresa"
            );
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorUsuario', $e, $request);
        }
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-12 - 12:07 PM
     *
     * Borra
     *
     * @param request $request: Peticiones realizadas.
     * @param integer $id:      Id de usuario para borrar
     *
     * @return array
     */
    public static function EliminarPorId($request, $id) {

        try {
            if (PermisoUsuarioModulo::where('id',$id)->delete()) {
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
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'EliminarPorId', $e, $request);
        }
    }
}