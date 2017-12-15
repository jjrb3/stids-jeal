<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Sucursal extends Model
{
    public $timestamps = false;
    protected $table = "s_sucursal";

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
}