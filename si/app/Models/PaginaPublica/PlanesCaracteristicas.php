<?php

namespace App\Models\PaginaPublica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class PlanesCaracteristicas extends Model
{
    public $timestamps = false;
    protected $table = "s_planes_caracteristicas";


    public static function consultarId($id) {
        try {
            return PlanesCaracteristicas::where('id_planes',$id)
                ->orderBy('id','asc')->get();
        } catch (Exception $e) {
            return array();
        }
    }


    public static function eliminarPorId($id) {
        try {
            if (PlanesCaracteristicas::destroy($id)) {
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


    public static function eliminarPorPlan($idPlan) {
        try {
            if (PlanesCaracteristicas::where('id_planes',$idPlan)->delete()) {
                return array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                );
            }
            else {
                return array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar',
                );
            }
        }
        catch (Exception $e) {
            return array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            );
        }
    }
}