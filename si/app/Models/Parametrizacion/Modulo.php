<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Modulo extends Model
{
    public $timestamps = false;
    protected $table = "s_modulo";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Modulo';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 02:55 PM
     *
     * Consultar todos con paginacion
     *
     * @param request   $request:     Peticiones realizadas.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     * @param integer   $tipo:      Tipo de modulos: 1. Administración, 2. Pagina publica.
     *
     * @return object
     */
    public static function ConsultarTodoModulo($request, $buscar = null, $pagina = 1, $tamanhio = 10, $tipo = 1) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            $modulo = Modulo::select(
                's_modulo.*',
                's_modulo.id            AS id_seleccionar',
                's_etiqueta.nombre      AS etiqueta_nombre',
                's_etiqueta.diminutivo  AS etiqueta_diminutivo',
                's_etiqueta.clase       AS etiqueta_clase'
            )
                ->join('s_etiqueta','s_modulo.id_etiqueta','s_etiqueta.id')
                ->where('s_modulo.estado','>','-1')
                ->whereRaw("s_modulo.nombre like '%{$buscar}%'")
                ->whereNull('s_modulo.id_padre')
                ->orderBy('s_modulo.estado','desc')
                ->orderBy('s_modulo.orden')
                ->orderBy('s_modulo.nombre');

            $modulo =
                $tipo == 1 ?
                    $modulo->whereNull('s_modulo.enlace_usuario')
                    :
                    $modulo->whereNull('s_modulo.enlace_administrador')
                ;

            return $modulo->paginate($tamanhio);


        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarTodoModulo', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 02:55 PM
     *
     * Consultar todos con paginacion
     *
     * @param request   $request:   Peticiones realizadas.
     * @param string    $buscar:    Texto a buscar.
     * @param integer   $pagina:    Pagina actual.
     * @param integer   $tamanhio:  Tamaño de la pagina.
     * @param integer   $tipo:      Tipo de modulos: 1. Administración, 2. Pagina publica.
     *
     * @return object
     */
    public static function ConsultarTodoSesion($request, $buscar = null, $pagina = 1, $tamanhio = 10, $idModulo, $tipo = 1) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            $modulo = Modulo::select(
                's_modulo.*',
                's_modulo.id            AS id_seleccionar',
                's_etiqueta.nombre      AS etiqueta_nombre',
                's_etiqueta.diminutivo  AS etiqueta_diminutivo',
                's_etiqueta.clase       AS etiqueta_clase'
            )
                ->join('s_etiqueta','s_modulo.id_etiqueta','s_etiqueta.id')
                ->where('s_modulo.estado','>','-1')
                ->whereRaw("s_modulo.nombre like '%{$buscar}%'")
                ->where('s_modulo.id_padre',$idModulo)
                ->orderBy('s_modulo.estado','desc')
                ->orderBy('s_modulo.orden')
                ->orderBy('s_modulo.nombre');

            $modulo =
                $tipo == 1 ?
                    $modulo->whereNull('s_modulo.enlace_usuario')
                    :
                    $modulo->whereNull('s_modulo.enlace_administrador')
            ;

            return $modulo->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarTodoSesion', $e, $request);
        }
    }


    public static function consultarAdministrador($buscar,$pagina,$tamanhioPagina) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Modulo::whereRaw(
                "( nombre like '%$buscar%'
                OR descripcion like '%$buscar%'
                OR icono like '%$buscar%')")
                ->whereNull('id_padre')
                ->whereNull('enlace_usuario')
                ->orderBy('enlace_usuario','asc')
                ->orderBy('id','desc')
                ->paginate($tamanhioPagina);

        } catch (Exception $e) {
            return array();
        }
    }


    public static function consultarPublica($buscar,$pagina,$tamanhioPagina) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Modulo::whereRaw(
                "( nombre like '%$buscar%'
                OR descripcion like '%$buscar%'
                OR icono like '%$buscar%')")
                ->whereNull('id_padre')
                ->whereNull('enlace_administrador')
                ->orderBy('enlace_usuario','asc')
                ->orderBy('id','desc')
                ->paginate($tamanhioPagina);

        } catch (Exception $e) {
            return array();
        }
    }


    public static function ConsultarPorPadre_id($idPadre) {
        
        try {
            $resultado = Modulo::select('id')
                ->where('estado','=','1')
                ->where('id_padre','=',$idPadre)
                ->orderBy('nombre')
                ->get();

            return isset($resultado) ? $resultado : array();
            
        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-28 - 01:28 PM
     *
     * Consulta el listado de modulos activos
     *
     * @param integer $idEmpresa: Id de la empresa actual.
     *
     * @return object
     */
    public static function ConsultarModulosActivos($idEmpresa) {

        try {
            $resultado = Modulo::select('s_modulo.*','s_modulo_empresa.id AS id_modulo_empresa')
                ->join('s_modulo_empresa','s_modulo.id','s_modulo_empresa.id_modulo')
                ->where('s_modulo.estado','1')
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->whereNull('s_modulo.id_padre')
                ->whereNull('s_modulo.enlace_usuario')
                ->orderBy('s_modulo.nombre')
                ->get();

            return isset($resultado[0]) ? $resultado : (object)[];
            
        } catch (\Exception $e) {
            return (object)[];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-04 - 12:28 AM
     *
     * Consulta el listado de modulos activos por Usuario
     *
     * @param integer $idUsuario: Id del usuario.
     * @param integer $idEmpresa: Id empresa.
     *
     * @return object
     */
    public static function ConsultarModulosPorUsuarioEmpresa($idUsuario,$idEmpresa) {

        try {
            $resultado = Modulo::select('s_modulo.*')
                ->join('s_modulo_empresa','s_modulo.id','s_modulo_empresa.id_modulo')
                ->join('s_modulo_rol','s_modulo_empresa.id','s_modulo_rol.id_modulo_empresa')
                ->join('s_rol','s_modulo_rol.id_rol','s_rol.id')
                ->join('s_usuario','s_rol.id','s_usuario.id_rol')
                ->where('s_modulo.estado','1')
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->where('s_usuario.id',$idUsuario)
                ->whereNull('s_modulo.id_padre')
                ->whereNull('s_modulo.enlace_usuario')
                ->orderBy('s_modulo.nombre')
                ->get();

            return isset($resultado[0]) ? $resultado : (object)[];

        } catch (Exception $e) {
            return (object)[];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-04 - 12:28 AM
     *
     * Consulta el listado de sesiones activos por Usuario, empresa y modulo
     *
     * @param integer $idUsuario:   Id del usuario.
     * @param integer $idEmpresa:   Id empresa.
     * @param integer $idPadre:     Id modulo padre.
     *
     * @return object
     */
    public static function ConsultarSessionPorUsuarioEmpresaPadre($idUsuario,$idEmpresa,$idPadre) {

        try {
            $resultado = Modulo::select('s_modulo.*')
                ->join('s_modulo_empresa','s_modulo.id','s_modulo_empresa.id_modulo')
                ->join('s_modulo_rol','s_modulo_empresa.id','s_modulo_rol.id_modulo_empresa')
                ->join('s_rol','s_modulo_rol.id_rol','s_rol.id')
                ->join('s_usuario','s_rol.id','s_usuario.id_rol')
                ->where('s_modulo.estado','1')
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->where('s_usuario.id',$idUsuario)
                ->where('s_modulo.id_padre',$idPadre)
                ->whereNull('s_modulo.enlace_usuario')
                ->orderBy('s_modulo.nombre')
                ->get();

            return isset($resultado[0]) ? $resultado : (object)[];

        } catch (Exception $e) {
            return (object)[];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-05 - 06:11 PM
     *
     * Consulta las sesiones de un modulo que tenga habilitado la empresa
     *
     * @param integer $idModulo:    Id del modulo.
     * @param integer $idEmpresa:   Id de la empresa actual.
     *
     * @return object
     */
    public static function ConsultarSesionesHabilitadas($idModulo,$idEmpresa) {

        try {
            $resultado = Modulo::select('s_modulo.*', 's_modulo_empresa.id AS id_modulo_empresa')
                ->join('s_modulo_empresa','s_modulo.id','s_modulo_empresa.id_modulo')
                ->where('s_modulo.estado',1)
                ->where('s_modulo.id_padre',$idModulo)
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->orderBy('s_modulo.nombre')
                ->get();

            return isset($resultado[0]) ? $resultado : [];

        } catch (\Exception $e) {
            return (object)[
                'error' => $e
            ];
        }
    }


    public static function consultarId($id) {
        try {
            return Modulo::select(
                's_empresa.*',
                's_tema.id AS id_tema'
                )
                ->join('s_tema','s_empresa.id_tema','=','s_tema.id')
                ->where('s_empresa.id','=',$id)->get()->toArray();   
        } catch (Exception $e) {
            return array();
        } 
    }


    public static function eliminar($request)
    {
        try {
            if (Modulo::destroy($request->get('id'))) {
                return response()->json(array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                ));
            }
            else {
                return response()->json(array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar',
                ));
            }
        }
        catch (Exception $e) {
            return response()->json(array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            ));
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-28 - 01:33 PM
     *
     * Consulta paginada del listado de modulos activos por Empresa
     *
     * @param string  $buscar:          Texto que se buscará.
     * @param integer $pagina:          Posición de la pagina.
     * @param integer $tamanhioPagina:  Tamaño de la pagina.
     * @param integer $idEmpresa:       Id de la empresa actual.
     *
     * @return object
     */
    public static function consultarPaginadoPorEmpresa($buscar,$pagina,$tamanhioPagina,$idEmpresa) {
        try {
            $currentPage = $pagina;

            # Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Modulo::select('s_modulo.*')
                ->join('s_modulo_empresa','s_modulo.id','s_modulo_empresa.id_modulo')
                ->whereRaw("(s_modulo.nombre like '%$buscar%' OR s_modulo.descripcion like '%$buscar%')")
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->where('s_modulo.estado','1')
                ->whereNull('s_modulo.id_padre')
                ->whereNull('s_modulo.enlace_usuario')
                ->orderBy('s_modulo.enlace_usuario','asc')
                ->orderBy('s_modulo.id','desc')
                ->paginate($tamanhioPagina);

        } catch (\Exception $e) {
            return (object)[];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 2.0
     * @date: 2017-11-29 - 02:57 PM
     * @modify: 2017-12-06 - 05:50 PM - Jeremy Reyes B.
     *
     * Obtenemos el id del modulo
     *
     * @param integer $empresa:  Id de la empresa.
     * @param integer $idPadre:  Id de padre.
     *
     * @return array
     */
    public static function ObtenerIdPorEmpresaPadre($idEmpresa, $idPadre) {

        try {

            return ModuloEmpresa::select('s_modulo.id')
                ->join('s_modulo','s_modulo_empresa.id_modulo','s_modulo.id')
                ->where('s_modulo.id_padre',$idPadre)
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->get();
        }
        catch (\Exception $e) {

            return 0;
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-26 - 03:27 PM
     *
     * Consultar todos por empresa con paginacion
     *
     * @param request   $request:     Peticiones realizadas.
     * @param interger  $idEmpresa:   ID de la empresa.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     *
     * @return object
     */
    public static function ConsultarCheckearPorEmpresa($request, $idEmpresa, $buscar = null, $pagina = 1, $tamanhio = 10) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Modulo::select(
                DB::raw(
                    " *,
                      (
                          SELECT IF(
                              (
                                  SELECT COUNT(me.id)
                                  FROM s_modulo_empresa me
                                  WHERE me.id_empresa = {$idEmpresa}
                                  AND me.id_modulo = s_modulo.id
                              ) > 0,
                              'success',
                              ''
                          )
                      ) AS color_estado,
                      id AS id_seleccionar"
                )
            )   ->whereRaw("(nombre like '%{$buscar}%')")
                ->where('estado',1)
                ->whereNull('id_padre')
                ->whereNull('enlace_usuario')
                ->orderBy('nombre','ASC')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarCheckearPorEmpresa', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-26 - 03:27 PM
     *
     * Consultar todos por empresa con paginacion
     *
     * @param request   $request:     Peticiones realizadas.
     * @param interger  $idEmpresa:   ID de la empresa.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     *
     * @return object
     */
    public static function ConsultarPorEmpresa($request, $idEmpresa, $buscar = null, $pagina = 1, $tamanhio = 10) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Modulo::select(DB::raw("s_modulo.*, s_modulo.id AS id_seleccionar"))
                ->join('s_modulo_empresa','s_modulo.id','s_modulo_empresa.id_modulo')
                ->whereRaw("(s_modulo.nombre like '%{$buscar}%')")
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->where('s_modulo.estado',1)
                ->whereNull('s_modulo.id_padre')
                ->whereNull('s_modulo.enlace_usuario')
                ->orderBy('s_modulo.nombre','ASC')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarCheckearPorEmpresa', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-26 - 03:27 PM
     *
     * Consultar todos por empresa con paginacion
     *
     * @param request   $request:     Peticiones realizadas.
     * @param interger  $idEmpresa:   ID de la empresa.
     * @param interger  $idModulo:    ID modulo.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     *
     * @return object
     */
    public static function ConsultarSesionCheckearPorEmpresaModulo($request, $idEmpresa, $idModulo, $buscar = null, $pagina = 1, $tamanhio = 10) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Modulo::select(
                DB::raw(
                    " *,
                      (
                          SELECT IF(
                              (
                                  SELECT COUNT(me.id)
                                  FROM s_modulo_empresa me
                                  WHERE me.id_empresa = {$idEmpresa}
                                  AND me.id_modulo = s_modulo.id
                              ) > 0,
                              'success',
                              ''
                          )
                      ) AS color_estado,
                      id AS id_seleccionar"
                )
            )   ->whereRaw("(nombre like '%{$buscar}%')")
                ->where('estado',1)
                ->where('id_padre',$idModulo)
                ->whereNull('enlace_usuario')
                ->orderBy('nombre','ASC')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarSesionCheckearPorEmpresaModulo', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-26 - 03:56 PM
     *
     * Consultar todos por empresa y modulo con paginacion
     *
     * @param request   $request:     Peticiones realizadas.
     * @param interger  $idEmpresa:   ID de la empresa.
     * @param interger  $idModulo:    ID modulo.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     *
     * @return object
     */
    public static function ConsultarSesionPorEmpresaModulo($request, $idEmpresa, $idModulo, $buscar = null, $pagina = 1, $tamanhio = 10) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Modulo::select(DB::raw("s_modulo.*, s_modulo.id AS id_seleccionar"))
                ->join('s_modulo_empresa','s_modulo.id','s_modulo_empresa.id_modulo')
                ->whereRaw("(nombre like '%{$buscar}%')")
                ->where('s_modulo_empresa.id_empresa',$idEmpresa)
                ->where('estado',1)
                ->where('id_padre',$idModulo)
                ->whereNull('enlace_usuario')
                ->orderBy('nombre','ASC')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarSesionCheckearPorEmpresaModulo', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-03 - 10:32 AM
     *
     * Consultar id modulo por id modulo empresa
     *
     * @param array     $request:        Peticiones realizadas.
     * @param integer   $idModuloEmresa: ID modulo empresa.
     *
     * @return null or int
     */
    public static function ConsultarIdPorModuloEmpresa($request, $idModuloEmresa) {

        try {
            $resultado = Modulo::select('s_modulo.id')
                ->join('s_modulo_empresa','s_modulo.id','s_modulo_empresa.id_modulo')
                ->where('s_modulo_empresa.id',$idModuloEmresa)
                ->where('s_modulo.estado',1)
                ->get();

            return $resultado->count() > 0 ? (int)$resultado[0]->id : null;

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarIdPorModuloEmpresa', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 11:13 AM
     *
     * Consultar padre de la administracion por nombre
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     *
     * @return object
     */
    public static function ConsultarPadreAdministracionPorNombre($request, $nombre) {
        try {
            return Modulo::where('nombre',(string)$nombre)
                ->whereNull('id_padre')
                ->whereNull('enlace_usuario')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPadreAdministracionPorNombre', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 11:13 AM
     *
     * Consultar hijo de la administracion por nombre y padre
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     * @param string  $nombre:      Nombre.
     *
     * @return object
     */
    public static function ConsultarHijoAdministracionPorNombrePadre($request, $nombre, $idPadre) {
        try {
            return Modulo::where('nombre',(string)$nombre)
                ->where('id_padre',$idPadre)
                ->whereNull('enlace_usuario')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarHijoAdministracionPorNombrePadre', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 11:13 AM
     *
     * Consultar padre de la pagina publica por nombre
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     *
     * @return object
     */
    public static function ConsultarPadrePaginaPorNombre($request, $nombre) {
        try {
            return Modulo::where('nombre',(string)$nombre)
                ->whereNull('id_padre')
                ->whereNull('enlace_administrador')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPadrePaginaPorNombre', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 11:13 AM
     *
     * Consultar hijo de la pagina publica por nombre y padre
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     * @param string  $nombre:      Nombre.
     *
     * @return object
     */
    public static function ConsultarHijoPaginaPorNombrePadre($request, $nombre, $idPadre) {
        try {
            return Modulo::where('nombre',(string)$nombre)
                ->where('id_padre',$idPadre)
                ->whereNull('enlace_administrador')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarHijoPaginaPorNombrePadre', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 12:39 PM
     *
     * Consultar todos los modulos de la administración que esten activos
     *
     * @param request $request:     Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarModulosAdministracionActivos($request) {
        try {
            return Modulo::whereNull('id_padre')
                ->whereNull('enlace_usuario')
                ->where('estado',1)
                ->orderBy('orden')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarModulosAdministracionActivos', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 12:39 PM
     *
     * Consultar todos los modulos de la administración que esten activos
     *
     * @param request $request:     Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarModulosPaginaActivos($request) {
        try {
            return Modulo::whereNull('id_padre')
                ->whereNull('enlace_administrador')
                ->where('estado',1)
                ->orderBy('orden')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarModulosPaginaActivos', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 12:39 PM
     *
     * Consultar todos los sesion de la administración que esten activos
     *
     * @param request $request:  Peticiones realizadas.
     * @param request $idPadre:  $idPadre.
     *
     * @return object
     */
    public static function ConsultarSesionAdministracionActivos($request, $idPadre) {
        try {
            return Modulo::where('id_padre',$idPadre)
                ->whereNull('enlace_usuario')
                ->where('estado',1)
                ->orderBy('orden')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarSesionAdministracionActivos', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-09 - 12:39 PM
     *
     * Consultar todos los sesion de la pagina publica que esten activos
     *
     * @param request $request:  Peticiones realizadas.
     * @param request $idPadre:  $idPadre.
     *
     * @return object
     */
    public static function ConsultarSesionPaginaActivos($request, $idPadre) {
        try {
            return Modulo::where('id_padre',$idPadre)
                ->whereNull('enlace_administrador')
                ->where('estado',1)
                ->orderBy('orden')
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarSesionPaginaActivos', $e, $request);
        }
    }
}
