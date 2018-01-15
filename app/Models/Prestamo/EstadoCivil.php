<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    public $timestamps = false;
    protected $table = "p_estado_civil";

    const MODULO = 'Parametrizacion';
    const MODELO = 'EstadoCivil';

    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-11-01 - 2:07 PM
     *
     * Consultar todos los estados civiles que esten activos
     *
     * @param request $request:     Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarActivo($request) {
        try {
            return EstadoCivil::where('estado',1)
                ->orderBy('nombre','ASC')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarActivo', $e, $request);
        }
    }
}