<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Tema extends Model
{
    public $timestamps = false;
    protected $table = "s_tema";

    public static function consultarTodo($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Tema::whereRaw("(nombre like '%{$request->get('buscador')}%')")
            	->orderBy('id','desc')
                ->paginate($request->get('tamanhioPagina'));
                
        } catch (Exception $e) {
            return array();
        } 
    }

    public static function consultar() {
        try {
            $resultado = Tema::orderBy('nombre','asc')->get();

            return isset($resultado[0]) ? $resultado : array();
            
        } catch (Exception $e) {
            return array();
        }
    }

    public static function eliminar($request)
    {
        try {
            if (Tema::destroy($request->get('id'))) {
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