<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;

class ModuloRol extends Model
{
    public $timestamps = false;
    protected $table = "s_modulo_rol";

    const MODULO = 'Parametrizacion';
    const MODELO = 'ModuloRol';


    public static function submenuRolPadre($idRol,$idPadre) {

    	try {
	    	return ModuloRol::select('s_modulo.*')
	                    ->join('s_modulo_empresa','s_modulo_rol.id_modulo_empresa','=','s_modulo_empresa.id')
	                    ->join('s_modulo','s_modulo_empresa.id_modulo','=','s_modulo.id')
	                    ->where('s_modulo_rol.id_rol', '=', $idRol)
	                    ->where('s_modulo.id_padre','=', $idPadre)
	                    ->where('s_modulo.estado', '=', 1)
	                    ->orderBy('s_modulo.orden')
	                    ->get()->toArray();
		} catch (\Exception $e) {
            return array();
        } 
    }


    public static function ConsultarPermisoModuloRol($idModulo,$idRol) {
    	try {
	    	return ModuloRol::select('s_modulo.*','s_modulo_empresa.id AS id_modulo_empresa','s_modulo_rol.id AS id_modulo_rol')
                ->join('s_modulo_empresa','s_modulo_rol.id_modulo_empresa','=','s_modulo_empresa.id')
                ->join('s_modulo','s_modulo_empresa.id_modulo','=','s_modulo.id')
                ->where('s_modulo_rol.id_rol', '=', $idRol)
	            ->where('s_modulo.id','=', $idModulo)
	            ->get();
		} catch (\Exception $e) {
            return [];
        } 
    }


    public static function eliminar($id)
    {
        try {
            if (ModuloRol::destroy($id)) {
                return response()->json(array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                ));
            }
            else {
                return response()->json(array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar, verifique que no tenga Departamentos este País',
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
     * @date: 2017-12-27 - 10:07 AM
     *
     * Obtener ids por modulo
     *
     * @param request   $request:     Peticiones realizadas.
     * @param interger  $idModulo:    ID modulo.
     *
     * @return object
     */
    public static function ObtenerIdsPorModulo($request, $idModulo) {
        try {
            return ModuloRol::select('id')
                ->where('id_modulo_empresa',$idModulo)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ObtenerIdsPorModulo', $e, $request);
        }
    }
}