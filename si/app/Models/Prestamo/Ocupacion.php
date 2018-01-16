<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    public $timestamps = false;
    protected $table = "p_ocupacion";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Ocupacion';


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
            return Ocupacion::where('estado',1)
                ->orderBy('nombre','ASC')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarActivo', $e, $request);
        }
    }
}