<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Sexo extends Model
{
    public $timestamps = false;
    protected $table = "s_sexo";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Sexo';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-13 - 10:04 AM
     *
     * Consultar todos con paginacion
     *
     * @param request   $request:     Peticiones realizadas.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     *
     * @return object
     */
    public static function consultarTodo($request, $buscar = null, $pagina = 1, $tamanhio = 10) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Sexo::where('estado','>','-1')
                ->whereRaw("s_sexo.nombre like '%{$buscar}%'")
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
     * @date: 2017-12-20 - 02:15 PM
     *
     * Consultar activos
     *
     * @param request $request:     Peticiones realizadas.
     *
     * @return object
     */
    public static function consultarActivo($request) {
        
        try {
            return Sexo::where('estado','1')
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
     * @date: 2017-12-20 - 02:18 PM
     *
     * Consultar por nombre y empresa
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     *
     * @return object
     */
    public static function ConsultarPorNombreEmpresa($request, $nombre) {
        try {
            return Sexo::where('nombre',(string)$nombre)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorNombre', $e, $request);
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