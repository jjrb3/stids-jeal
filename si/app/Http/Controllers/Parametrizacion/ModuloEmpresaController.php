<?php
/**
 * Created by PhpStorm.
 * User: Jose Barrios
 * Date: 2017/12/28
 * Time: 3:03 PM
 */

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Modulo;
use App\Models\Parametrizacion\ModuloRol;
use App\Models\Parametrizacion\ModuloEmpresa;
use App\Models\Parametrizacion\PermisoModuloRol;
use App\Models\Parametrizacion\ModulosDashboard;

class ModuloEmpresaController
{
    public static $hs;

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
     * @date: 2017-12-24 - 03:20 PM
     * @see: 1. Modulo::ConsultarCheckearPorEmpresa.
     *
     * Consultar y obtener si esta checkeado por empresa
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarCheckearPorEmpresa(Request $request) {

        $objeto = Modulo::ConsultarCheckearPorEmpresa(
            $request,
            $request->get('id_empresa'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-01-03 - 10:27 AM
     * @see: 1. ModuloEmpresa::ObtenerSesionPorEmpresaModulo.
     *
     * Consultar sesion por modulo y empresa
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarSesion(Request $request) {

        $objeto = ModuloEmpresa::ObtenerSesionPorEmpresaModulo(
            $request,
            $request->get('id_empresa'),
            Modulo::ConsultarIdPorModuloEmpresa($request,$request->get('id_modulo'))
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 03:20 PM
     * @see: 1. Modulo::ConsultarPorEmpresa.
     *
     * Consultar por empresa
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarPorEmpresa(Request $request) {

        $objeto = Modulo::ConsultarPorEmpresa(
            $request,
            $request->get('id_empresa'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 04:34 PM
     * @see: 1. Modulo::ConsultarSesionCheckearPorEmpresaModulo.
     *
     * Consultar y obtener si esta checkeado por empresa
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarSesionCheckearPorEmpresaModulo(Request $request) {

        $objeto = Modulo::ConsultarSesionCheckearPorEmpresaModulo(
            $request,
            $request->get('id_empresa'),
            $request->get('id_modulo'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-28 - 03:55 PM
     * @see: 1. Modulo::ConsultarSesionPorEmpresaModulo.
     *
     * Consultar por empresa y modulo
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarSesionPorEmpresaModulo(Request $request) {

        $objeto = Modulo::ConsultarSesionPorEmpresaModulo(
            $request,
            $request->get('id_empresa'),
            $request->get('id_modulo'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-27 - 08:49 AM
     * @see: 1. self::$hs->ejecutarSave.
     *
     * Guarda un modulo por ids y empresa
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function GuardarIdsModulosPorEmpresa(Request $request) {

        $resultado  = [];
        $idEmpresa  = $request->get('id_empresa');
        $ids        = explode(',', $request->get('ids'));

        foreach ($ids as $id) {

            $clase = new ModuloEmpresa();

            $clase->id_modulo  = $id;
            $clase->id_empresa = $idEmpresa;

            $transaccion = [$request,6,'actualizar','s_empresa'];

            $resultado[] = self::$hs->ejecutarSave($clase,self::$hs->mensajeGuardar,$transaccion)->original;
        }

        return response()->json([
            'resultado' => 1,
            'titulo'    => 'Realizado',
            'mensaje'   => 'Se agregaron los módulos y sesiones que seleccionó',
            'datos'     => $resultado
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-27 - 10:00 AM
     * @see: 1. self::$hs->ejecutarSave.
     *
     * Elimina en cascada el modulo de una empresa
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function EliminarIdsModulosPorEmpresa(Request $request) {

        $resultado  = [];
        $idEmpresa  = $request->get('id_empresa');
        $ids        = explode(',', $request->get('ids'));

        #1. Recorremos los modulos y sesiones que se eliminaran
        foreach ($ids as $id) {

            #1.1. Obtenemos el ID del modulo y con este obtenemos el id de modulo y rol
            $idME  = ModuloEmpresa::ObtenerIdPorModuloEmpresa($id, $idEmpresa);
            $idsMR = ModuloRol::ObtenerIdsPorModulo($request, $idME);

            #1.2. Si encuentra datos procedemos a eliminar los permisos por rol por empresa
            if ($idsMR->count() > 0) {

                foreach ($idsMR as $idMR) {

                    PermisoModuloRol::eliminarPorModulo($idMR->id);
                    ModuloRol::eliminar($idMR->id);
                }
            }

            #1.3. Eliminamos los modulos del dasbboard
            ModulosDashboard::EliminarPorModulo($idME);

            #1.4. Eliminamos el modulo de la empresa
            $e = ModuloEmpresa::EliminarPorModulo($idME);
        }


        return response()->json([
            'resultado' => 1,
            'titulo'    => 'Realizado',
            'mensaje'   => 'Se eliminó los módulos y sesiones que seleccionó',
            'datos'     => $resultado
        ]);
    }
}