<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\ModuloEmpresa;
use Dompdf\Exception;
use Illuminate\Http\Request;

use App\Models\Parametrizacion\Modulo;
use App\Models\Parametrizacion\ModuloRol;
use App\Models\Parametrizacion\PermisoModuloRol;
use App\Models\Parametrizacion\Permiso;


class ModuloRolController extends Controller
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

	public function GuardarPermisos(Request $request)
    {    
        switch ($request->get('tipo_permiso')) {
            case 'ver':
                return $this->actualizarTodosLosPermisos($request);
                break;

            case 'padre':
                return $this->actualizarPermisoDesdePadre($request);
                break;

            case 'unico':
                return $this->actualizarPermiso($request);
                break;
            
            default:
                array();
                break;
        };
    }


    private function actualizarTodosLosPermisos($request) {

        $this->borradoCascadaTodos($request->get('id_rol'),$request->get('id_modulo'));

        if ($request->get('accion') == 'guardar') {

            // Padre
            $id = $this->guardarRolesDeModulos($request, $request->get('id_rol'), array(array('id' => $request->get('id_modulo'))));
            $this->guardarPermisosDeRolesDeModulos($id);

            // Hijos
            $aHijos = Modulo::ObtenerIdPorEmpresaPadre($request->session()->get('idEmpresa'),$request->get('id_modulo'));

            if ($aHijos->count() > 0) {

                $ids = $this->guardarRolesDeModulos(
                    $request,
                    $request->get('id_rol'),
                    $aHijos->toArray()
                );

                $this->guardarPermisosDeRolesDeModulos($ids);
            }
        }

        return response()->json(array(
            'resultado' => 1,
            'titulo' => '',
            'mensaje' => 'Se guardaron los cambios correctamente',
        ));        
    }


    private function actualizarPermisoDesdePadre($request) {

        $this->borradoCascadaPadre($request->get('id_rol'),$request->get('id_modulo'),$request->get('permiso'), $request);

        if ($request->get('accion') == 'guardar') {

            // Padre
            foreach (ModuloRol::ConsultarPermisoModuloRol($request->get('id_modulo'),$request->get('id_rol'))->toArray() as $lista) {

                $permisoModuloRol = new PermisoModuloRol();

                $permisoModuloRol->id_modulo_rol = $lista['id_modulo_rol'];
                $permisoModuloRol->id_permiso = $request->get('permiso');

                $permisoModuloRol->save();
            }


            // Hijos
            foreach (Modulo::ConsultarPorPadre_id($request->get('id_modulo'))->toArray() as $sesiones) {
                
                foreach (ModuloRol::ConsultarPermisoModuloRol($sesiones['id'],$request->get('id_rol'))->toArray() as $lista) {

                    $permisoModuloRol = new PermisoModuloRol();

                    $permisoModuloRol->id_modulo_rol = $lista['id_modulo_rol'];
                    $permisoModuloRol->id_permiso = $request->get('permiso');

                    $permisoModuloRol->save();
                }
            } 
        }


        return response()->json(array(
            'resultado' => 1,
            'titulo' => '',
            'mensaje' => 'Se guardaron los cambios correctamente',
        ));
    }


    private function actualizarPermiso($request) {


        foreach (ModuloRol::ConsultarPermisoModuloRol($request->get('id_modulo'),$request->get('id_rol'))->toArray() as $lista) {

            PermisoModuloRol::eliminarPorModuloPermiso($lista['id_modulo_rol'],$request->get('permiso'));
        }

        if ($request->get('accion') == 'guardar') {

            // Padre
            foreach (ModuloRol::ConsultarPermisoModuloRol($request->get('id_modulo'),$request->get('id_rol'))->toArray() as $lista) {

                $permisoModuloRol = new PermisoModuloRol();

                $permisoModuloRol->id_modulo_rol = $lista['id_modulo_rol'];
                $permisoModuloRol->id_permiso = $request->get('permiso');

                $permisoModuloRol->save();
            }
        }

        
        return response()->json(array(
            'resultado' => 1,
            'mensaje' => 'Se realizaron los cambios correctamente',
        ));        
    }


    private function guardarRolesDeModulos($request, $idRol,$idModulos) {

        $ids = array();

        foreach ($idModulos as $idModulo) {
            
            $moduloRol = new ModuloRol();

            $moduloRol->id_rol              = $idRol;
            $moduloRol->id_modulo_empresa   = ModuloEmpresa::ObtenerIdPorModuloEmpresa($idModulo['id'],$request->session()->get('idEmpresa'));

            try {
                $moduloRol->save();

                $ids[] = $moduloRol->id;
            } catch (\Exception $e) {

            }
        }

        return $ids;
    }


    private function guardarPermisosDeRolesDeModulos($idsModulosRoles) {

        foreach ($idsModulosRoles as $id) {

            foreach (Permiso::consultarTodosLosPermisos()->toArray() as $permiso) {

                $permisoModuloRol = new PermisoModuloRol();

                $permisoModuloRol->id_modulo_rol = $id;
                $permisoModuloRol->id_permiso = $permiso['id'];

                try {
                    $permisoModuloRol->save();
                } catch (\Exception $e) {

                }
            }
        }
    }


    private function borradoCascadaPadre($idRol,$idModulo,$permiso, $request) {
        
        // Padre
        foreach (ModuloRol::ConsultarPermisoModuloRol($idModulo,$idRol)->toArray() as $lista) {

            PermisoModuloRol::eliminarPorModuloPermiso($lista['id_modulo_rol'],$permiso);
        }


        // Hijos
        $aHijos = Modulo::ObtenerIdPorEmpresaPadre($request->session()->get('idEmpresa'),$idModulo)->toArray();

        foreach ($aHijos as $sesiones) {

            foreach (ModuloRol::ConsultarPermisoModuloRol($sesiones['id'],$idRol)->toArray() as $lista) {

                PermisoModuloRol::eliminarPorModuloPermiso($lista['id_modulo_rol'],$permiso);
            }
        }      
    }


    private function borradoCascadaTodos($idRol,$idModulo) {

        // Padre
        foreach (ModuloRol::ConsultarPermisoModuloRol($idModulo,$idRol)->toArray() as $lista) {

            PermisoModuloRol::eliminarPorModulo($lista['id_modulo_rol']);
            ModuloRol::eliminar($lista['id_modulo_rol']);
        }

        // Hijos
        foreach (Modulo::ConsultarPorPadre_id($idModulo)->toArray() as $sesiones) {
            
            foreach (ModuloRol::ConsultarPermisoModuloRol($sesiones['id'],$idRol)->toArray() as $lista) {

                PermisoModuloRol::eliminarPorModulo($lista['id_modulo_rol']);
                ModuloRol::eliminar($lista['id_modulo_rol']);
            }
        }        
    }


    public static function verificarPermisoModulo(Request $request,$modulo,$sesion) {

        $noVerificar = array('abort','si');

        if (!ModuloRol::ConsultarPermisoModuloRol("$modulo/$sesion",$request->session()->get('idRol')) && !in_array($modulo, $noVerificar)) {

            return false;
        }

        return true;
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
    public static function GuardarPermisosRapido(Request $request) {

        $idRol              = $request->get('id_rol');
        $idModuloEmpresa    = $request->get('id_modulo');
        $idSesion           = $request->get('id_sesion');
        $idPermisos         = $request->get('permisos');

        $idModuloEmpresa .= $idSesion ? ',' . implode(',',$idSesion) : '';

        foreach (explode(',',$idModuloEmpresa) as $idME) {

            $id = ModuloRol::ObtenerIdPorModuloRol($request, $idRol, $idME);

            if ($id) {

                PermisoModuloRol::eliminarPorModulo($id);
                ModuloRol::eliminar($id);
            }

            if($idPermisos) {

                $ModuloRol = new ModuloRol();

                $ModuloRol->id_rol            = $idRol;
                $ModuloRol->id_modulo_empresa = $idME;

                $mensaje        = ['Se guardaron los cambios correctamente', 'Se presentaron problemas al guardar los cambios'];
                $transaccion    = [$request,6,'crear','s_modulo_rol'];

                $idModuloRol = self::$hs->ejecutarSave($ModuloRol,$mensaje,$transaccion)->original['id'];

                foreach ($idPermisos as $idP) {

                    $PermisoModuloRol = new PermisoModuloRol();

                    $PermisoModuloRol->id_modulo_rol = $idModuloRol;
                    $PermisoModuloRol->id_permiso    = $idP;

                    $mensaje        = ['Se guardaron los cambios correctamente', 'Se presentaron problemas al guardar los cambios'];
                    $transaccion    = [$request,6,'crear','s_permiso_modulo_rol'];

                    self::$hs->ejecutarSave($PermisoModuloRol,$mensaje,$transaccion);
                }
            }
        }

        return response()->json([
            'resultado' => 1,
            'mensaje'   => 'Se guardaron los cambios correctamente'
        ]);
    }
}