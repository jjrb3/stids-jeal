<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\Empresa;
use App\Models\Parametrizacion\Sucursal;
use App\Models\Parametrizacion\SucursalCorreo;
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

        $objeto = Empresa::consultarTodo(
            $request,
            $request->session()->get('idEmpresa'),
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    public static function ConsultarActivos(Request $request) {

        return Empresa::consultarActivo($request);
    }


    public static function ConsultarId(Request $request) {

        return response()->json(Empresa::consultarId($request->get('id')));
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

            $sucursalCorreo = SucursalCorreo::consultarIdSucursal($sucursal['id']);
        }
        

        return array(
            'imagenLogo' => $imagen,
            'sucursal' => $sucursal,
            'sucursalCorreo' => $sucursalCorreo,
            'empresaValores' => $empresaValores,
        );
    }

    public function Guardar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(new Empresa(),$request);

        
        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(Empresa::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function ActualizarImagen(Request $request) {

        $directorio = __DIR__.'/../../../../recursos/imagenes/empresa_logo';
        $archivo = $request->file('imagen_logo');
        
        $nombre = explode('.',$archivo->getClientOriginalName());
        $ext = $nombre[1];
        $nombreArchivo = $request->get('id'). "_" . date("Ymd_his") . ".$ext";

        $imagen = Empresa::consultarId($request->get('id'));

        if ($imagen) {

            $imagen = $imagen[0]['imagen_logo'];
        }

        if($archivo->move($directorio, $nombreArchivo)) {
            
            $clase = Empresa::Find((int)$request->get('id'));
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
    

    public function CambiarEstado(Request $request) {

    	$clase = Empresa::Find((int)$request->get('id'));

    	$clase->estado = $request->get('estado');

    	$mensaje = ['Se cambió el estado correctamente',
                    'Se encontraron problemas al cambiar el estado'];

    	return HerramientaStidsController::ejecutarSave($clase,$mensaje);
    }


    public function Eliminar($request)
    {
        return Empresa::eliminar($request);
    }


    private function insertarCampos($clase,$request) {
        
        $clase->nit          	= $request->get('nit');
        $clase->nombre_cabecera = $request->get('nombre_cabecera');
        $clase->nombre          = $request->get('nombre');
        $clase->imagen_logo     = 'predeterminado.png';


        if (!$request->get('actualizacionRapida')) {

            $clase->id_tema         = $request->get('id_tema');
        }

        return $clase;
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