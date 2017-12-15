<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RespuestasSeguridad extends Model
{
    public $timestamps = false;
    protected $table = 's_respuesta_seguridad';

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-23 - 10:35 AM
     *
     * Consulta las respuesta de una pregunta de seguridad
     *
     * @param integer $idPregunta: Id de preguntas.
     *
     * @return array: Usuario
     */
    public static function consultarPorPreguntaActivo($idPregunta) {
        try {

            $resultado = RespuestasSeguridad::where('id_pregunta_seguridad',$idPregunta)
                ->where('estado',1)
                ->orderBy('descripcion','ASC')
                ->get();

            return $resultado ? $resultado : [];

        } catch (\Exception $e) {
            return [];
        }
    }
}