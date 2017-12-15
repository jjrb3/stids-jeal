<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class SucursalCorreo extends Model
{
    public $timestamps = false;
    protected $table = "s_sucursal_correo";

    public static function consultarIdSucursal($id,$sucursales = '') {
        try {
            return SucursalCorreo::where('id_sucursal','=',$id)
                ->orderBy('correo')
                ->get()
                ->toArray();   
        } catch (Exception $e) {
            return array();
        } 
    }


    public static function eliminar($request)
    {
        try {
            if (SucursalCorreo::destroy($request->get('id'))) {
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