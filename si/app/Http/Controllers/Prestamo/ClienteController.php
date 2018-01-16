<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\Banco;
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


    public static function ConsultarActivos(Request $request) {

        return Cliente::consultarActivo($request);
    }

    public static function ConsultarId(Request $request) {

        return response()->json(Cliente::consultarId($request->get('id')));
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

        $objeto = Cliente::ConsultarTodo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->session()->get('idEmpresa')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 02:03 PM
     * @see: 1. Modulo::ConsultarModulosActivos.
     *       2. EtiquetaController::ConsultarActivos.
     *
     * Inicializa los parametros del formulario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function InicializarFormulario(Request $request) {

        $idEmpresa = $request->session()->get('idEmpresa');

        $tipoIdentificacion = TipoIdentificacion::consultarActivo($request, $idEmpresa);
        $estadoCivil        = EstadoCivil::ConsultarActivo($request);
        $ocupacion          = Ocupacion::ConsultarActivo($request);
        $banco              = Banco::consultarActivo($request, $idEmpresa);

        return response()->json([
            'tipo_identificacion'   => $tipoIdentificacion,
            'estado_civil'          => $estadoCivil,
            'ocupacion'             => $ocupacion,
            'bancos'                => $banco
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-13 - 12:45 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Cliente::ConsultarPorEmpTipIdeNomApe.
     *       3. Cliente::find.
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
        $idEmpresa      = $request->session()->get('idEmpresa');

        #1.1. Datos obligatorios
        $datos = [
            'id_tipo_identificacion' => 'Debe seleccionar un tipo de identificación para poder guardar los cambios',
            'identificacion' => 'Debe digitar la identificación para poder guardar los cambios',
            'nombres' => 'Debe digitar los nombres para poder guardar los cambios',
            'apellidos' => 'Debe digitar los apellidos para poder guardar los cambios',
            'direccion' => 'Debe digitar la dirección para poder guardar los cambios'
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Si no es actualización consultamos si existe
        if (!$id) {
            $existeRegistro = Cliente::ConsultarPorEmpTipIdeNomApe(
                $request,
                $idEmpresa,
                $request->get('id_tipo_identificacion'),
                $request->get('identificacion'),
                $request->get('nombres'),
                $request->get('apellidos')
            );
        }
        else {
            $existeRegistro[] = Cliente::find($id);
        }

        #3. Que no se encuentre ningun error
        if (!is_null($existeRegistro)) {

            #3.1. Si existe, no esta eliminado y no es una actualización
            if (!$id && $existeRegistro->count() && $existeRegistro[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado o es una actualizacion lo vuelve a activar y actualiza todos sus datos
            elseif ($id || $existeRegistro->count() && $existeRegistro[0]->estado < 0) {

                $clase = $this->insertarCampos(Cliente::find($existeRegistro[0]->id), $request);

                self::$transaccion[0] = $request;
                self::$transaccion[2] = 'actualizar';

                return self::$hs->ejecutarSave(
                    $clase,
                    $id ? self::$hs->mensajeActualizar : self::$hs->mensajeGuardar,
                    self::$transaccion
                );
            }
            #3.3. Si no existe entonces se crea
            else {

                $clase = $this->insertarCampos(new Cliente(), $request);

                $clase->codigo = Cliente::ObtenerNuevoCodigo($request, $idEmpresa);

                self::$transaccion[0] = $request;
                self::$transaccion[2] = 'crear';

                return self::$hs->ejecutarSave($clase, self::$hs->mensajeGuardar, self::$transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 04:00 PM
     *
     * Insertar campos.
     *
     * @param object  $clase:   Clase a llenar.
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
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
        $clase->id_banco_cliente            = $request->get('id_banco_cliente');
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
        $clase->no_cuenta   = $request->get('no_cuenta');
        $clase->sueldo      = (int)str_replace('.', '', $request->get('sueldo'));
        $clase->ingresos    = (int)str_replace('.', '', $request->get('ingresos'));
        $clase->egresos     = (int)str_replace('.', '', $request->get('egresos'));

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

        # Otros
        $request->get('id') ? null : $clase->estado = 1;

        return $clase;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 05:15 PM
     * @see: 1. Cliente::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Cambia de estado.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CambiarEstado(Request $request) {

        $clase  = Cliente::Find((int)$request->get('id'));

        if ($clase->estado === 1) {
            $clase->estado = 0;
        }
        elseif ($clase->estado === 0) {
            $clase->estado = 1;
        }

        self::$transaccion[0] = $request;
        self::$transaccion[2] = self::$hs->estados[$clase->estado];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEstado,self::$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 05:15 PM
     * @see: 1. Cliente::find.
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
        $clase = Cliente::Find((int)$request->get('id'));

        $clase->estado = -1;

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,self::$transaccion);
    }
}