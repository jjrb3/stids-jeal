<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PreguntasSeguridad extends Model
{
    public $timestamps = false;
    protected $table = 's_preguntas_seguridad';

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-23 - 10:35 AM
     *
     * Consulta todos los datos para el perfil de usuario
     *
     * @return array: Usuario
     */
    public static function ConsultarActivos() {
        try {
            $resultado = PreguntasSeguridad::where('estado',1)
                ->orderBy('nombre','ASC')
                ->get();

            return $resultado ? $resultado : [];

        } catch (\Exception $e) {
            return [];
        }
    }
}