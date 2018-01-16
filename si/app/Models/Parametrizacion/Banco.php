<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Banco extends Model
{
    public $timestamps = false;
    protected $table = "s_banco";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Banco';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-13 - 12:45 PM
     *
     * Consultar todos con paginacion
     *
     * @param request   $request:     Peticiones realizadas.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     * @param integer   $idEmpresa:   ID empresa.
     *
     * @return object
     */
    public static function consultarTodo($request, $buscar = null, $pagina = 1, $tamanhio = 10, $idEmpresa) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Banco::where('estado','>','-1')
                ->whereRaw("s_banco.nombre like '%{$buscar}%'")
                ->where('id_empresa',$idEmpresa)
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
     * @date: 2018-01-13 - 12:45 PM
     *
     * Consultar activos
     *
     * @param request $request:     Peticiones realizadas.
     * @param integer   $idEmpresa:   ID empresa.
     *
     * @return object
     */
    public static function ConsultarActivo($request, $idEmpresa) {
        
        try {
            return Banco::where('estado','1')
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
     * @date: 2018-01-13 - 12:45 PM
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
            return Banco::where('nombre',(string)$nombre)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorNombre', $e, $request);
        }
    }
}