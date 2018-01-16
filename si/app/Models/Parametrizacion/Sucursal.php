<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Sucursal extends Model
{
    public $timestamps = false;
    protected $table = "s_sucursal";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Sucursal';

    public static function consultarIdEmpresa($id) {
        try {
            return Sucursal::select(
                    's_municipio.nombre AS municipio_nombre',
                    's_sucursal.*'
                )
                ->where('s_sucursal.id_empresa','=',$id)
                ->join('s_municipio','s_sucursal.id_municipio','=','s_municipio.id')
                ->get();   
        } catch (Exception $e) {
            return array();
        } 
    }


    public static function eliminar($request)
    {
        try {
            if (Sucursal::destroy($request->get('id'))) {
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
     * @date: 2017-12-24 - 04:08 PM
     *
     * Consultar por id empresa
     *
     * @param request $request:     Peticiones realizadas.
     * @param integer $idEmpresa:   ID de la empresa.
     *
     * @return object
     */
    public static function ConsultarPorEmpresa($request, $idEmpresa) {
        try {
            return Sucursal::select(
                DB::raw(
                    "IF(s_sucursal.id_municipio <> null OR s_sucursal.id_municipio <> '',
                           (
                              SELECT CONCAT(sp.nombre,', ',sd.nombre,', ',sm.nombre)
                              FROM s_municipio sm
                              INNER JOIN s_departamento sd ON sd.id = sm.id_departamento
                              INNER JOIN s_pais         sp ON sp.id = sd.id_pais
                              WHERE sm.id = s_sucursal.id_municipio
                           ),
                          ''
                        ) AS ciudad,
                        s_sucursal.*
                    "
                )
            )
                ->where('id_empresa',(int)$idEmpresa)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorEmpresa', $e, $request);
        }
    }
}