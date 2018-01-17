<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\ModuloRol;
use App\Models\Parametrizacion\Usuario;

class MenuController extends Controller
{
    public static function menuAdministrador(Request $request)
    {
        $reduccion  = -1;  // -1: Local, 2: Servidor
        $aMenu      = array();
        $aUrl       = array_filter(explode('/', $_SERVER['REQUEST_URI']));
        $idUsuario  = $request->session()->get('idUsuario');

        unset($aUrl[1-$reduccion],$aUrl[2-$reduccion]);

        if ($request->session()->get('cambioEmpresa')) {

            $usuarioOriginal = Usuario::Find($request->session()->get('idUsuario'));

            if ($usuarioOriginal->id_empresa == $request->session()->get('idEmpresa') &&
                $usuarioOriginal->id_rol == $request->session()->get('idRol')) {

                $idUsuario = $usuarioOriginal->id;
            }
            else {

                if ($usuario = Usuario::ConsultarPorEmpresaRol($request,$request->session()->get('idEmpresa'), $request->session()->get('idRol'))) {

                    $idUsuario = $usuario->id;
                }
            }
        }

        if ($menu = Usuario::menu($idUsuario,$request->session()->get('idEmpresa'))) {

            foreach ($menu as $listaMenu) {

                $nombreMenu = array_filter(explode('/', $listaMenu['enlace_administrador']))[0];
                
                $aUrl[3-$reduccion] == $nombreMenu ? $listaMenu['activo'] = true : $listaMenu['activo'] = false;

                if ($subMenu = ModuloRol::submenuRolPadre($listaMenu['id_rol'],$listaMenu['id'])) {

                    foreach ($subMenu as $listaSubmenu) {
                        
                        $aSubmenu = array();

                        $aSubmenu = $listaSubmenu;

                        if (isset($aUrl[4-$reduccion])) {

                            $subPagina = explode('?', $aUrl[4-$reduccion]);

                            $listaSubmenu['enlace_administrador'] == "{$aUrl[3-$reduccion]}/{$subPagina[0]}" ? $aSubmenu['activo'] = true : $aSubmenu['activo'] = false;
                        }
                        else {

                            $aSubmenu['activo'] = false;
                        }

                        $listaMenu['submenu'][$aSubmenu['id']] = $aSubmenu;
                    }
                }
                
                $aMenu[$listaMenu['id']] = $listaMenu;
            }
        }

        return array(
            'menu' => $aMenu,
            'ruta' => isset($aUrl[4-$reduccion]) ? '../' : '',
            );  
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 2.0
     * @date 2017-11-17 - 12:24 PM
     * @see 1. PrestamoDetallePago::eliminarPorDetallePrestamo.
     *
     * Guarda en la sesión
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json
     */
    public static function GuardarTamanhioMenu(Request $request) {

        $iconoCuadros   = 'fa-th-large';
        $iconoListado   = 'fa-bars';
        $minimizar      = $request->get('minimizar') == 'true' ? true : false;

        $request->session()->put('menuMinimizado',$request->get('minimizar'));

        return response()->json([
            'resultado' => 1,
            'estado' => !$minimizar,
            'agregar_icono' => $minimizar ? $iconoListado : $iconoCuadros,
            'quitar_icono' => $minimizar ? $iconoCuadros : $iconoListado
        ]);
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 2.0
     * @date 2017-11-17 - 09:42 PM
     * @see 1. PrestamoDetallePago::eliminarPorDetallePrestamo.
     *
     * Verifica si la clave maestra es correcta para poder realizar el cambio de empresa
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json
     */
    public static function CambiarDeEmpresa(Request $request) {

        $idUsuario      = !$request->session()->get('idUsuarioAnterior') ? $request->session()->get('idUsuario') : $request->session()->get('idUsuarioAnterior');
        $idEmpresa      = $request->get('id_empresa');
        $idRol          = $request->get('id_rol');
        $claveMaestra   = $request->get('clave_maestra');
        $usuario        = Usuario::Find($idUsuario);

        if ($usuario->clave_maestra) {

            if (password_verify($claveMaestra, $usuario->clave_maestra)) {

                $nuevoUsuario = Usuario::ConsultarPorEmpresaRol($request, $idEmpresa, $idRol);

                if ($nuevoUsuario->count() > 0) {

                    if (!($request->session()->get('idUsuarioAnterior') > 0)) {
                        $request->session()->put('idUsuarioAnterior', $request->session()->get('idUsuario'));
                    }

                    $request->session()->put('idUsuario', $nuevoUsuario[0]->id);
                    $request->session()->put('idEmpresa', $idEmpresa);
                    $request->session()->put('idRol', $idRol);
                    $request->session()->put('cambioEmpresa', true);

                    return response()->json([
                        'resultado' => 1,
                        'mensaje' => 'Espere mientras es redirigido.',
                    ]);
                }
                else {
                    return response()->json([
                        'resultado' => 2,
                        'mensaje' => 'No se encontraron usuarios para este rol, escoja otro tipo de rol para navegar.',
                    ]);
                }
            }
            else {

                return response()->json([
                    'resultado' => 0,
                    'mensaje' => 'La clave maestra no es correcta.',
                ]);
            }
        }
        else {
            return response()->json([
                'resultado' => 0,
                'mensaje' => 'Usted no posee una clave maestra, comuníquese con el administrador para resolver este inconveniente.',
            ]);
        }
    }
}
