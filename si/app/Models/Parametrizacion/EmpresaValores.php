<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class EmpresaValores extends Model
{
    public $timestamps = false;
    protected $table = "s_empresa_valores";

    const MODULO = 'Parametrizacion';
    const MODELO = 'EmpresaValores';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-04 - 05:17 PM
     *
     * Consultar todos con paginacion
     *
     * @param request   $request:     Peticiones realizadas.
     * @param integer   $idEmpresa:   ID empresa.
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

            return EmpresaValores::where('estado','>','-1')
                ->whereRaw("s_empresa_valores.nombre like '%{$buscar}%'")
                ->where('id_empresa',$idEmpresa)
                ->orderBy('nombre')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarTodo', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-04 - 05:21 PM
     *
     * Consultar por nombre y empresa
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     *
     * @return object
     */
    public static function ConsultarPorNombreEmpresa($request, $nombre, $idEmpresa) {
        try {
            return EmpresaValores::where('id_empresa',$idEmpresa)
                ->where('nombre',(string)$nombre)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorNombre', $e, $request);
        }
    }
}