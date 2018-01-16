<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\UsuarioPreguntasSeguridad;
use Illuminate\Http\Request;
use App\Models\Parametrizacion\PreguntasSeguridad;
use App\Models\Parametrizacion\RespuestasSeguridad;


class PreguntasSeguridadController extends Controller
{
    public static $hs;
    public static $resultado;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-23 - 10:15 AM
     * @see: 1. Usuario::consultarPerfil.
     *       2. Sexo::consultarActivo.
     *
     * Consulta los datos del perfil de usuario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return json
     */
    public static function ConsultarPreguntasConRespuestas(Request $request) {

        $resultado  = 1;
        $aRespuesta = [];

        if ($preguntas = PreguntasSeguridad::ConsultarActivos()) {

            foreach ($preguntas as $k => $i) {

                $respuesta = RespuestasSeguridad::consultarPorPreguntaActivo($i->id);

                if ($respuesta->count()) {
                    $preguntas[$k]->existe_respuesta = true;
                    $preguntas[$k]->respuesta        = $respuesta;
                    $aRespuesta[$i->id]              = $respuesta->toArray();
                }
                else {
                    $preguntas[$k]->existe_respuesta = false;
                    $preguntas[$k]->respuesta        = [];
                    $aRespuesta[$i->id]              = $respuesta->toArray();
                }
            }
        }
        else {
            $resultado = 0;
        }

        return response()->json([
            'resultado'         => $resultado,
            'datos'             => $preguntas,
            'respuesta'         => $aRespuesta,
            'seguridad_usuario' => UsuarioPreguntasSeguridad::ConsultarPorUsuario($request->session()->get('idUsuario'))
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-23 - 11:56 AM
     * @see: 1. self::$hs->verificationDatas.
     *
     * Guarda los datos de perfil.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return json
     */
    public static function GuardarRespuestas(Request $request) {

        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'pregunta_1'     => 'No puede dejar vacio la pregunta No. 1',
            'pregunta_2'     => 'No puede dejar vacio la pregunta No. 2',
            'pregunta_3'     => 'No puede dejar vacio la pregunta No. 3',
            'pregunta_4'     => 'No puede dejar vacio la pregunta No. 4',
            'respuesta_1'    => 'No puede dejar vacio la respuesta de la pregunta No. 1',
            'respuesta_2'    => 'No puede dejar vacio la respuesta de la pregunta No. 2',
            'respuesta_3'    => 'No puede dejar vacio la respuesta de la pregunta No. 3',
            'respuesta_4'    => 'No puede dejar vacio la respuesta de la pregunta No. 4',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Eliminamos todas las preguntas que tenia guardadas en la DB.
        $rEliminar = UsuarioPreguntasSeguridad::EliminarPorUsuario($request->session()->get('idUsuario'));


        #3. Si no se presentan errores al borrar procedemos a guardar las preguntas con su respuesta
        if ($rEliminar > 0) {

            for ($i=1;$i<=4;$i++) {

                $mensaje = ["Se guardó correctamente pregunta No. {$i} con su respuesta","Se presentaron problemas al guardar la pregunta No. {$i} con su respuesta"];

                $respuesta = RespuestasSeguridad::consultarPorPreguntaActivo($request->get("pregunta_{$i}"));

                if ($respuesta->count()) {

                    $clase = new UsuarioPreguntasSeguridad();

                    $clase->id_usuario              = $request->session()->get('idUsuario');
                    $clase->id_preguntas_seguridad  = $request->get("pregunta_{$i}");
                    $clase->id_respuesta_seguridad  = $request->get("respuesta_{$i}");

                    self::$resultado[] = self::$hs->ejecutarSave($clase,$mensaje)->original;
                }
                else {

                    $clase = new UsuarioPreguntasSeguridad();

                    $clase->id_usuario              = $request->session()->get('idUsuario');
                    $clase->id_preguntas_seguridad  = $request->get("pregunta_{$i}");
                    $clase->respuesta               = $request->get("respuesta_{$i}");

                    self::$resultado[] = self::$hs->ejecutarSave($clase,$mensaje)->original;
                }
            }
        }


        return response()->json([
            'resultado'         => 1,
            'mensaje'           => 'Se guardó las preguntas de seguridad con sus respuestas correctamente',
            'lista_resultados'  => self::$resultado
        ]);
    }
}