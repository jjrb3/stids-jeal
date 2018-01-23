<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Usuario extends Model
{
    public $timestamps = false;
    protected $table = "s_usuario";

    public static $hs;
    const MODULO = 'Parametrizacion';
    const MODELO = 'Usuario';

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
    }

    public static function consultarTodo($request) {
        try {
            $currentPage = $request->get('pagina');

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Usuario::select(
            		's_empresa.nombre AS empresa',
            		's_tipo_identificacion.nombre AS identificacion',
            		's_rol.nombre AS rol',
            		's_usuario.no_documento AS documento',
            		's_usuario.*'
            	)
            	->join('s_empresa','s_usuario.id_empresa','=','s_empresa.id')
            	->join('s_tipo_identificacion','s_usuario.id_tipo_identificacion','=','s_tipo_identificacion.id')
            	->join('s_rol','s_usuario.id_rol','=','s_rol.id')
                ->whereRaw("(s_usuario.nombres like '%{$request->get('buscador')}%'
                             OR s_usuario.apellidos like '%{$request->get('buscador')}%'
                             OR s_usuario.usuario like '%{$request->get('buscador')}%'
                             OR s_usuario.correo like '%{$request->get('buscador')}%'
                             OR s_tipo_identificacion.nombre like '%{$request->get('buscador')}%'
                             OR s_rol.nombre like '%{$request->get('buscador')}%')")
                ->where('s_empresa.id',$request->get('id_empresa'))
                ->whereIn('s_usuario.estado',[1,0])
            	->orderBy('estado','desc')
                ->orderBy('nombres')
            	->orderBy('apellidos')
                ->paginate($request->get('tamanhio'));
                
        } catch (Exception $e) {
            return array();
        } 
    }

    public static function consultarId($request) {
        try {
            return Usuario::select('s_usuario.*','s_municipio.nombre AS nombre_municipio')
                ->join('s_municipio','s_usuario.id_municipio','=','s_municipio.id')
                ->where('s_usuario.id','=',$request->get('id'))->get()->toArray();   
        } catch (Exception $e) {
            return array();
        } 
    }

    public static function nombreUsuarioActivo($nombreUsuario) {        
    	try {
            $resultado = Usuario::select('s_usuario.*')
                        ->where('s_usuario.usuario', '=', $nombreUsuario)
                        ->join('s_empresa','s_usuario.id_empresa','=','s_empresa.id')
                        ->where('s_usuario.estado','=','1')
                        ->where('s_empresa.estado','=','1')
                        ->get();

            return isset($resultado[0]) ? $resultado[0] : array();
            
	    } catch (Exception $e) {
            return array();
        }
    }


    public static function menu($idUsuario,$idEmpresa) {

    	try {
	    	return Usuario::select('s_modulo.*','s_modulo_rol.id_rol','s_etiqueta.nombre AS nombre_etiqueta','s_etiqueta.clase','s_etiqueta.diminutivo')
                    ->join('s_rol','s_usuario.id_rol','=','s_rol.id')
                    ->join('s_modulo_rol','s_rol.id','=','s_modulo_rol.id_rol')
                    ->join('s_modulo_empresa','s_modulo_rol.id_modulo_empresa','=','s_modulo_empresa.id')
                    ->join('s_modulo','s_modulo_empresa.id_modulo','=','s_modulo.id')
                    ->join('s_etiqueta','s_modulo.id_etiqueta','s_etiqueta.id')
                    ->where('s_usuario.id', '=', $idUsuario)
                    ->where('s_modulo.id_padre','=', NULL)
                    ->where('s_usuario.estado', '=', 1)
                    ->where('s_modulo.estado', '=', 1)
                    ->where('s_rol.id_empresa',$idEmpresa)
                    ->orderBy('s_modulo.orden')
                    ->get()->toArray();
		} catch (Exception $e) {
            return array();
        }                
    }


    public static function eliminar($request)
    {
        try {
            if (Usuario::destroy($request->get('id'))) {
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
     * @date: 2017-11-13 - 04:44 PM
     *
     * Consulta usuario activo por el nombre de usuario y empresa
     *
     * @param string    $usuario:   Nombre del usuario.
     * @param integer   $idEmpresa: Id de la empresa.
     *
     * @return array: Usuario
     */
    public static function consultarPorUsuarioEmpresa($usuario,$idEmpresa) {
        try {
            $resultado = Usuario::select('s_usuario.*')
                ->join('s_empresa','s_usuario.id_empresa','s_empresa.id')
                ->where('s_usuario.usuario', $usuario)
                ->where('s_usuario.id_empresa', $idEmpresa)
                ->where('s_usuario.estado','1')
                ->where('s_empresa.estado','1')
                ->get();

            return isset($resultado[0]) ? $resultado[0] : array();

        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-23 - 10:35 AM
     *
     * Consulta todos los datos para el perfil de usuario
     *
     * @param integer $idUsuario: Id del usuario.
     *
     * @return array: Usuario
     */
    public static function consultarPerfil($idUsuario) {
        try {
            $resultado = DB::select(
                "SELECT se.nombre         AS empresa,
                        sti.nombre        AS tipo_identificacion,
                        sr.nombre         AS rol,
                        IF(su.id_municipio <> null OR su.id_municipio <> '',
                           (
                              SELECT CONCAT(sp.nombre,', ',sd.nombre,', ',sm.nombre)
                              FROM s_municipio sm
                              INNER JOIN s_departamento sd ON sd.id = sm.id_departamento
                              INNER JOIN s_pais         sp ON sp.id = sd.id_pais
                              WHERE sm.id = su.id_municipio
                           ),
                          ''
                        ) AS ciudad,
                        su.*
                
                
                FROM s_usuario su
                INNER JOIN s_empresa              se  ON se.id  = su.id_empresa
                INNER JOIN s_tipo_identificacion  sti ON sti.id = su.id_tipo_identificacion
                INNER JOIN s_rol                  sr  ON sr.id  = su.id_rol
                
                WHERE su.id = $idUsuario"
            );

            return isset($resultado[0]) ? $resultado[0] : [];

        } catch (\Exception $e) {
            return array();
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-05 - 09:44 AM
     *
     * Consulta las transacciones realizadas en los ultimos meses escogidos
     *
     * @param integer $idEmpresa:   Id de la empresa.
     * @param integer $mes:         Mes en numero.
     *
     * @return array
     */
    public static function TransaccionesPorRango($idEmpresa, $mes) {
        try {

            $sql = "SELECT anhio,
                        fecha,
                        estado,
                        COUNT(estado) AS cantidad
                FROM (
                    SELECT  su.estado,
                            YEAR(MAX(st.fecha_alteracion)) AS anhio,
                            MONTH(MAX(st.fecha_alteracion)) AS fecha
                    FROM s_usuario su
                    INNER JOIN s_transacciones st ON st.id_alterado = su.id
                    WHERE su.id_empresa = $idEmpresa
                    AND st.id_modulo = 2
                    AND st.nombre_tabla = 's_usuario'
                    AND MONTH(st.fecha_alteracion) = $mes
                    GROUP BY su.usuario,
                             su.estado
                ) usuario
                GROUP BY  anhio,
                          fecha,
                          estado
                ORDER BY  anhio,
                          fecha,
                          estado ASC";

            $resultado = DB::select($sql);

            return isset($resultado[0]) ? $resultado : [];

        } catch (\Exception $e) {
            return [
                'resultado' => -1,
                'mensaje' => 'Grave error, comuniquese con el administrador del sistema',
                'error' => $e
            ];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-05 - 11:35 AM
     *
     * Consulta total de usuarios por estado y por empresa
     *
     * @param integer $idEmpresa: Id de la empresa.
     *
     * @return array
     */
    public static function TotalUsuarioPorEmpresa($idEmpresa) {
        try {
            $resultado = DB::select(
                "SELECT estado,
                        COUNT(id) AS cantidad
                FROM s_usuario
                WHERE id_empresa = {$idEmpresa}
                GROUP BY estado"
            );

            return isset($resultado[0]) ? $resultado : [];

        } catch (\Exception $e) {
            return [
                'resultado' => -1,
                'mensaje' => 'Grave error, comuniquese con el administrador del sistema',
                'error' => $e
            ];
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-07 - 11:02 AM
     *
     * Consultar usuario por empresa
     *
     * @param request $request:     Peticiones realizadas.
     * @param integer $idEmpresa:   Id de la empresa.
     *
     * @return object
     */
    public static function ConsultarPorEmpresa($request, $idEmpresa) {
        try {
            return Usuario::select('*',DB::raw("CONCAT(nombres,' ',apellidos) AS nombre"))
                ->where('id_empresa',$idEmpresa)
                ->where('estado',1)
                ->orderBy('nombres','ASC')
                ->orderBy('apellidos','ASC')
                ->get();
        } catch (\Exception $e) {
            return self::$hs->Log(self::MODULO,self::MODELO,'ConsultarPorEmpresa', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-07 - 11:02 AM
     *
     * Consultar usuario por empresa
     *
     * @param request $request:     Peticiones realizadas.
     * @param integer $idEmpresa:   Id de la empresa.
     * @param integer $idRol:       Id Rol.
     *
     * @return object
     */
    public static function ConsultarPorEmpresaRol($request, $idEmpresa, $idRol) {
        try {
            return Usuario::select('*',DB::raw("CONCAT(nombres,' ',apellidos) AS nombre"))
                ->where('id_empresa',$idEmpresa)
                ->where('id_rol',$idRol)
                ->where('estado',1)
                ->orderBy('nombres','ASC')
                ->orderBy('apellidos','ASC')
                ->get();
        } catch (\Exception $e) {
            return self::$hs->Log(self::MODULO,self::MODELO,'ConsultarPorEmpresa', $e, $request);
        }
    }
}