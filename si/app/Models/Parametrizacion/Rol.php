<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Rol extends Model
{
    public $timestamps = false;
    protected $table = "s_rol";

    public static function consultarTodo($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Rol::where('id_empresa',$request->session()->get('idEmpresa'))
                ->whereRaw("s_rol.nombre like '%{$request->get('buscador')}%'")
                ->orderBy('estado','desc')
                ->orderBy('nombre')
                ->paginate($request->get('tamanhioPagina'));

        } catch (Exception $e) {
            return array();
        } 
    }

    public static function consultarActivo($request) {
        
        try {
            $resultado = Rol::where('estado','=','1')
                    ->where('id_empresa',$request->session()->get('idEmpresa'))
                    ->orderBy('nombre')
                    ->get();

            return isset($resultado[0]) ? $resultado : array();
            
        } catch (Exception $e) {
            return array();
        }
    }

    public static function consultarEstado($estado) {
        try {
            return Rol::where('estado', '=', $estado)
                        ->orderBy('nombre')
                        ->get()->toArray();
        } catch (Exception $e) {
            return array();
        } 
    }

    public static function eliminar($request)
    {
        try {
            if (Rol::destroy($request->get('id'))) {
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
     * @date: 2017-11-13 - 05:39 PM
     *
     * Consulta roles activos por Empresa
     *
     * @param array     $request:   Peticiones realizadas.
     * @param integer   $idEmpresa: ID de la empresa.
     *
     * @return array: Vista parametrizado
     */
    public static function consultarActivoPorEmpresa($idEmpresa) {

        try {
            $resultado = Rol::where('estado','=','1')
                ->where('id_empresa',$idEmpresa)
                ->orderBy('nombre')
                ->get();

            return isset($resultado[0]) ? $resultado : array();

        } catch (Exception $e) {
            return array();
        }
    }
}