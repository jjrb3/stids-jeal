<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Modulo extends Model
{
    public $timestamps = false;
    protected $table = "s_modulo";


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
}
