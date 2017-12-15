<?php

namespace App\Models\Prestamo;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    public $timestamps = false;
    protected $table = "p_estado_civil";


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-11-01 - 2:07 PM
     *
     * Consultar todos los estados civiles que esten activos
     *
     * @return array
     */
    public static function consultarActivo() {
        try {
            return EstadoCivil::where('estado',1)
                ->orderBy('nombre','ASC')
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }
}