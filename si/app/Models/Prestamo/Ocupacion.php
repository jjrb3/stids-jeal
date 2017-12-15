<?php

namespace App\Models\Prestamo;

use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    public $timestamps = false;
    protected $table = "p_ocupacion";


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-11-01 - 2:07 PM
     *
     * Consultar todas las ocupaciones que esten activas
     *
     * @return array
     */
    public static function consultarActivo() {
        try {
            return Ocupacion::where('estado',1)
                ->orderBy('nombre','ASC')
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }
}