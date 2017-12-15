<?php
/**
 * Created by PhpStorm.
 * User: Jose Barrios
 * Date: 2017/11/27
 * Time: 1:46 PM
 */

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;


class UsuarioPreguntasSeguridad extends Model
{
    public $timestamps = false;
    protected $table = 's_usuario_preguntas_seguridad';

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-27 - 01:50 PM
     *
     * Borra todas las preguntas por id del usuario
     *
     * @param integer $idUsuario: Id de usuario para borrar
     *
     * @return array: Usuario
     */
    public static function ConsultarPorUsuario($idUsuario) {

        try {
            $resultado = UsuarioPreguntasSeguridad::where('id_usuario',$idUsuario)
                ->get();

            return $resultado->count() ? $resultado : [];
        }
        catch (\Exception $e) {
            return [
                'resultado' => -2,
                'mensaje' => 'Grave error: ' . $e,
            ];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-27 - 01:50 PM
     *
     * Borra todas las preguntas por id del usuario
     *
     * @param integer $idUsuario: Id de usuario para borrar
     *
     * @return array: Usuario
     */
    public static function EliminarPorUsuario($idUsuario) {

        try {
            if (UsuarioPreguntasSeguridad::where('id_usuario','=',$idUsuario)->delete()) {
                return [
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                ];
            }
            else {
                return [
                    'resultado' => 2,
                    'mensaje'   => 'No se encontraron datos para eliminar',
                ];
            }
        }
        catch (\Exception $e) {
            return [
                'resultado' => -2,
                'mensaje' => 'Grave error: ' . $e,
            ];
        }
    }
}