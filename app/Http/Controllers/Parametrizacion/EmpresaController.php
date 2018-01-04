<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\ModuloEmpresa;
use App\Models\Parametrizacion\Rol;
use App\Models\Parametrizacion\Tema;
use Illuminate\Http\Request;

use App\Models\Parametrizacion\Empresa;
use App\Models\Parametrizacion\Sucursal;
use App\Models\Parametrizacion\EmpresaCorreo;
use App\Models\Parametrizacion\EmpresaValores;


class EmpresaController extends Controller
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
     * @date: 2017-12-24 - 10:39 AM
     * @see: 1. Empresa::consultarTodo.
     *
     * Parametros del formulario
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function InicializarFormulario(Request $request) {

        return response()->json([
            'temas' => TemaController::ConsultarTodo($request)
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 09:30 AM
     * @see: 1. Empresa::consultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function Consultar(Request $request) {

        $objeto = Empresa::ConsultarTodo(
            $request,
            $request->session()->get('idEmpresa'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 11:30 AM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Empresa::ConsultarPorNitNombre.
     *       3. Empresa::find.
     *       4. self::$hs->ejecutarSave.
     *
     * Guarda datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Guardar(Request $request)
    {
        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'id_tema'  => 'Seleccione un tema para poder guardar los cambios',
            'nombre'   => 'Digite el nombre para poder guardar los cambios',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Consultamos si existe
        $existeRegistro = Empresa::ConsultarPorNitNombre(
            $request,
            $request->get('nit'),
            $request->get('nombre')
        );


        #3. Que no se encuentre ningun error
        if (!is_null($existeRegistro)) {

            #3.1. Si existe y no esta eliminado
            if ($existeRegistro->count() && $existeRegistro[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado entonces lo vuelve a activar
            elseif ($existeRegistro->count() && $existeRegistro[0]->estado < 0) {

                $clase = Empresa::find($existeRegistro[0]->id);

                $clase->id_tema         = $request->get('id_tema');
                $clase->nit             = $request->get('nit');
                $clase->nombre_cabecera = $request->get('nombre_cabecera');
                $clase->nombre          = $request->get('nombre');
                $clase->frase           = $request->get('frase');
                $clase->estado = 1;

                $transaccion = [$request,6,'actualizar','s_empresa'];

                return self::$hs->ejecutarSave($clase,self::$hs->mensajeGuardar,$transaccion);
            }
            #3.3. Si no existe entonces se crea
            else {

                $clase = new Empresa();

                $clase->id_tema         = $request->get('id_tema');
                $clase->nit             = $request->get('nit');
                $clase->nombre_cabecera = $request->get('nombre_cabecera');
                $clase->nombre          = $request->get('nombre');
                $clase->frase           = $request->get('frase');
                $clase->imagen_logo     = 'predeterminado.png';
                $clase->estado          = 1;

                $transaccion = [$request,6,'crear','s_empresa'];

                return self::$hs->ejecutarSave($clase,self::$hs->mensajeGuardar,$transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 01:09 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Empresa::find.
     *       3. self::$hs->ejecutarSave.
     *
     * Actualiza datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Actualizar(Request $request)
    {
        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'id_tema'  => 'Seleccione un tema para poder actualizar',
            'nombre'   => 'Digite el nombre para poder actualizar',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Agregamos los nuevos parametros y actualizamos
        $clase = Empresa::find((int)$request->get('id'));

        $clase->id_tema         = $request->get('id_tema');
        $clase->nit             = $request->get('nit');
        $clase->nombre_cabecera = $request->get('nombre_cabecera');
        $clase->nombre          = $request->get('nombre');
        $clase->frase           = $request->get('frase');

        $transaccion = [$request, 6, 'actualizar', 's_empresa'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeActualizar,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-24 - 01:41 PM
     * @see: 1. Empresa::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Cambia de estado.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CambiarEstado(Request $request) {

        $clase  = Empresa::Find((int)$request->get('id'));

        if ($clase->estado === 1) {
            $clase->estado = 0;
        }
        elseif ($clase->estado === 0) {
            $clase->estado = 1;
        }

        $transaccion = [$request,6,self::$hs->estados[$clase->estado],'s_empresa'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEstado,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 01:44 PM
     * @see: 1. Empresa::find.
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
        $clase = Empresa::Find((int)$request->get('id'));

        $clase->estado = -1;

        $transaccion = [$request,6,'eliminar','s_empresa'];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-12-20 - 01:56 PM
     *
     * Consultar el detalle de la empresa
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function ConsultarDetalle($request)
    {
        $idEmpresa = $request->get('id_empresa');

        $sucursal = Sucursal::ConsultarPorEmpresa($request, $idEmpresa);
        $rol      = Rol::consultarActivoPorEmpresa($idEmpresa);
        $modulos  = ModuloEmpresa::ObtenerModulosPorEmpresa($request, $idEmpresa);
        $empresa  = Empresa::find($idEmpresa);

        return response()->json([
            'sucursal'  => $sucursal->count() > 0 ? $sucursal[0] : '',
            'rol'       => $rol,
            'modulos'   => $modulos,
            'empresa'   => $empresa
        ]);
    }


    public static function ConsultarActivos(Request $request) {

        return Empresa::consultarActivo($request);
    }


    public static function ConsultarEmpresaSistema(Request $request) {

        return Empresa::sistema($request);
    }


    public static function Detalle(Request $request) {

        $imagen         = '';
        $sucursal       = array();
        $sucursalCorreo = array();

        $imagen         = Empresa::consultarId($request->get('id'));
        $sucursal       = Sucursal::consultarIdEmpresa($request->get('id'))->toArray();
        $empresaValores = EmpresaValores::consultarIdEmpresa($request->get('id'));


        if ($imagen) {

            $imagen = $imagen[0]['imagen_logo'];
        }

        if ($sucursal) {

            $sucursal = $sucursal[0];

            $sucursalCorreo = EmpresaCorreo::consultarIdSucursal($sucursal['id']);
        }
        

        return array(
            'imagenLogo' => $imagen,
            'sucursal' => $sucursal,
            'sucursalCorreo' => $sucursalCorreo,
            'empresaValores' => $empresaValores,
        );
    }


    public function ActualizarImagen(Request $request) {

        $directorio = public_path('recursos/imagenes/empresa_logo/');
        $archivo = $request->file('file');

        $nombre = explode('.',$archivo->getClientOriginalName());
        $ext = $nombre[1];
        $nombreArchivo = $request->get('id_empresa'). "_" . date("Ymd_his") . ".$ext";

        if($archivo->move($directorio, $nombreArchivo)) {
            
            $clase = Empresa::Find((int)$request->get('id_empresa'));

            $imagen = $clase->imagen_logo;

            $clase->imagen_logo = $nombreArchivo;

            try {

                if ($clase->save()) {

                    if ($imagen !== 'predeterminado.png') {
                        unlink("$directorio/$imagen"); // Eliminamos la imagen
                    }
                }
            } catch (\Exception $e) {
                return 'Se encontrarón errores al momento de subir la imagen. ' . $e->getMessage();
            }
        }
    }


    public function verificacion($request){


        $camposRapidos = array(
            'nit' => 'Debe digitar el campo nit para continuar',
            'nombre_cabecera' => 'Debe digitar el campo nombre de cabecera para continuar',
            'nombre' => 'Debe digitar el campo nombre para continuar',
        );

        $camposCompletos = array(
            'id_tema' => 'Debe seleccionar un tema para continuar',
        );

        $campos = $request->get('actualizacionRapida') ? $camposRapidos : array_merge($camposCompletos,$camposRapidos);

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }
}