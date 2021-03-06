<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Etiqueta extends Model
{
    public $timestamps = false;
    protected $table = "s_etiqueta";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Etiqueta';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 09:30 AM
     *
     * Consultar todos con paginacion
     *
     * @param request   $request:     Peticiones realizadas.
     * @param interger  $idEmpresa:   ID de la empresa.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     *
     * @return object
     */
    public static function ConsultarTodo($request, $idEmpresa, $buscar = null, $pagina = 1, $tamanhio = 10) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            $sql = Empresa::select(
                    's_tema.nombre AS tema',
                    's_empresa.*'
                )
                ->join('s_tema','s_empresa.id_tema','=','s_tema.id')
                ->whereRaw("(s_empresa.nit like '%{$buscar}%'
                             OR s_empresa.nombre like '%{$buscar}%')")
                ->where('estado','>','-1')
                ->orderBy('s_empresa.estado','desc')
                ->orderBy('s_empresa.nombre');

            if ($idEmpresa > 1) {
                $sql->where('s_empresa.id',$idEmpresa);
            }

            return $sql->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarTodo', $e, $request);
        }
    }


    public static function ConsultarActivo($request) {
        try {

            return Etiqueta::where('estado', 1)
                ->orderBy('nombre')
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarActivo', $e, $request);
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


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 11:32 AM
     *
     * Consultar por nit y nombre
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nit:         NIT.
     * @param string  $nombre:      Nombre.
     *
     * @return object
     */
    public static function ConsultarPorNitNombre($request, $nit, $nombre) {
        try {
            return Empresa::where('nit',(string)$nit)
                ->orWhere('nombre',(string)$nombre)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorNitNombre', $e, $request);
        }
    }
}