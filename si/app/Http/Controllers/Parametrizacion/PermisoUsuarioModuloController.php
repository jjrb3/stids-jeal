<?php
/**
 * Created by PhpStorm.
 * User: Jose Barrios
 * Date: 2017/12/07
 * Time: 10:56 AM
 */

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use App\Models\Parametrizacion\ModuloEmpresa;
use App\Models\Parametrizacion\PermisoUsuarioModulo;
use App\Models\Parametrizacion\Usuario;
use Illuminate\Http\Request;


class PermisoUsuarioModuloController extends Controller
{
    public static $hs;
    public static $permisos = [
        1 => 'crear',
        2 => 'actualizar',
        3 => 'Cambiar estado',
        4 => 'Eliminar',
        5 => 'Exportar',
        6 => 'Importar'
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs       = new HerramientaStidsController();
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-11 - 03:10 PM
     *
     * Consulta los parametros para el formulario
     *
     * @param request $request:   Peticiones realizadas.
     *
     * @return object
     */
    public static function ParametrosFormulario(Request $request) {

        $idUsuario = $request->session()->get('idUsuario');
        $idEmpresa = $request->session()->get('idEmpresa');

        $usuario = Usuario::ConsultarPorEmpresa($request, $idUsuario);
        $modulos = ModuloEmpresa::SelectModulosPorUsuario($request, $idUsuario);
        $usuarioPermiso = PermisoUsuarioModulo::SelectUsuarioPorEmpresa($request, $idEmpresa);

        return response()->json([
            'usuarios'          => $usuario,
            'usuarios_permisos' => $usuarioPermiso,
            'modulos'           => $modulos
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-11 - 03:10 PM
     *
     * Guarda un permiso
     *
     * @param request $request:   Peticiones realizadas.
     *
     * @return object
     */
    public static function GuardarPermisoPersonal(Request $request) {

        $permisos           = $request->get('permisos');
        $idUsuario          = $request->get('id_usuario');
        $idModuloEmpresa    = $request->get('id_modulo_empresa');

        foreach ($permisos as $permiso) {

            $PUM = PermisoUsuarioModulo::ConsultarSiExiste($request, $idUsuario, $permiso, $idModuloEmpresa);

            if ($PUM->count() === 0) {

                $clase = new PermisoUsuarioModulo();

                $clase->id_usuario          = $idUsuario;
                $clase->id_permiso          = $permiso;
                $clase->id_modulo_empresa   = $idModuloEmpresa;


                $mensaje        = ['Se guardó correctamente el permiso ' . self::$permisos[$permiso], 'Se presentaron problemas al guardar el permiso ' . self::$permisos[$permiso]];
                $transaccion    = [$request,3,'crear','p_permiso_usuario_modulo'];

                self::$hs->ejecutarSave($clase,$mensaje,$transaccion);
            }
            else {

                return response()->json([
                    'resultado' => 2,
                    'mensaje'   => 'Este usuario ya posee permisos para esta sessión, le recomendamos buscarlo para poder actualizar sus permisos'
                ]);
            }
        }

        return response()->json([
            'resultado' => 1,
            'mensaje'   => 'Se agregaron los permisos al usuario seleccionado'
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-11 - 05:56 PM
     *
     * Consulta los permisos personales
     *
     * @param request $request:   Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarPermisoPersonal(Request $request) {

        $PUM = PermisoUsuarioModulo::ConsultarPorUsuario($request, $request->get('id_usuario'));

        if ($PUM) {
            return response()->json([
                'resultado' => 1,
                'permisos'  => $PUM
            ]);
        }
        else {
            return response()->json([
                'resultado' => 2,
                'mensaje'   => 'No se encontraron permisos para el usuario seleccionado'
            ]);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-12 - 11:45 AM
     *
     * Crea o elimina permisos
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ActualizarPermisoPersonal(Request $request) {


        $idPermisos         = $request->get('id_permiso');
        $idUsuario          = $request->get('id_usuario');
        $idModuloEmpresa    = $request->get('id_modulo_empresa');

        $PUM = PermisoUsuarioModulo::ConsultarSiExiste($request, $idUsuario, $idPermisos, $idModuloEmpresa);

        if ($PUM->count() === 0) {

            $clase = new PermisoUsuarioModulo();

            $clase->id_usuario          = $idUsuario;
            $clase->id_permiso          = $idPermisos;
            $clase->id_modulo_empresa   = $idModuloEmpresa;


            $mensaje        = ['Se guardaron los cambios correctamente', 'Se presentaron problemas al guardar los cambios'];
            $transaccion    = [$request,3,'crear','p_permiso_usuario_modulo'];

            return self::$hs->ejecutarSave($clase,$mensaje,$transaccion);
        }
        else {

            return response()->json(PermisoUsuarioModulo::EliminarPorId($request,(int)$PUM[0]->id));
        }
    }
}