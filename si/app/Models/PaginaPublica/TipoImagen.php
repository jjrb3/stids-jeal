<?php

namespace App\Models\PaginaPublica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class TipoImagen extends Model
{
    public $timestamps = false;
    protected $table = "s_tipo_imagen";

    public static function consultarTodo($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return ImagenPlataforma::where('id_empresa','=',$request->session()->get('idEmpresa'))
                ->where('id_tipo_imagen','=',$request->get('id_tipo_imagen'))
                ->orderBy('id','desc')
                ->paginate($request->get('tamanhioPagina'));

        } catch (Exception $e) {
            return array();
        }
    }

    public static function consultarCarpetaPorId($id) {
        try {
            return TipoImagen::select('carpeta')
                ->where('id','=',$id)
                ->get()
                ->toArray()[0]['carpeta'];
        } catch (Exception $e) {
            return array();
        }
    }

    public static function eliminarPorId($id) {
        try {
            if (Usuario::destroy($id)) {
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