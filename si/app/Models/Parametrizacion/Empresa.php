<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Empresa extends Model
{
    public $timestamps = false;
    protected $table = "s_empresa";

    public static function sistema($request) {
        try {
            return Empresa::select('s_empresa.*','s_tema.*','s_empresa.nombre as empresa_nombre','s_tema.nombre as tema_nombre')
                		->join('s_tema','s_empresa.id_tema','=','s_tema.id')
			            ->where('s_empresa.id','=',($request->session()->get('idEmpresa')!= '' ? $request->session()->get('idEmpresa') : '1'))
			            ->where('s_empresa.estado','=','1')->get()->toArray()[0];
        } catch (Exception $e) {
            return array();
        }
    }


    public static function consultarTodo($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            if ($request->session()->get('idEmpresa') == 1) {

                return Empresa::select(
                        's_tema.nombre AS nombre_tema',
                        's_empresa.*'
                    )
                    ->join('s_tema','s_empresa.id_tema','=','s_tema.id')
                    ->whereRaw("(s_empresa.nit like '%{$request->get('buscador')}%'
                                 OR s_empresa.nombre like '%{$request->get('buscador')}%')")
                    ->orderBy('s_empresa.estado','desc')
                    ->orderBy('s_empresa.nombre')
                    ->paginate($request->get('tamanhioPagina'));
            }
            else {

                return Empresa::where('id','=',$request->session()->get('idEmpresa'))
                    ->paginate($request->get('tamanhioPagina'));
            }
                
        } catch (Exception $e) {
            return array();
        }         
    }


    public static function consultarActivo($request) {
        
        try {
            if ($request->session()->get('idEmpresa') == 1) {
                $resultado = Empresa::where('estado', '1')->get();
            }
            else {

                $resultado = Empresa::where('estado', '1')
                    ->where('id', $request->session()->get('idEmpresa'))->get();
            }

            return isset($resultado[0]) ? $resultado : array();
            
        } catch (Exception $e) {
            return array();
        }
    }


    public static function consultarId($id) {
        try {
            return Empresa::select(
                's_empresa.*',
                's_tema.id AS id_tema'
                )
                ->join('s_tema','s_empresa.id_tema','=','s_tema.id')
                ->where('s_empresa.id','=',$id)->get()->toArray();   
        } catch (Exception $e) {
            return array();
        } 
    }


    public static function eliminar($request)
    {
        try {
            if (Empresa::destroy($request->get('id'))) {
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
     * @date: 2017-11-13 - 04:44 PM
     *
     * Consulta listado de empresa por usuarios activos
     *
     * @param string $usuario: Nombre del usuario.
     *
     * @return array: Listado de empresas
     */
    public static function consultarPorUsuarioActivo($usuario) {
        try {
            $resultado = Usuario::select('s_empresa.*')
                ->where('s_usuario.usuario', '=', $usuario)
                ->join('s_empresa','s_usuario.id_empresa','=','s_empresa.id')
                ->where('s_usuario.estado','=','1')
                ->where('s_empresa.estado','=','1')
                ->get();

            return $resultado;

        } catch (\Exception $e) {
            return array();
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-17 - 18:59 PM
     *
     * Consulta todas las empresas
     *
     * @return array: Listado de empresas
     */
    public static function consultarTodo2() {
        try {
            $resultado = Empresa::orderBy('nombre','ASC')
                ->get();

            return $resultado;

        } catch (\Exception $e) {
            return array();
        }
    }
}