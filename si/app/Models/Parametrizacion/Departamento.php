<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Departamento extends Model
{
    public $timestamps = false;
    protected $table = "s_departamento";

    public static function consultarPorPais($idPais) {
        try {
            $resultado = Departamento::where('id_pais','=',(int)$idPais)
                                    ->orderBy('nombre','asc')->get();

            return isset($resultado[0]) ? $resultado : array();
            
        } catch (Exception $e) {
            return array();
        }
    }


    public static function consultar($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Departamento::whereRaw("s_departamento.nombre like '%{$request->get('buscador')}%'")
                ->where('id_pais','=',$request->get('id_pais'))
                ->orderBy('nombre')
                ->paginate($request->get('tamanhioPagina'));

        } catch (Exception $e) {
            return array();
        } 
    }


     public static function eliminar($request)
    {
        try {
            if (Departamento::destroy($request->get('id'))) {
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
}