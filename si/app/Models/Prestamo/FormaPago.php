<?php

namespace App\Models\Prestamo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FormaPago extends Model
{
    public $timestamps = false;
    protected $table = "p_forma_pago";

    public static function consultarActivo() {
        try {
            return FormaPago::select(DB::raw("p_forma_pago.descripcion AS nombre"),'p_forma_pago.*')
                ->where('estado',1)
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }
}