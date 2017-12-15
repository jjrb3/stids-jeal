<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class TipoIdentificacion extends Model
{
    public $timestamps = false;
    protected $table = "s_tipo_identificacion";

    const MODULO = 'Parametrizacion';
    const MODELO = 'TipoIdentificacion';


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

            return TipoIdentificacion::where('id_empresa',(int)$idEmpresa)
                ->whereRaw("s_tipo_identificacion.nombre like '%{$buscar}%'")
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
     * @date: 2017-12-13 - 10:04 AM
     *
     * Consultar permiso por modulo
     *
     * @param request $request:     Peticiones realizadas.
     * @param integer $idEmpresa:   Id de la empresa.
     *
     * @return object
     */
    public static function consultarActivo($request, $idEmpresa) {
        try {
            return TipoIdentificacion::where('estado', '1')
                ->where('id_empresa',(int)$idEmpresa)
                ->orderBy('nombre','ASC')
                ->get()->toArray();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarActivo', $e, $request);
        } 
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-13 - 10:52 AM
     *
     * Consultar por nombre
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     * @param integer $idEmpresa:   ID de la empresa.
     *
     * @return object
     */
    public static function ConsultarPorNombreEmpresa($request, $nombre, $idEmpresa) {
        try {
            return TipoIdentificacion::where('nombre',(string)$nombre)
                ->where('id_empresa',(int)$idEmpresa)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorNombre', $e, $request);
        }
    }


    public static function consultarEstado($estado) {
    	try {
	    	return TipoIdentificacion::where('estado', '=', $estado)
	                    ->orderBy('nombre')
	                    ->get()->toArray();
		} catch (Exception $e) {
            return array();
        } 
    }

    public static function eliminar($request)
    {
        try {
            if (TipoIdentificacion::destroy($request->get('id'))) {
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
