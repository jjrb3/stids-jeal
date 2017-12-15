<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Departamento extends Model
{
    public $timestamps = false;
    protected $table = "s_departamento";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Departamento';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-15 - 09:38 AM
     *
     * Consultar los departamentos por pais
     *
     * @param request $request:     Peticiones realizadas.
     * @param integer $idPais:      Id del pais.
     * @param integer $buscar:      Texto a buscar.
     * @param integer $pagina:      Pagina actual.
     * @param integer $tamanhio:    Tamaño de la pagina.
     *
     * @return object
     */
    public static function ConsultarPorPais($request, $idPais, $buscar = null, $pagina = 1, $tamanhio = 10) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Departamento::whereRaw("s_departamento.nombre like '%{$buscar}%'")
                ->where('id_pais',$idPais)
                ->orderBy('nombre')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarPorPais', $e, $request);
        }
    }


     public static function eliminar($request)
    {
        try {
            if (Departamento::destroy($request->get('id'))) {
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
        catch (\Exception $e) {
            return response()->json(array(
                'resultado' => -1,
                'mensaje'   => 'Se encontraron problemas al eliminar'
            ));
        }
    }
}