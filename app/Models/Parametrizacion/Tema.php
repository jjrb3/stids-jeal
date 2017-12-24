<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Tema extends Model
{
    public $timestamps = false;
    protected $table = "s_tema";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Tema';


    public static function consultarTodo($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Tema::whereRaw("(nombre like '%{$request->get('buscador')}%')")
            	->orderBy('id','desc')
                ->paginate($request->get('tamanhioPagina'));
                
        } catch (Exception $e) {
            return array();
        } 
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 09:30 AM
     *
     * Consultar todos
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function Consultar($request) {
        try {
            return Tema::orderBy('nombre','asc')->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultar', $e, $request);
        }
    }

    public static function eliminar($request)
    {
        try {
            if (Tema::destroy($request->get('id'))) {
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