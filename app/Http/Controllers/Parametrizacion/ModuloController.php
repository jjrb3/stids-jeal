<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\Rol;
use Illuminate\Http\Request;

use App\Models\Parametrizacion\Modulo;
use App\Models\Parametrizacion\ModuloRol;
use App\Models\Parametrizacion\PermisoModuloRol;


class ModuloController extends Controller
{
    public static $hs;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
    }

	public static function ConsultarModulosActivos(Request $request) {

        return Modulo::ConsultarModulosActivos($request->session()->get('idEmpresa'));
    }
    

    public static function ConsultarAdministrador(Request $request) {

        return Modulo::consultarAdministrador(
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhioPagina')
        );
    }


    public static function ConsultarUsuario(Request $request) {

        return Modulo::consultarPublica(
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhioPagina')
        );
    }


    public static function ConsultarId(Request $request) {

        return response()->json(Modulo::consultarId($request->get('id')));
    }


    public static function ConsultarModulosPermisosRol(Request $request) {

        
        $idRol      = $request->get('id_rol');
        $modulos    = [];


        $aModulos   = Modulo::ConsultarModulosActivos($request->session()->get('idEmpresa'))->toArray();

        if ($aModulos) {

            $cnt = 0;

            foreach ($aModulos as $modulo) {
               
                $modulos[$cnt]['id'] = $modulo['id'];
                $modulos[$cnt]['padre'] = 'si';
                $modulos[$cnt]['nombre'] = $modulo['nombre'];
                $modulos[$cnt]['icono'] = $modulo['icono'];

                $aModuloRol = ModuloRol::ConsultarPermisoModuloRol($modulo['id'],$idRol)->toArray();

                if ($aModuloRol) {

                    $modulos[$cnt]['ver'] = 'si';

                    $arreglo = [];

                    for ($i=1; $i <=6 ; $i++) { 
                        
                        $arreglo[$i] = PermisoModuloRol::consultarPermisosModuloRol($i,$aModuloRol[0]['id'],$idRol)->count() > 0 ? 'si' : 'no';
                    }

                    $modulos[$cnt]['permisos'] = $arreglo;
                }
                else {

                    $modulos[$cnt]['ver'] = 'no';

                    for ($i=1; $i <=6 ; $i++) { 
                        
                        $arreglo[$i] = 'no';    
                    }

                    $modulos[$cnt]['permisos'] = $arreglo;
                }
                
                $cnt++;

                // Aqui miramos las sesiones que tiene ese modulo
                $aSesiones   = Modulo::ConsultarSesionesHabilitadas($modulo['id'], $request->session()->get('idEmpresa'));

                if ($aSesiones) {

                    foreach ($aSesiones as $moduloSesion) {
               
                        $modulos[$cnt]['id'] = $moduloSesion['id'];
                        $modulos[$cnt]['padre'] = 'no';
                        $modulos[$cnt]['nombre'] = $moduloSesion['nombre'];
                        $modulos[$cnt]['icono'] = $moduloSesion['icono'];

                        $aModuloRol = ModuloRol::ConsultarPermisoModuloRol($moduloSesion['id'],$idRol)->toArray();

                        if ($aModuloRol) {

                            $modulos[$cnt]['ver'] = 'si';

                            $arreglo = array();

                            for ($i=1; $i <=6 ; $i++) {

                                $arreglo[$i] = PermisoModuloRol::consultarPermisosModuloRol($i,$aModuloRol[0]['id'],$idRol)->count() > 0 ? 'si' : 'no';
                            }

                            $modulos[$cnt]['permisos'] = $arreglo;
                        }
                        else {

                            $modulos[$cnt]['ver'] = 'no';

                            for ($i=1; $i <=6 ; $i++) { 
                                
                                $arreglo[$i] = 'no';    
                            }

                            $modulos[$cnt]['permisos'] = $arreglo;
                        }
                        
                        $cnt++;
                    }
                }

                
            }
        }

        $rol = Rol::find($idRol);

        return response()->json([
            'resultado'  => 2,
            'titulo'     => 'Información importante',
            'mensaje'    => 'Habilite o deshabilite los permisos que desee para el rol ' . $rol->nombre,
            'nombre_rol' => $rol->nombre,
            'modulos'    => $modulos
        ]);
    }


    public function ActualizarImagen(Request $request) {

        $directorio = __DIR__.'/../../../../recursos/imagenes/Modulo_logo';
        $archivo = $request->file('imagen_logo');
        
        $nombre = explode('.',$archivo->getClientOriginalName());
        $ext = $nombre[1];
        $nombreArchivo = $request->get('id'). "_" . date("Ymd_his") . ".$ext";

        $imagen = Modulo::consultarId($request->get('id'));

        if ($imagen) {

            $imagen = $imagen[0]['imagen_logo'];
        }

        if($archivo->move($directorio, $nombreArchivo)) {
            
            $clase = Modulo::Find((int)$request->get('id'));
            $clase->imagen_logo = $nombreArchivo;

            try {
                if ($clase->save()) {

                    if ($imagen != 'predeterminado.png') {
                        unlink("$directorio/$imagen"); // Eliminamos la imagen
                    }
                    return 1;
                } else {
                    return 0;
                }
            } catch (Exception $e) {
                return -1;
            }
        }
        else{

            return 0;
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-04 - 12:01 PM
     * @see: 1. Usuario::consultarPerfil.
     *
     * Consulta los modulos y sesiones a los que tiene permiso un usuario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarPermisoModulosSesiones($idUsuario, $idEmpresa) {

        $modulos = Modulo::ConsultarModulosPorUsuarioEmpresa($idUsuario, $idEmpresa);

        foreach ($modulos as $k => $modulo) {

            $modulos[$k]->sesiones = Modulo::ConsultarSessionPorUsuarioEmpresaPadre($idUsuario, $idEmpresa, $modulo->id);
        }

        return $modulos;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 11:01 AM
     * @see: 1. Modulo::ConsultarModulosActivos.
     *       2. EtiquetaController::ConsultarActivos.
     *
     * Inicializa los parametros del formulario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function InicializarParametros(Request $request) {

        $idEmpresa = $request->session()->get('idEmpresa');

        $modulos  = Modulo::ConsultarModulosAdministracionActivos($request);
        $etiqueta = EtiquetaController::ConsultarActivos($request);

        return response()->json([
            'modulos'   => $modulos,
            'etiquetas' => $etiqueta
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 12:33 PM
     * @see: 1. Modulo::ConsultarModulosActivos.
     *       2. EtiquetaController::ConsultarActivos.
     *
     * Inicializa los parametros del formulario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarPadrePorTipo(Request $request) {

        $idEmpresa  = $request->session()->get('idEmpresa');
        $tipo       = $request->get('tipo');

        $modulos =
            $tipo == 1 ?
                Modulo::ConsultarModulosAdministracionActivos($request)
                :
                Modulo::ConsultarModulosPaginaActivos($request)
        ;

        return response()->json($modulos);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 11:06 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Modulo::ConsultarPorNombreEmpresa.
     *       3. Modulo::find.
     *       4. self::$hs->ejecutarSave.
     *
     * Crea o actualiza los datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CrearActualizar(Request $request)
    {
        #1. Verificamos los datos enviados
        $id             = $request->get('id');
        $tipo           = $request->get('tipo');
        $idPadre        = $request->get('id_padre');
        $transaccion    = [$request, 13, '', 's_modulo'];

        #1.1. Datos obligatorios
        $datos = [
            'tipo'      => 'Seleccione el tipo para continuar',
            'nombre'    => 'Digite el nombre para poder guardar los cambios',
            'enlace'    => 'Digite el enlace para poder guardar los cambios',
            'icono'     => 'Digite el codigo del icono para poder guardar los cambios'
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Si no es actualización consultamos si existe
        if (!$id) {

            #2.1. Si es tipo 1 es administración
            if ($tipo == 1) {

                #2.1.1. Si no tiene padre es porque es un modulo de lo contrario es una sesion
                $existeRegistro =
                    !$idPadre ?
                        Modulo::ConsultarPadreAdministracionPorNombre($request,$request->get('nombre'))
                        :
                        Modulo::ConsultarHijoAdministracionPorNombrePadre($request,$request->get('nombre'), $idPadre)
                ;
            }
            #2.2. Si es tipo 2 es pagina publica
            else {

                #2.2.1. Si no tiene padre es porque es un modulo de lo contrario es una sesion
                $existeRegistro =
                    !$idPadre ?
                        Modulo::ConsultarPadrePaginaPorNombre($request,$request->get('nombre'))
                        :
                        Modulo::ConsultarHijoPaginaPorNombrePadre($request,$request->get('nombre'), $idPadre)
                ;
            }
        }
        else {
            $existeRegistro[] = Modulo::find($id);
        }

        #3. Que no se encuentre ningun error
        if (!is_null($existeRegistro)) {

            #3.1. Si existe, no esta eliminado y no es una actualización
            if (!$id && $existeRegistro->count() && $existeRegistro[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado o es una actualizacion lo vuelve a activar y actualiza todos sus datos
            elseif ($id || $existeRegistro->count() && $existeRegistro[0]->estado < 0) {

                $clase = Modulo::find($existeRegistro[0]->id);

                $clase->id_padre    = $idPadre;
                $clase->id_etiqueta = (int)$request->get('id_etiqueta');
                $clase->nombre      = $request->get('nombre');
                $clase->descripcion = $request->get('descripcion');
                $clase->icono       = $request->get('icono');
                $clase->estado      = 1;

                $tipo == 1 ?
                    $clase->enlace_administrador = $request->get('enlace')
                    :
                    $clase->enlace_usuario = $request->get('enlace')
                ;

                $transaccion[2] = 'actualizar';

                return self::$hs->ejecutarSave(
                    $clase,
                    $id ? self::$hs->mensajeActualizar : self::$hs->mensajeGuardar,
                    $transaccion
                );
            }
            #3.3. Si no existe entonces se crea
            else {

                $clase = new Modulo();

                $clase->id_padre    = $idPadre;
                $clase->id_etiqueta = (int)$request->get('id_etiqueta');
                $clase->nombre      = $request->get('nombre');
                $clase->descripcion = $request->get('descripcion');
                $clase->icono       = $request->get('icono');
                $clase->estado      = 1;

                $tipo == 1 ?
                    $clase->enlace_administrador = $request->get('enlace')
                    :
                    $clase->enlace_usuario = $request->get('enlace')
                ;

                $transaccion[2] = 'crear';

                return self::$hs->ejecutarSave($clase, self::$hs->mensajeGuardar, $transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 02:55 PM
     * @see: 1. Modulo::ConsultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarModulos(Request $request) {

        $objeto = Modulo::ConsultarTodoModulo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->get('tipo')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 02:55 PM
     * @see: 1. Modulo::ConsultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarSesion(Request $request) {

        $objeto = Modulo::ConsultarTodoSesion(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->get('id_modulo'),
            $request->get('tipo')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-10 - 11:00 AM
     * @see: 1. ModulosDashboard::obtenerOrdenPorUsuarioModulo.
     *       2. ModulosDashboard::ConsultarPorUsuario.
     *       3. $hs->ejecutarSave.
     *
     * Sube de posición
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function Subir(Request $request) {

        $id         = $request->get('id');
        $tipo       = $request->get('tipo');
        $idPadre    = $request->get('id_padre');

        $item = Modulo::find($id);

        if ($item->orden <= 1) {

            return response()->json([
                'resultado' => 2,
                'titulo'    => 'Información',
                'mensaje'   => 'No se puede subir más'
            ]);
        }
        else {

            if ($tipo == 1) {

                $objeto =
                    !$idPadre ?
                        Modulo::ConsultarModulosAdministracionActivos($request)
                        :
                        Modulo::ConsultarSesionAdministracionActivos($request, $idPadre)
                ;
            }
            else {

                $objeto =
                    !$idPadre ?
                        Modulo::ConsultarModulosPaginaActivos($request)
                        :
                        Modulo::ConsultarSesionPaginaActivos($request, $idPadre)
                ;
            }


            $ids = self::$hs->OrdenarIds($objeto,'subir',$item->orden);

            $cnt = 1;

            foreach ($ids as $k => $i) {

                $clase = Modulo::find($i['id']);

                $clase->orden = $cnt++;

                $mensaje     = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
                $transaccion = [$request,13,'actualizar','s_modulo'];

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
     * @date: 2018-01-10 - 11:00 AM
     * @see: 1. ModulosDashboard::obtenerOrdenPorUsuarioModulo.
     *       2. ModulosDashboard::ConsultarPorUsuario.
     *       3. $hs->ejecutarSave.
     *
     * baja de posición
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return array
     */
    public static function Bajar(Request $request) {

        $id         = $request->get('id');
        $tipo       = $request->get('tipo');
        $idPadre    = $request->get('id_padre');

        $item = Modulo::find($id);

        if ($tipo == 1) {

            $objeto =
                !$idPadre ?
                    Modulo::ConsultarModulosAdministracionActivos($request)
                    :
                    Modulo::ConsultarSesionAdministracionActivos($request, $idPadre)
            ;
        }
        else {

            $objeto =
                !$idPadre ?
                    Modulo::ConsultarModulosPaginaActivos($request)
                    :
                    Modulo::ConsultarSesionPaginaActivos($request, $idPadre)
            ;
        }

        if ($item->orden >= $objeto->count()) {

            return response()->json([
                'resultado' => 2,
                'titulo'    => 'Información',
                'mensaje'   => 'No se puede bajar más'
            ]);
        }
        else {

            $ids = self::$hs->OrdenarIds($objeto,'bajar',$item->orden);

            $cnt = 1;

            foreach ($ids as $k => $i) {

                $clase = Modulo::find($i['id']);

                $clase->orden = $cnt++;

                $mensaje     = ['Se actualizó correctamente','Se encontraron problemas al actualizar'];
                $transaccion = [$request,13,'actualizar','s_modulo'];

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
     * @date: 2018-01-10 - 01:55 PM
     * @see: 1. Modulo::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Cambia de estado.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CambiarEstado(Request $request) {

        $clase  = Modulo::Find((int)$request->get('id'));

        if ($clase->estado === 1) {
            $clase->estado = 0;
        }
        elseif ($clase->estado === 0) {
            $clase->estado = 1;
        }

        $transaccion = [$request,13,self::$hs->estados[$clase->estado],'s_modulo'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEstado,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-10 - 01:55 PM
     * @see: 1. Modulo::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Elimina un dato por id.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Eliminar($request)
    {
        $clase = Modulo::Find((int)$request->get('id'));

        $clase->estado = -1;

        $transaccion = [$request,13,'eliminar','s_modulo'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,$transaccion);
    }
}