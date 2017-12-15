<?php

namespace App\Models\Prestamo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoPrestamo extends Model
{
    public $timestamps = false;
    protected $table = "p_tipo_prestamo";

    public static function consultarActivo() {
        try {
            return TipoPrestamo::select(DB::raw("p_tipo_prestamo.descripcion AS nombre"),'p_tipo_prestamo.*')
                ->where('estado',1)
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }
}