<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Parametrizacion\TipoIdentificacion;
use App\Models\Prestamo\Cliente;
use App\Models\Prestamo\EstadoCivil;
use App\Models\Prestamo\Ocupacion;


class ClienteController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 31, '', 'p_cliente'];
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-13 - 12:45 PM
     * @see: 1. Banco::consultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function Consultar(Request $request) {

        $objeto = Cliente::consultarTodo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->session()->get('idEmpresa')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    public static function ConsultarActivos(Request $request) {

        return Cliente::consultarActivo($request);
    }

    public static function ConsultarId(Request $request) {

        return response()->json(Cliente::consultarId($request->get('id')));
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-11-01 - 2:27 PM
     *
     * Consultar los parametros que se necesitan el formulario
     *
     * @return json
     */
    public static function ConsultarParametrosFormulario(Request $request) {

        return response()->json(
            array(
                'tipo_identificacion'   => TipoIdentificacion::consultarActivo($request, $request->session()->get('idEmpresa')),
                'estado_civil'          => EstadoCivil::consultarActivo(),
                'ocupacion'             => Ocupacion::consultarActivo(),
            )
        );
    }


    public function Guardar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(new Cliente(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        $transaccion = [$request,31,'crear','p_cliente'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje,$transaccion);
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(Cliente::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
                    'Se encontraron problemas al actualizar'];

        $transaccion = [$request,31,'actualizar','p_cliente'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje,$transaccion);
    }

    public static function CambiarEstado(Request $request) {

        $clase = Cliente::Find((int)$request->get('id'));

        $clase->estado = $request->get('estado');

        $mensaje = ['Se cambió el estado correctamente',
                    'Se encontraron problemas al cambiar el estado'];

        $transaccion = [$request,31,$clase->estado == 1 ? 'activo' : 'inactivo','p_cliente'];

        return HerramientaStidsController::ejecutarSave($clase,$mensaje,$transaccion);
    }

    public function Eliminar($request)
    {
        return Cliente::eliminarPorId($request,$request->get('id'));
    }


    private function insertarCampos($clase,$request) {

        # PK & FK
        $clase->id_empresa                  = $request->session()->get('idEmpresa');
        $clase->id_tipo_identificacion      = $request->get('id_tipo_identificacion');
        $clase->id_estado_civil             = $request->get('id_estado_civil');
        $clase->id_municipio                = $request->get('id_municipio');
        $clase->id_municipio_empresa        = $request->get('id_municipio_empresa');
        $clase->id_tipo_identificacion      = $request->get('id_tipo_identificacion');
        $clase->id_municipio_ref_personal   = $request->get('id_municipio_ref_personal');
        $clase->id_municipio_ref_familiar   = $request->get('id_municipio_ref_familiar');
        $clase->id_ocupacion                = $request->get('id_ocupacion');

        # Información del cliente
        $clase->identificacion      = $request->get('identificacion');
        $clase->nombres             = $request->get('nombres');
        $clase->apellidos           = $request->get('apellidos');
        $clase->fecha_nacimiento    = $request->get('fecha_nacimiento');
        $clase->email_personal      = $request->get('email_personal');
        $clase->barrio              = $request->get('barrio');
        $clase->direccion           = $request->get('direccion');
        $clase->telefono            = $request->get('telefono');
        $clase->celular             = $request->get('celular');

        # Información de su actividad economica
        $clase->empresa_nombre              = $request->get('empresa_nombre');
        $clase->empresa_cargo               = $request->get('empresa_cargo');
        $clase->empresa_area                = $request->get('empresa_area');
        $clase->empresa_barrio              = $request->get('empresa_barrio');
        $clase->empresa_direccion           = $request->get('empresa_direccion');
        $clase->empresa_telefono            = $request->get('empresa_telefono');
        $clase->empresa_fecha_ingreso       = $request->get('empresa_fecha_ingreso');
        $clase->empresa_antiguedad_meses    = $request->get('empresa_antiguedad_meses');

        # Información financiera
        $clase->sueldo      = $request->get('sueldo');
        $clase->ingresos    = $request->get('ingresos');
        $clase->egresos     = $request->get('egresos');

        # Referencias
        $clase->ref_personal_nombres    = $request->get('ref_personal_nombres');
        $clase->ref_personal_apellidos  = $request->get('ref_personal_apellidos');
        $clase->ref_personal_barrio     = $request->get('ref_personal_barrio');
        $clase->ref_personal_telefono   = $request->get('ref_personal_telefono');
        $clase->ref_personal_celular    = $request->get('ref_personal_celular');
        $clase->ref_familiar_nombres    = $request->get('ref_familiar_nombres');
        $clase->ref_familiar_apellidos  = $request->get('ref_familiar_apellidos');
        $clase->ref_familiar_barrio     = $request->get('ref_familiar_barrio');
        $clase->ref_familiar_telefono   = $request->get('ref_familiar_telefono');
        $clase->ref_familiar_celular    = $request->get('ref_familiar_celular');

        # Comentarios
        $clase->observaciones = $request->get('observaciones');

        return $clase;
    }


    public function verificacion($request){

        $campos = array(
            'id_tipo_identificacion' => 'Debe seleccionar el tipo de identificación para continuar',
            'identificacion'         => 'Debe digitar el campo documento para continuar',
            'nombres'                => 'Debe digitar el campo nombres para continuar',
            'apellidos'              => 'Debe digitar el campo apellidos para continuar',
            'direccion'              => 'Debe digitar el campo dirección para continuar',
        );

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }
}