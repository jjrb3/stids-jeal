<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\GraficasDashboard;
use App\Models\Parametrizacion\GraficasEmpresa;
use App\Models\Parametrizacion\Modulo;
use App\Models\Parametrizacion\ModulosDashboard;
use App\Models\Parametrizacion\Usuario;
use Illuminate\Http\Request;
use App\Models\Parametrizacion\ModuloEmpresa;


class DashboardController extends Controller
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
     * @see: 1. Modulo::consultarPaginadoPorEmpresa.
     *
     * Consulta el listado de Modulos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarModulos(Request $request) {

        return Modulo::consultarPaginadoPorEmpresa(
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->session()->get('idEmpresa')
        );
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-29 - 08:13 AM
     * @see: 1. ModulosDashboard::ConsultarPorUsuario.
     *
     * Consulta los modulos que han sido agregados.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarModulosAgregados(Request $request) {

        $resultado = ModulosDashboard::ConsultarPorUsuario(
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->session()->get('idUsuario')
        );

        return $resultado;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-28 - 12:38 PM
     * @see: 1. $hs->ejecutarSave.
     *
     * Guarda el tipo de Dashboard que verá el usuario
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function GuardarTipo(Request $request) {

        $usuario = Usuario::find($request->session()->get('idUsuario'));

        $usuario->id_tipo_dashboard_usuario = $request->get('tipo');


        $mensaje     = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
        $transaccion = [$request,1,'actualizar','p_usuario'];

        return self::$hs->ejecutarSave($usuario,$mensaje,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-28 - 12:38 PM
     * @see: 1. ModuloEmpresa::ObtenerIdPorModuloEmpresa.
     *       2. ModulosDashboard::ObtenerUltimoOrden.
     *       3. $hs->ejecutarSave.
     *
     * Agrega un modulo al listado
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function GuardarModulos(Request $request) {

        $resultado = [];
        $idUsuario = $request->session()->get('idUsuario');
        $idEmpresa = $request->session()->get('idEmpresa');

        foreach (array_filter(explode(',',$request->get('ids'))) as $id) {

            $clase = new ModulosDashboard();

            $clase->id_usuario          = $idUsuario;
            $clase->id_modulo_empresa   = ModuloEmpresa::ObtenerIdPorModuloEmpresa($id,$idEmpresa);
            $clase->orden               = ModulosDashboard::ObtenerUltimoOrden($idUsuario);

            $mensaje     = ['Se agregó correctamente','Se encontraron problemas al agregar'];
            $transaccion = [$request,1,'crear','p_modulos_dashboard'];

            $resultado[$id] = self::$hs->ejecutarSave($clase,$mensaje,$transaccion)->original;
        }

        return response()->json([
            'resultado' => 1,
            'mensaje' => 'Se agregó correctamente',
            'resultados' => $resultado
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-29 - 3:38 PM
     * @see: 1. ModulosDashboard::EliminarPorUsuarioModulo.
     *       2. ModuloEmpresa::ObtenerIdPorModuloEmpresa.
     *
     * Elimina un modulo del listado
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function EliminarModulos(Request $request) {

        $resultado = [];
        $idUsuario = $request->session()->get('idUsuario');
        $idEmpresa = $request->session()->get('idEmpresa');

        foreach (array_filter(explode(',',$request->get('ids'))) as $id) {

            $resultado[$id] = ModulosDashboard::EliminarPorUsuarioModulo(
                $idUsuario,
                ModuloEmpresa::ObtenerIdPorModuloEmpresa($id,$idEmpresa)
            );
        }

        return response()->json([
            'resultado' => 1,
            'mensaje' => 'Se quitó correctamente',
            'resultados' => $resultado
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 10:02 AM
     * @see: 1. ModulosDashboard::obtenerOrdenPorUsuarioModulo.
     *       2. ModulosDashboard::ConsultarPorUsuario.
     *       3. $hs->ejecutarSave.
     *
     * Sube de posicion un modulo del dashboard
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function SubirModulo(Request $request) {

        $idModulo        = $request->get('id');
        $idUsuario       = $request->session()->get('idUsuario');

        $moduloDashboard = ModulosDashboard::ObtenerPorUsuarioModulo($idUsuario,$idModulo);

        if ($moduloDashboard->orden <= 1) {

            return response()->json([
                'resultado' => 2,
                'mensaje' => 'No se puede subir más'
            ]);
        }
        else {

            $modulos = ModulosDashboard::ObtenerPorUsuario($idUsuario);

            $ids = self::$hs->OrdenarIds($modulos,'subir',$moduloDashboard->orden);

            foreach ($ids as $k => $i) {

                $clase = ModulosDashboard::find($i['id']);

                $clase->orden = $k + 1;

                $mensaje     = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
                $transaccion = [$request,1,'actualizar','p_modulos_dashboard'];

                self::$hs->ejecutarSave($clase,$mensaje,$transaccion)->original;
            }

            return response()->json([
                'resultado' => 1,
                'mensaje' => 'Se cambió de posicion correctamente'
            ]);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 10:50 AM
     * @see: 1. ModulosDashboard::obtenerOrdenPorUsuarioModulo.
     *       2. ModulosDashboard::ConsultarPorUsuario.
     *       3. $hs->ejecutarSave.
     *
     * baja de posicion un modulo del dashboard
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function BajarModulo(Request $request) {

        $idModulo        = $request->get('id');
        $idUsuario       = $request->session()->get('idUsuario');

        $moduloDashboard = ModulosDashboard::ObtenerPorUsuarioModulo($idUsuario,$idModulo);
        $modulos         = ModulosDashboard::ObtenerPorUsuario($idUsuario);

        if ($moduloDashboard->orden >= $modulos->count()) {

            return response()->json([
                'resultado' => 2,
                'mensaje' => 'No se puede bajar más'
            ]);
        }
        else {

            $ids = self::$hs->OrdenarIds($modulos,'bajar',$moduloDashboard->orden);

            foreach ($ids as $k => $i) {

                $clase = ModulosDashboard::find($i['id']);

                $clase->orden = $k + 1;

                $mensaje     = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
                $transaccion = [$request,1,'actualizar','p_modulos_dashboard'];

                self::$hs->ejecutarSave($clase,$mensaje,$transaccion)->original;
            }

            return response()->json([
                'resultado' => 1,
                'mensaje' => 'Se cambió de posicion correctamente'
            ]);
        }
    }


    /*********** Graficas **********/


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-23 - 10:15 AM
     * @see: 1. Modulo::consultarPaginadoPorEmpresa.
     *
     * Consulta el listado de Modulos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarGraficas(Request $request) {

        return GraficasEmpresa::ConsultarPorEmpresa(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->session()->get('idEmpresa')
        );
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 1:06 PM
     * @see: 1. GraficasEmpresa::ConsultarPorEmpresa.
     *
     * Consulta el listado de graficas agregadas.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarGraficasAgregadas(Request $request) {

        return GraficasDashboard::ConsultarPorEmpresaUsuario(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->session()->get('idEmpresa'),
            $request->session()->get('idUsuario')
        );
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-28 - 12:38 PM
     * @see: 1. ModuloEmpresa::ObtenerIdPorModuloEmpresa.
     *       2. ModulosDashboard::ObtenerUltimoOrden.
     *       3. $hs->ejecutarSave.
     *
     * Agrega un modulo al listado
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function GuardarGraficas(Request $request) {

        $resultado = [];
        $idUsuario = $request->session()->get('idUsuario');
        $idEmpresa = $request->session()->get('idEmpresa');

        foreach (array_filter(explode(',',$request->get('ids'))) as $id) {

            $clase = new GraficasDashboard();

            $clase->id_usuario          = $idUsuario;
            $clase->id_graficas_empresa = GraficasEmpresa::ObtenerIdPorGraficaEmpresa($id,$idEmpresa);
            $clase->orden               = GraficasDashboard::ObtenerUltimoOrden($idUsuario);

            $mensaje     = ['Se agregó correctamente','Se encontraron problemas al agregar'];
            $transaccion = [$request,1,'crear','p_graficas_dashboard'];

            $resultado[$id] = self::$hs->ejecutarSave($clase,$mensaje,$transaccion)->original;
        }

        return response()->json([
            'resultado' => 1,
            'mensaje' => 'Se agregó correctamente',
            'resultados' => $resultado
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 2:02 PM
     * @see: 1. GraficasDashboard::EliminarPorUsuarioGrafica.
     *       2. GraficasEmpresa::ObtenerIdPorGraficaEmpresa.
     *
     * Elimina una grafica del listado
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function EliminarGraficas(Request $request) {

        $resultado = [];
        $idUsuario = $request->session()->get('idUsuario');
        $idEmpresa = $request->session()->get('idEmpresa');

        foreach (array_filter(explode(',',$request->get('ids'))) as $id) {

            $resultado[$id] = GraficasDashboard::EliminarPorUsuarioGrafica(
                $idUsuario,
                GraficasEmpresa::ObtenerIdPorGraficaEmpresa($id,$idEmpresa)
            );
        }

        return response()->json([
            'resultado' => 1,
            'mensaje' => 'Se quitó correctamente',
            'resultados' => $resultado
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 02:03 PM
     * @see: 1. GraficasDashboard::ObtenerPorUsuarioGrafica.
     *       2. GraficasDashboard::ObtenerPorUsuario.
     *       3. $hs->ejecutarSave.
     *
     * Sube de posicion una grafica del dashboard
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function SubirGrafica(Request $request) {

        $idGrafica       = $request->get('id');
        $idUsuario       = $request->session()->get('idUsuario');

        $graficasDashboard = GraficasDashboard::ObtenerPorUsuarioGrafica($idUsuario,$idGrafica);

        if ($graficasDashboard->orden <= 1) {

            return response()->json([
                'resultado' => 2,
                'mensaje' => 'No se puede subir más'
            ]);
        }
        else {

            $graficas = GraficasDashboard::ObtenerPorUsuario($idUsuario);

            $ids = self::$hs->OrdenarIds($graficas,'subir',$graficasDashboard->orden);

            foreach ($ids as $k => $i) {

                $clase = GraficasDashboard::find($i['id']);

                $clase->orden = $k + 1;

                $mensaje     = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
                $transaccion = [$request,1,'actualizar','p_graficas_dashboard'];

                self::$hs->ejecutarSave($clase,$mensaje,$transaccion)->original;
            }

            return response()->json([
                'resultado' => 1,
                'mensaje' => 'Se cambió de posicion correctamente'
            ]);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-30 - 02:15 PM
     * @see: 1. ModulosDashboard::obtenerOrdenPorUsuarioModulo.
     *       2. ModulosDashboard::ConsultarPorUsuario.
     *       3. $hs->ejecutarSave.
     *
     * baja de posicion una grafica del dashboard
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function BajarGrafica(Request $request) {

        $idGrafica = $request->get('id');
        $idUsuario = $request->session()->get('idUsuario');

        $graficasDashboard  = GraficasDashboard::ObtenerPorUsuarioGrafica($idUsuario,$idGrafica);
        $graficas           = GraficasDashboard::ObtenerPorUsuario($idUsuario);

        if ($graficasDashboard->orden >= $graficas->count()) {

            return response()->json([
                'resultado' => 2,
                'mensaje' => 'No se puede bajar más'
            ]);
        }
        else {

            $ids = self::$hs->OrdenarIds($graficas,'bajar',$graficasDashboard->orden);

            foreach ($ids as $k => $i) {

                $clase = GraficasDashboard::find($i['id']);

                $clase->orden = $k + 1;

                $mensaje     = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
                $transaccion = [$request,1,'actualizar','p_graficas_dashboard'];

                self::$hs->ejecutarSave($clase,$mensaje,$transaccion)->original;
            }

            return response()->json([
                'resultado' => 1,
                'mensaje' => 'Se cambió de posicion correctamente'
            ]);
        }
    }
}