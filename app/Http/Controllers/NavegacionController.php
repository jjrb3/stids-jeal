<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Parametrizacion\EmpresaController;
use App\Http\Controllers\Parametrizacion\MenuController;
use App\Models\Parametrizacion\Empresa;
use App\Models\Parametrizacion\GraficasEmpresa;
use App\Models\Parametrizacion\Rol;
use App\Models\Parametrizacion\PermisoUsuarioModulo;
use App\Models\Parametrizacion\PermisoModuloRol;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\SesionController;
use App\Http\Controllers\HerramientaStidsController;

class NavegacionController extends Controller
{
    public $hs = null;

    public function __construct()
    {
        $this->hs = new HerramientaStidsController();
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-13 - 03:44 PM
     * @see: 1. $sesion->IniciarSesionPorCookie.
     *
     * Navegacion para los usuarios que esten logueados en Stids Jeal.
     *
     * @param array     $request:   Peticiones realizadas.
     * @param integer   $carpeta:   Carpeta donde esta contenida la pagina.
     * @param integer   $pagina:    Pagina que mostrará.
     *
     * @return array: Vista parametrizado
     */
    public function Privado(Request $request,$carpeta,$pagina) {

        $OP = ['op' => null, 'permisos' => null];
        $PG = ['permisos' => null, 'json' => null];

        #1. Verificamos si tiene permiso, existe vista y si no tiene la sesion activa pero si esta gurdada en cookie.
        if (!$request->session()->get('idEmpresa') && $request->cookie('codigo_ingreso')) {

            $sesion = new SesionController();

            if (!$sesion->IniciarSesionPorCookie($request)) {

                return redirect(HerramientaStidsController::Dominio());
            }
        }
        elseif (!$request->session()->get('idEmpresa') && !$request->cookie('codigo_ingreso')) {
            return redirect(HerramientaStidsController::Dominio());
        }


        #2. Verificamos si la pagina a la que quiere acceder existe.
        if (!view()->exists("$carpeta.$pagina")) {
            return redirect('si/abort/no_existe');
        }


        #3. Verificamos si tiene permiso para ver esta pagina.
        if (!Parametrizacion\ModuloRolController::verificarPermisoModulo($request,$carpeta,$pagina)) {
            return redirect('si/abort/acceso');
        }


        #4. Asignamos los permisos para enviarlos
        $permisos = array();

        if ($request->get('padre') || $request->get('hijo')) {

            if ($request->get('hijo')) {

                $permisos = PermisoUsuarioModulo::consultarPorUsuarioModulo($request,$request->session()->get('idUsuario'),$request->get('hijo'));

                if ($permisos->count() === 0) {
                    $permisos = PermisoModuloRol::consultarPermisosModulo($request, $request->session()->get('idRol'), $request->get('hijo'));
                }
            }
            elseif ($request->get('padre')) {

                $permisos = PermisoUsuarioModulo::consultarPorUsuarioModulo($request,$request->session()->get('idUsuario'),$request->get('padre'));

                if ($permisos->count() === 0) {
                    $permisos = PermisoModuloRol::consultarPermisosModulo($request, $request->session()->get('idRol'), $request->get('padre'));
                }
            }

            //print_r($permisos);
            //die;

            $OP = $this->hs->GenerarPermisos($permisos);
        }


        #5. Generamos el JSON de empresas y roles
        if ($empresa = Empresa::consultarTodo2()) {

            $aJSON = [];

            foreach ($empresa as $k => $i) {

                $rol = Rol::consultarActivoPorEmpresa($i->id);

                if ($rol) {

                    $aJSON[(int)$i->id]['id']       = (int)$i->id;
                    $aJSON[(int)$i->id]['nombre']   = (string)$i->nombre;
                    $aJSON[(int)$i->id]['roles']    = $rol->toArray();
                }
            }
        }


        #6. Obtenemos los permisos de la grafica por sesion
        if ($request->get('hijo')) {

            $cnt            = 0;
            $graficaEmpresa = GraficasEmpresa::PermisoGraficaPorEmpresa($request->get('hijo'),$request->session()->get('idEmpresa'));

            if (!isset($graficaEmpresa['resultado']) && $graficaEmpresa ) {

                foreach ($graficaEmpresa as $grafica) {

                    $PG['json'][] = $grafica->id;
                    $PG['permisos']['id'][$cnt] = $grafica->id;
                    $PG['permisos']['nombre'][$cnt] = $grafica->nombre;

                    $cnt++;
                }

                $PG['json'] = implode($PG['json'], ',');
            }
        }

        return View("$carpeta.$pagina",
            [
                'nombres'               => $request->session()->get('nombres'),
                'menuAdministrador'     => MenuController::menuAdministrador($request),
                'empresa'               => EmpresaController::ConsultarEmpresaSistema($request),
                'idUsuario'             => $request->session()->get('idUsuario'),
                'menu_minimizado'       => $request->session()->get('menuMinimizado'),
                'id_rol'                => $request->session()->get('idRol'),
                'id_empresa'            => $request->session()->get('idEmpresa'),
                'json_empresa_roles'    => json_encode($aJSON),
                'cambio_empresa'        => $request->session()->get('cambioEmpresa'),
                'op'                    => (object) $OP['op'],
                'permisos'              => $OP['permisos'],
                'pg'                    => $PG['permisos'],
                'permisosGraficas'      => $PG['json']
            ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-13 - 01:38 PM
     * @see: 1. $sesion->IniciarSesionPorCookie.
     *
     * Navegacion para los usuarios que no esten logueados en Stids Jeal.
     *
     * - Si es la ventana de login y la persona ya inició sesion entonces ingresa a la pagina automaticamente, si no
     *   muestra la ventana de login.
     * - Si existe una cookie de recordarme entonces ingresa automaticamente a la plataforma.
     *
     * @param array     $request:   Peticiones realizadas.
     * @param integer   $pagina:    Pagina que mostrará.
     *
     * @return array: Vista parametrizado
     */
    public function Publico(Request $request,$pagina) {

        if ($pagina === 'ingresar' && $request->cookie('codigo_ingreso')) {

            $sesion = new SesionController();

            if ($sesion->IniciarSesionPorCookie($request)) {
                return redirect('si/inicio');
            }
        }


        return $pagina === 'ingresar' && $request->session()->get('idEmpresa') ? redirect('si/inicio') : View($pagina,
        	[
        		'empresa' => Parametrizacion\EmpresaController::ConsultarEmpresaSistema($request),
        	]);
    }
}
