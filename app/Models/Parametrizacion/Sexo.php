<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Sexo extends Model
{
    public $timestamps = false;
    protected $table = "s_sexo";

    public static function consultarTodo($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Sexo::orderBy('estado','desc')
                ->whereRaw("s_sexo.nombre like '%{$request->get('buscador')}%'")
                ->orderBy('estado','desc')
                ->orderBy('nombre')
                ->paginate($request->get('tamanhioPagina'));

        } catch (Exception $e) {
            return array();
        } 
    }

    public static function consultarActivo() {
        
        try {
            $resultado = Sexo::where('estado','=','1')->get();

            return isset($resultado[0]) ? $resultado : array();
            
        } catch (Exception $e) {
            return array();
        }
    }

    public static function consultarEstado($estado) {
        try {
            return Sexo::where('estado', '=', $estado)
                        ->orderBy('nombre')
                        ->get()->toArray();
        } catch (Exception $e) {
            return array();
        } 
    }

    public static function eliminar($request)
    {
        try {
            if (Sexo::destroy($request->get('id'))) {
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