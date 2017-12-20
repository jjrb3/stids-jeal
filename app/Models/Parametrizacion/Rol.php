<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Rol extends Model
{
    public $timestamps = false;
    protected $table = "s_rol";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Rol';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-13 - 10:04 AM
     *
     * Consultar todos con paginacion
     *
     * @param request $request:     Peticiones realizadas.
     * @param integer $idEmpresa:   Id de la empresa.
     * @param integer $buscar:      Texto a buscar.
     * @param integer $pagina:      Pagina actual.
     * @param integer $tamanhio:    Tamaño de la pagina.
     *
     * @return object
     */
    public static function consultarTodo($request, $idEmpresa, $buscar = null, $pagina = 1, $tamanhio = 10) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Rol::where('id_empresa',(int) $idEmpresa)
                ->whereRaw("s_rol.nombre like '%{$buscar}%'")
                ->where('estado','>','-1')
                ->orderBy('estado','desc')
                ->orderBy('nombre')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarTodo', $e, $request);
        } 
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 12:01 PM
     *
     * Consultar activos
     *
     * @param request $request:     Peticiones realizadas.
     * @param integer $idEmpresa:   Id de la empresa.
     *
     * @return object
     */
    public static function consultarActivo($request, $idEmpresa) {
        
        try {
            return Rol::where('estado','1')
                    ->where('id_empresa',$idEmpresa)
                    ->orderBy('nombre')
                    ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarActivo', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 12:58 PM
     *
     * Consultar por nombre y empresa
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     * @param integer $idEmpresa:   ID de la empresa.
     *
     * @return object
     */
    public static function ConsultarPorNombreEmpresa($request, $nombre, $idEmpresa) {
        try {
            return Rol::where('nombre',(string)$nombre)
                ->where('id_empresa',(int)$idEmpresa)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorNombre', $e, $request);
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