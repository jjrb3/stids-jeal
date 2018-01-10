<?php
namespace App\Http\Controllers;

use App\Models\Parametrizacion\Transacciones;

class HerramientaStidsController extends Controller
{
    public static $accion = array(
        'consultar' => 0,
        'crear' => 1,
        'actualizar' => 2,
        'activo' => 3,
        'inactivo' => 4,
        'eliminar' => 5,
        'exportar' => 6,
        'imprortar' => 7,
    );
    public static $nombreMeses = array(
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    );
    public $estados = ['0' => 'inactivo', '1' => 'activo'];
    public $mensajeGuardar = ['Se guardó correctamente','Se encontraron problemas al guardar'];
    public $mensajeActualizar = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
    public $mensajeEstado = ['Se cambió el estado correctamente','Se encontraron problemas al cambiar el estado'];
    public $mensajeEliminar = ['Se eliminó correctamente','Se encontraron problemas al eliminar'];
    public $jsonExiste = [
        'resultado' => 2,
        'titulo'    => 'Existe',
        'mensaje'   => 'Esta información ya se encuentra registrada en el sistema'
    ];
    public $jsonError = [
        'resultado' => -1,
        'titulo'    => 'Grave Error!',
        'mensaje'   => 'Se encontraron errores al momento de realizar la petición, comuniquese con el administrador del sistema o intentelo mas tarde'
    ];


    public static function cerosIzquierda($numero) {

        $ceros = '';

        for($i = strlen((string)$numero);$i < 5; $i++) {

            $ceros .= '0';
        }

        return "$ceros$numero";
    }


    public static function verificationDatas($request,$arrayDatas) {

        foreach ($arrayDatas as $data => $message) {

            $result = HerramientaStidsController::verificacionCampos($request,$data,$message);

            if ($result) {
                return $result;
            }
        }

        return '';
    }


    public static function ejecutarSaveArreglo($clase,$mensaje) {
        try {
            if ($clase->save()) {
                return array(
                    'resultado' => 1,
                    'mensaje' => $mensaje[0],
                    'id' => $clase->id,
                );
            } else {
                return array(
                    'resultado' => 0,
                    'mensaje' => $mensaje[1],
                );
            }
        } catch (Exception $e) {
            return array(
                'resultado' => -1,
                'mensaje' => 'Grave error: ' . $e,
            );
        }
    }

    public static function ejecutarSave($clase,$mensaje,$transaccion = '') {
        try {
            if ($clase->save()) {

                # Guardamos la transaccion
                if ($transaccion) {
                    HerramientaStidsController::guardarTransaccion(
                        $transaccion[0],
                        $transaccion[1],
                        self::$accion[$transaccion[2]],
                        $clase->id,
                        $transaccion[3]);
                }

                return response()->json(array(
                    'titulo' => 'Realizado',
                    'resultado' => 1,
                    'mensaje' => $mensaje[0],
                    'id' => $clase->id,
                ));
            } else {
                return response()->json(array(
                    'resultado' => 0,
                    'mensaje' => $mensaje[1],
                ));
            }
        } catch (\Exception $e) {
            return response()->json([
                'resultado' => -1,
                'mensaje' => 'Grave error, contacte con del administrador del sistema.',
                'error' => $e
            ]);
        }
    }

    public static function verificacionCampos($request,$nombre,$mensaje){
        if (!$request->get($nombre) && !$request->file($nombre)) {
            return response()->json(array(
                'resultado' => 0,
                'mensaje' => $mensaje,
            ));
        }
    }

    public static function guardarTransaccion($request,$idModulo,$accion,$id,$nombreTabla) {

        date_default_timezone_set('America/bogota');

        $transaccion = new Transacciones();

        $transaccion->id_empresa        = $request->session()->get('idEmpresa');
        $transaccion->id_usuario        = $request->session()->get('idUsuario');
        $transaccion->id_permiso        = $accion;
        $transaccion->id_modulo         = $idModulo;
        $transaccion->id_alterado       = $id;
        $transaccion->nombre_tabla      = $nombreTabla;
        $transaccion->fecha_alteracion  =  date('Y-m-d H:i:s');

        $transaccion->save();
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-11 - 12:17 PM
     *
     * Sumamos a una fecha dias
     *
     * @param string    $fecha: Fecha.
     * @param integer   $dias:  Dias que se sumaran a la fecha.
     *
     * @return string: Fecha sumada
     */
    public static function sumarDias($fecha,$dias) {

        if (trim((string)$fecha) && is_int($dias)) {

            $nuevaFecha = strtotime( "+{$dias} day", strtotime($fecha));

            return date('Y-m-j', $nuevaFecha);
        }

        return null;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-11 - 12:55 PM
     *
     * Sumamos a una fecha meses
     *
     * @param string    $fecha: Fecha.
     * @param integer   $meses: Meses que se sumaran a la fecha.
     *
     * @return string: Fecha sumada
     */
    public static function sumarMeses($fecha,$meses) {

        if (trim((string)$fecha) && is_int($meses)) {

            $nuevaFecha = strtotime( "+{$meses} month", strtotime($fecha));

            return date('Y-m-j', $nuevaFecha);
        }

        return null;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-13 - 02:20 PM
     *
     * Genera una cadena alfanumerica con caracteres
     *
     * @param integer $tamanhio: Tamañio de la cadena.
     *
     * @return string: Cadena alfanumerica
     */
    public static function generarCadenaAlfanumerica($tamanhio) {

        $caracteres = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-)(.:,;*/+-$}{abcdefghijklmnopqrstuvwxyz";
        $cantidad   = strlen($caracteres) - 1;
        $cadena     = '';

        for ($i=0;$i<=$tamanhio;$i++) {

            $cadena .= substr($caracteres, rand(0, $cantidad), 1);
        }

        return $cadena;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-14 - 06:56 PM
     *
     * Obtenemos la URL del servidor
     *
     * @return string: URL
     */
    public static function Dominio() {

        $s = '';

        if (isset($_SERVER['HTTPS'])) {
            $s = 's';
        }

        return "http{$s}://{$_SERVER['SERVER_NAME']}";
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-23 - 09:33 AM
     *
     * Genera los permisos en el servidor
     *
     * @return array: Permisos
     */
    public function GenerarPermisos($permisos) {

        $listaPermiso   = '';
        $aPermisos      = [
            'guardar' => false,
            'actualizar' => false,
            'estado' => false,
            'eliminar' => false,
            'exportar' => false,
            'importar' => false,
        ];

        foreach($permisos as $permiso) {

            if ($permiso['id_permiso'] == 1) {
                $aPermisos['guardar'] = true;
                $listaPermiso        .= '1,';
            }
            elseif ($permiso['id_permiso'] == 2) {
                $aPermisos['actualizar'] = true;
                $listaPermiso        .= '2,';
            }
            elseif ($permiso['id_permiso'] == 3) {
                $aPermisos['estado'] = true;
                $listaPermiso        .= '3,';
            }
            elseif ($permiso['id_permiso'] == 4) {
                $aPermisos['eliminar'] = true;
                $listaPermiso        .= '4,';
            }
            elseif ($permiso['id_permiso'] == 5) {
                $aPermisos['exportar'] = true;
                $listaPermiso        .= '5,';
            }
            elseif ($permiso['id_permiso'] == 6) {
                $aPermisos['importar'] = true;
                $listaPermiso        .= '6,';
            }
        }

        return [
            'op'        => $aPermisos,
            'permisos'  => substr($listaPermiso,0,-1)
        ];
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 09:50 AM
     *
     * Ordena las ids de un objecto
     *
     * @param object    $objeto         Objecto donde se encuentra las tablas.
     * @param string    $tipo           Tipo de orden que se dará, ejemplo 'subir' o 'bajar'.
     * @param integer   $posicionActual Posicion actual del id.
     *
     * @return array
     */
    public function OrdenarIds($objeto, $tipo, $posicionActual) {

        $arregloOrdenado = [];

        if (strtolower($tipo) === 'subir') {

            foreach ($objeto as $columna) {

                if ($columna->orden == $posicionActual && isset($arregloOrdenado[count($arregloOrdenado) - 1])) {

                    $arregloOrdenado[] = $arregloOrdenado[count($arregloOrdenado) - 1];

                    $arregloOrdenado[count($arregloOrdenado) - 2] = ['id' => $columna->id];
                }
                else {
                    $arregloOrdenado[] = ['id' => $columna->id];
                }
            }
        }
        else {

            foreach ($objeto as $columna) {

                $arregloOrdenado[] = ['id' => $columna->id];

                if ($columna->orden > $posicionActual && $columna->orden < $posicionActual + 2) {

                    $aux = $arregloOrdenado[count($arregloOrdenado) - 2];

                    $arregloOrdenado[count($arregloOrdenado) - 2] = $arregloOrdenado[count($arregloOrdenado) - 1];
                    $arregloOrdenado[count($arregloOrdenado) - 1] = $aux;
                }
            }
        }

        return $arregloOrdenado;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-07 - 11:23 AM
     *
     * Creacion de log
     *
     * @param string    $modulo:         Nombre del modulo.
     * @param string    $clase:          Nombre de la clase donde se obtuvo.
     * @param string    $metodo:         Nombre del metodo que se ejecutó.
     * @param object    $error Posicion: Error generado.
     * @param request   $request:        Peticiones realizadas.
     *
     * @return object
     */
    public function Log($modulo, $clase, $metodo, $error, $request) {

        date_default_timezone_set('America/Bogota');

        $fechaHora          = date('Y-m-d H:i:s');
        $mensajeException   = $error->getMessage();
        $idUsuario          = $request->session()->get('idUsuario');
        $idEmpresa          = $request->session()->get('idEmpresa');

        $mensaje = "Fecha y Hora: $fechaHora\nModulo: $modulo \nClase: $clase\nMetodo: $metodo\nID Empresa: $idEmpresa\nID Usuario: $idUsuario\nError: $mensajeException\n\n";

        error_log($mensaje,3,storage_path('logs') . '/' . strtolower($modulo) .'.log');

        return null;
    }
}
