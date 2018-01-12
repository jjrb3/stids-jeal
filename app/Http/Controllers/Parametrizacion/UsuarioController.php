<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\Empresa;
use App\Models\Parametrizacion\Modulo;
use App\Models\Parametrizacion\Rol;
use App\Models\Parametrizacion\Sexo;
use App\Models\Parametrizacion\TipoIdentificacion;
use Illuminate\Http\Request;
use App\Models\Parametrizacion\Usuario;


class UsuarioController extends Controller
{
    public static $hs;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
    }

    public static function Consultar(Request $request) {

        return Usuario::consultarTodo($request);
    }


    public static function ConsultarId(Request $request) {

        return response()->json(Usuario::consultarId($request));
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
    public static function ConsultarPerfil(Request $request) {

        return response()->json([
            'resultado'      => 1,
            'perfil_usuario' => Usuario::consultarPerfil($request->session()->get('idUsuario')),
            'sexo'           => Sexo::consultarActivo($request),
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
    public static function GuardarPerfil(Request $request) {

        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'nombres'   => 'Digite sus nombres para poder guardar los cambios',
            'apellidos' => 'Digite sus apellidos para poder guardar los cambios',
            'correo'    => 'El Email digitado no es correcto.',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Insertamos los nuevos datos al objecto
        $clase = Usuario::Find($request->session()->get('idUsuario'));

        $clase->clave               = $request->get('clave') ? password_hash($request->get('clave'), PASSWORD_BCRYPT, ['cost' => 13]) : $clase->clave;
        $clase->nombres             = $request->get('nombres');
        $clase->apellidos           = $request->get('apellidos');
        $clase->id_sexo             = $request->get('sexo');
        $clase->id_municipio        = $request->get('id_municipio');
        $clase->fecha_nacimiento    = $request->get('fecha_nacimiento');
        $clase->telefono            = $request->get('telefono');
        $clase->celular             = $request->get('celular');


        #3. Guardamos los datos
        $mensaje        = ['Se guardó correctamente','Se encontraron problemas al guardar'];
        $transaccion    = [$request,1,'actualizar','s_usuario'];

        return self::$hs->ejecutarSave($clase,$mensaje,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-04 - 10:30 AM
     * @see: 1. Usuario::consultarPerfil.
     *
     * Consulta el detalle de un usuario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function ConsultarDetalle(Request $request) {

        $usuario = Usuario::consultarPerfil($request->get('id'));

        $modulosSesiones = ModuloController::ConsultarPermisoModulosSesiones($usuario->id, $usuario->id_empresa);


        return response()->json([
            'resultado' => 1,
            'usuario'   => $usuario,
            'empresa'   => Empresa::find($usuario->id_empresa),
            'modulos'   => $modulosSesiones
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-04 - 01:40 PM
     * @see: 1. TipoIdentificacion::consultarActivo.
     *       2. Rol::consultarActivoPorEmpresa.
     *       3. Sexo::consultarActivo.
     *
     * Se retornan los parametros necesarios para inicializar el formulario de Usuario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function InicializarFormulario(Request $request) {

        return response()->json([
            'resultado' => 1,
            'tipo_identificacion' => TipoIdentificacion::consultarActivo($request, $request->get('id_empresa')),
            'rol' => Rol::consultarActivoPorEmpresa($request->get('id_empresa')),
            'sexo' => Sexo::consultarActivo($request)
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-04 - 03:27 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. self::$hs->ejecutarSave.
     *
     * Se actualiza los datos del usuario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public function Actualizar(Request $request)
    {
        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'id_tipo_identificacion'    => 'Seleccione un tipo de identificacion para continuar',
            'no_documento'              => 'Digite su numero de documento para continuar',
            'id_rol'                    => 'Seleccione un rol de identificacion para continuar',
            'usuario'                   => 'Digite el usuario para continuar',
            'id_sexo'                   => 'Seleccione un sexo para continuar',
            'id_municipio'              => 'Digite una ciudad validad para continuar',
            'nombres'                   => 'Digite sus nombres para poder guardar los cambios',
            'apellidos'                 => 'Digite sus apellidos para poder guardar los cambios',
            'correo'                    => 'El Email digitado no es correcto.',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Insertamos los nuevos datos al objecto
        $clase = Usuario::Find($request->get('id'));

        $clase->id_tipo_identificacion  = $request->get('id_tipo_identificacion');
        $clase->id_rol                  = $request->get('id_rol');
        $clase->usuario                 = $request->get('usuario');
        $clase->no_documento            = $request->get('no_documento');
        $clase->clave                   = $request->get('clave') ? password_hash($request->get('clave'), PASSWORD_BCRYPT, ['cost' => 13]) : $clase->clave;
        $clase->nombres                 = $request->get('nombres');
        $clase->apellidos               = $request->get('apellidos');
        $clase->id_sexo                 = $request->get('id_sexo');
        $clase->id_municipio            = $request->get('id_municipio');
        $clase->fecha_nacimiento        = $request->get('fecha_nacimiento');
        $clase->telefono                = $request->get('telefono');
        $clase->celular                 = $request->get('celular');
        $clase->correo                  = $request->get('correo');


        #3. Guardamos los datos
        $mensaje        = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
        $transaccion    = [$request,2,'actualizar','s_usuario'];

        return self::$hs->ejecutarSave($clase,$mensaje,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-04 - 03:27 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. self::$hs->ejecutarSave.
     *
     * Se crea un nuevo usuario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public function Crear(Request $request)
    {
        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'id_tipo_identificacion'    => 'Seleccione un tipo de identificacion para continuar',
            'no_documento'              => 'Digite su numero de documento para continuar',
            'id_rol'                    => 'Seleccione un rol de identificacion para continuar',
            'usuario'                   => 'Digite el usuario para continuar',
            'clave'                     => 'Digite la contraseña para continuar',
            'id_sexo'                   => 'Seleccione un sexo para continuar',
            'id_municipio'              => 'Digite una ciudad validad para continuar',
            'nombres'                   => 'Digite sus nombres para poder guardar los cambios',
            'apellidos'                 => 'Digite sus apellidos para poder guardar los cambios',
            'correo'                    => 'El Email digitado no es correcto.',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Insertamos los nuevos datos al objecto
        $clase = new Usuario();

        $clase->id_empresa              = $request->get('id_empresa');
        $clase->id_tipo_identificacion  = $request->get('id_tipo_identificacion');
        $clase->id_rol                  = $request->get('id_rol');
        $clase->usuario                 = $request->get('usuario');
        $clase->no_documento            = $request->get('no_documento');
        $clase->clave                   = password_hash($request->get('clave'), PASSWORD_BCRYPT, ['cost' => 13]);
        $clase->nombres                 = $request->get('nombres');
        $clase->apellidos               = $request->get('apellidos');
        $clase->id_sexo                 = $request->get('id_sexo');
        $clase->id_municipio            = $request->get('id_municipio');
        $clase->fecha_nacimiento        = $request->get('fecha_nacimiento');
        $clase->telefono                = $request->get('telefono');
        $clase->celular                 = $request->get('celular');
        $clase->correo                  = $request->get('correo');


        #3. Guardamos los datos
        $mensaje        = ['Se guardó correctamente','Se encontraron problemas al guardar'];
        $transaccion    = [$request,2,'crear','s_usuario'];

        return self::$hs->ejecutarSave($clase,$mensaje,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-04 - 04:41 PM
     * @see: 1. self::$hs->ejecutarSave.
     *
     * Se actualiza los datos del usuario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public function CambiarEstado(Request $request)
    {
        $clase = Usuario::Find($request->get('id'));

        if ($clase->estado === 1) {
            $clase->estado = 0;
        }
        elseif ($clase->estado === 0) {
            $clase->estado = 1;
        }

        $mensaje        = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
        $transaccion    = [$request,2,'actualizar','s_usuario'];

        return self::$hs->ejecutarSave($clase,$mensaje,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-04 - 05:10 PM
     * @see: 1. self::$hs->ejecutarSave.
     *
     * Se elimina un usuario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public function Eliminar(Request $request)
    {
        $clase = Usuario::Find($request->get('id'));

        $clase->estado = -1;

        $mensaje        = ['La información fue eliminada correctamente','Se encontraron problemas al eliminar la información'];
        $transaccion    = [$request,2,'actualizar','s_usuario'];

        return self::$hs->ejecutarSave($clase,$mensaje,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-05 - 10:03 AM
     * @see: 1. $this->TransaccionesPorRangoFecha.
     *
     * Consulta el total de usuarios que existen por estado y empresa.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public function ConsultarTotalEstado(Request $request)
    {
        $activo     = 0;
        $inactivo   = 0;
        $eliminado  = 0;

        if ($total = Usuario::totalUsuarioPorEmpresa($request->session()->get('idEmpresa'))) {

            foreach ($total as $t) {

                switch ($t->estado)
                {
                    case -1:
                        $eliminado = $t->cantidad;
                        break;

                    case 0:
                        $inactivo = $t->cantidad;
                        break;

                    case 1:
                        $activo = $t->cantidad;
                        break;
                }
            }
        }

        return response()->json([
            'resultado' => 1,
            'total'     => [
                'activo'    => $activo,
                'inactivo'  => $inactivo,
                'eliminado' => $eliminado,
            ]
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-05 - 10:03 AM
     * @see: 1. $this->TransaccionesPorRangoFecha.
     *
     * Consulta las transacciones de los usuarios por rango de fecha y devuelve el total en JSON.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public function ConsultarTransacciones(Request $request)
    {
        $transacciones = $this->TransaccionesPorRangoFecha(9,$request->session()->get('idEmpresa'));

        return response()->json([
            'resultado'     => 1,
            'transacciones' => $transacciones['por_detalle']
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-05 - 10:04 AM
     * @see: 1. self::$hs->ejecutarSave.
     *
     * Consulta las transacciones de los usuarios por rango de fecha.
     *
     * @param integer $meses:       Cantidad de meses anteriores a mostrar.
     * @param integer $idEmpresa:   Empresa que desea buscar.
     *
     * @return array
     */
    public function TransaccionesPorRangoFecha($meses,$idEmpresa)
    {
        $rango      = [];
        $detalle    = [];
        $restaAnhio = 0;
        $j          = 1;



        for ($i=0;$i<$meses;$i++) {

            $mes    = (int)date('m', strtotime("-" . ($meses - $i - 1) . " month", strtotime(date('Y-m-d'))));

            $rango[$j][-1]    = 0;
            $rango[$j][0]     = 0;
            $rango[$j][1]     = 0;
            $rango[$j]['mes'] = HerramientaStidsController::$nombreMeses[$mes];

            if ($transacciones = Usuario::TransaccionesPorRango($idEmpresa, $mes)) {

                $fechaMes = '';

                foreach ($transacciones as $transaccion) {

                    $fechaMes = $transaccion->fecha < 10 ? "0{$transaccion->fecha}" : $transaccion->fecha;

                    $rango[$j][$transaccion->estado] = $transaccion->cantidad;
                }
            }

            if ($mes == 1) {
                $restaAnhio++;
            }

            $j++;
        }


        # Version para graficas
        foreach ($rango as $r) {

            $detalle[-1][] = $r[-1];
            $detalle[0][] = $r[0];
            $detalle[1][] = $r[1];
            $detalle['mes'][] = $r['mes'];

        }

        return [
            'por_mes'       => $rango,
            'por_detalle'   => $detalle
        ];
    }


}