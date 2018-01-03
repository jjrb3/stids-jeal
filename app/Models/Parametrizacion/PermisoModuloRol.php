<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;

class PermisoModuloRol extends Model
{
    public $timestamps = false;
    protected $table = "s_permiso_modulo_rol";

    const MODULO = 'Parametrizacion';
    const MODELO = 'PermisoUsuarioModulo';


	public static function consultarPermisosModulo($request, $idRol,$idModulo) {

		try {
	        return PermisoModuloRol::select('s_permiso_modulo_rol.*')
	        			->join('s_modulo_rol','s_permiso_modulo_rol.id_modulo_rol','=','s_modulo_rol.id')
	        			->join('s_modulo_empresa','s_modulo_rol.id_modulo_empresa','=','s_modulo_empresa.id')
	        			->where('s_modulo_rol.id_rol',$idRol)
	        			->where('s_modulo_empresa.id_modulo',$idModulo)
	        			->get()
	        			->toArray();
	    } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'SelectUsuarioPorEmpresa', $e, $request);
        }
    }


    public static function consultarPermisosModuloRol($idPermiso,$idModulo, $idRol) {

		try {

		    return PermisoModuloRol::join('s_modulo_rol','s_permiso_modulo_rol.id_modulo_rol','=','s_modulo_rol.id')
                ->join('s_modulo_empresa','s_modulo_rol.id_modulo_empresa','=','s_modulo_empresa.id')
                ->where('s_modulo_empresa.id_modulo',$idModulo)
                ->where('s_permiso_modulo_rol.id_permiso',$idPermiso)
                ->where('s_modulo_rol.id_rol',$idRol)
                ->get();
	    } catch (\Exception $e) {
            return [];
        } 
    }


    public static function eliminarPorModulo($idModulo)
    {
        try {
            if (PermisoModuloRol::where('id_modulo_rol','=',$idModulo)->delete()) {
                return response()->json(array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                ));
            }
            else {
                return response()->json(array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar',
                ));
            }
        }
        catch (Exception $e) {
            return response()->json(array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            ));
        }
    }


    public static function eliminarPorModuloPermiso($idModulo,$permiso)
    {
        try {
            if (PermisoModuloRol::where('id_modulo_rol','=',$idModulo)->where('id_permiso','=',$permiso)->delete()) {
                return response()->json(array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                ));
            }
            else {
                return response()->json(array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar',
                ));
            }
        }
        catch (Exception $e) {
            return response()->json(array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            ));
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-03 - 02:41 PM
     *
     * Obtener ids por modulo
     *
     * @param request   $request:     Peticiones realizadas.
     * @param interger  $idModuloRol: ID modulo rol.
     *
     * @return object
     */
    public static function ObtenerPorModuloRol($request, $idModuloRol) {
        try {
            return PermisoModuloRol::select('id_permiso')
                ->where('id_modulo_rol',$idModuloRol)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ObtenerPorModuloRol', $e, $request);
        }
    }
}