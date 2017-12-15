<?php

namespace App\Models\PaginaPublica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class ImagenPlataforma extends Model
{
    public $timestamps = false;
    protected $table = "s_imagen_plataforma";

    public static function consultarTodo($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return ImagenPlataforma::where('id_empresa','=',$request->session()->get('idEmpresa'))
                ->whereIn('id_tipo_imagen', explode(',',$request->get('id_tipo_imagen')))
                ->orderBy('id','desc')
                ->paginate($request->get('tamanhioPagina'));
        } catch (Exception $e) {
            return array();
        }
    }

    public static function consultarId($request) {
        try {
            return Usuario::select('s_usuario.*','s_municipio.nombre AS nombre_municipio')
                ->join('s_municipio','s_usuario.id_municipio','=','s_municipio.id')
                ->where('s_usuario.id','=',$request->get('id'))->get()->toArray();
        } catch (Exception $e) {
            return array();
        }
    }

    public static function nombreUsuarioActivo($nombreUsuario) {
        try {
            $resultado = Usuario::select('s_usuario.*')
                ->where('s_usuario.usuario', '=', $nombreUsuario)
                ->join('s_empresa','s_usuario.id_empresa','=','s_empresa.id')
                ->where('s_usuario.estado','=','1')
                ->where('s_empresa.estado','=','1')
                ->get();

            return isset($resultado[0]) ? $resultado[0] : array();

        } catch (Exception $e) {
            return array();
        }
    }


    public static function menu($idUsuario) {

        try {
            return Usuario::select('s_modulo.*','s_modulo_rol.id_rol')
                ->join('s_rol','s_usuario.id_rol','=','s_rol.id')
                ->join('s_modulo_rol','s_rol.id','=','s_modulo_rol.id_rol')
                ->join('s_modulo','s_modulo_rol.id_modulo','=','s_modulo.id')
                ->where('s_usuario.id', '=', $idUsuario)
                ->where('s_modulo.id_padre','=', NULL)
                ->where('s_usuario.estado', '=', 1)
                ->where('s_modulo.estado', '=', 1)
                ->orderBy('s_modulo.orden')
                ->get()->toArray();
        } catch (Exception $e) {
            return array();
        }
    }


    public static function eliminarPorId($id) {
        try {
            if (ImagenPlataforma::destroy($id)) {
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