<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Municipio extends Model
{
    public $timestamps = false;
    protected $table = "s_municipio";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Municipio';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-15 - 09:50 AM
     *
     * Consultar los municipios por departamento
     *
     * @param request $request:         Peticiones realizadas.
     * @param integer $idDepartamento:  Id del departamento.
     * @param integer $buscar:          Texto a buscar.
     * @param integer $pagina:          Pagina actual.
     * @param integer $tamanhio:        Tamaño de la pagina.
     *
     * @return object
     */
    public static function ConsultarPorDepartamento($request, $idDepartamento, $buscar = null, $pagina = 1, $tamanhio = 10) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Municipio::whereRaw("s_municipio.nombre like '%{$buscar}%'")
                ->where('id_departamento',$idDepartamento)
                ->orderBy('nombre')
                ->paginate($tamanhio);
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorDepartamento', $e, $request);
        }
    }


    public static function consultar($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Municipio::whereRaw("s_municipio.nombre like '%{$request->get('buscador')}%'")
                ->where('id_departamento','=',$request->get('id_departamento'))
                ->orderBy('nombre')
                ->paginate($request->get('tamanhioPagina'));

        } catch (Exception $e) {
            return array();
        } 
    }


     public static function eliminar($request)
    {
        try {
            if (Municipio::destroy($request->get('id'))) {
                return response()->json(array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                ));
            }
            else {
                return response()->json(array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar, verifique que no tenga Departamentos este País',
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