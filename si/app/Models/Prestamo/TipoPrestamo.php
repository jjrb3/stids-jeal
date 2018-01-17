<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoPrestamo extends Model
{
    public $timestamps = false;
    protected $table = "p_tipo_prestamo";

    const MODULO = 'Prestamo';
    const MODELO = 'TipoPrestamo';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-17 - 10:26 AM
     *
     * Consultar activos
     *
     * @param request $request:     Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarActivo($request) {
        try {
            return TipoPrestamo::where('estado',1)
                ->orderBy('nombre')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarActivo', $e, $request);
        }
    }
}