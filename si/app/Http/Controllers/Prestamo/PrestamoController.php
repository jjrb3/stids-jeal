<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Prestamo\Cliente;
use App\Models\Prestamo\FormaPago;
use App\Models\Prestamo\PrestamoDetalle;
use App\Models\Prestamo\TipoPrestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Models\Prestamo\Prestamo;
use App\Models\Parametrizacion\Empresa;


class PrestamoController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 32, '', 'p_prestamo'];
    }

    /**
     * @autor Jeremy Reyes B.
     * @version 2.0
     * @date_create 2017-10-08 - 09:54 AM
     * @date_modify 2018-01-18 - 04-31 PM <Jeremy Reyes B.>
     * @see 1. Prestamo::consultarTodo.
     *      2. self::$hs->jsonError.
     *
     * Consultamos todos los datos activos del prestamo
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function Consultar(Request $request) {

        $objeto = Prestamo::ConsultarTodo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->session()->get('idEmpresa')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 2.0
     * @date 2017-11-10 - 01:48 PM
     * @see 1. PrestamoDetalle::generarNumeroRefinanciacion.
     *      2. HerramientaStidsController::ejecutarSave.
     *      3. PrestamoDetalle::eliminarCuotasMayores.
     *      4. PrestamoDetalleController::guardarPorCadena.
     *      5. Prestamo::actualizarDatosFinacieros.
     *
     * Se crea la refinanciación del prestamo, se cambia el estado del prestamo y detalle actual a refinanciado
     * luego se agrega los nuevos datos de la refinanciación y actualiza los datos financieros
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return array: Resultado
     */
    public static function GuardarRefinanciacion(Request $request) {

        $idPrestamo = $request->get('id');
        $idEmpresa  = $request->session()->get('idEmpresa');

        #1. Obtenemos el numero de refinanciación
        $noRefinanciacion = PrestamoDetalle::GenerarNumeroRefinanciacion($request,$idPrestamo);


        #2. Actualizamos el prestamo
        $prestamo = Prestamo::Find($idPrestamo);

        $prestamo->id_estado_pago               = 11;
        $prestamo->no_cuotas                    = $request->get('total_cuotas');
        $prestamo->fecha_pago_inicial           = $request->get('fecha_inicial');
        $prestamo->refinanciado                 = 1;
        $prestamo->observacion                  = $request->get('observacion');
        $prestamo->estado                       = 1;
        $prestamo->refinanciado                 = $noRefinanciacion;
        $prestamo->fecha_ultima_refinanciacion  = date('Y-m-d H:i:s');


        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'actualizar';


        #3. Guardamos los datos
        $rPrestamo = self::$hs->ejecutarSave($prestamo, self::$hs->mensajeGuardar, self::$transaccion);

        $ultimaCuota = PrestamoDetalle::ObtenerUltimaCuotaPagada($request, $idEmpresa, $idPrestamo);


        #4. Eliminamos y desactivamos
        if ($ultimaCuota[0]->cuota) {

            PrestamoDetalle::InactivarCuotas($request, $idPrestamo, $ultimaCuota[0]->id);
            PrestamoDetalle::EliminarCuotasMayores($request, $idPrestamo, $ultimaCuota[0]->id);
        }


        #5. Creamos el detalle de la refinanciacion
        $prestamoDetalle = new PrestamoDetalleController();

        $rDetalle = $prestamoDetalle->GuardarPorCadena(
            $request,
            $rPrestamo->original['id'],
            $request->get('cadena_refinaciacion'),
            $request->get('id_cliente'),
            $request->get('id_forma_pago'),
            (int)$ultimaCuota[0]->cuota,
            $noRefinanciacion
        );


        #5. Actualizamos los datos financieros de este prestamo
        $rDatosFinancieros = Prestamo::ActualizarDatosFinacieros($request,[$idPrestamo], false, null, 11);


        return response()->json([
            'resultado'         => 1,
            'mensaje'           => 'Se guardó la refinanciación correctamente',
            'id'                => $rPrestamo->original['id'],
            'prestamo'          => $rPrestamo->original,
            'prestamo_detalle'  => $rDetalle,
            'datos_financieros' => $rDatosFinancieros
        ]);
    }


    public static function ConsultarId(Request $request) {

        $cuota      = PrestamoDetalle::obtenerSiguienteCuota($request,$request->get('id'));
        $prestamo   = Prestamo::consultarId($request->get('id'));

        $prestamo[0]['siguiente_cuota'] = $cuota;

        return response()->json($prestamo);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-13 - 12:45 PM
     * @see: 1. self::$hs->verificationDatas.
     *       2. $this->insertarCampos.
     *       3. self::$hs->ejecutarSave.
     *       4. PrestamoDetalleController::guardarPorCadena.
     *
     * Guarda la información
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Crear(Request $request)
    {
        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'id_cliente'            => 'Debe seleccionar un cliente para poder guardar los cambios',
            'id_tipo_prestamo'      => 'Debe seleccionar un tipo de prestamo para poder guardar los cambios',
            'id_forma_pago'         => 'Debe seleccionar una forma de pago para poder guardar los cambios',
            'fecha_pago_inicial'    => 'Debe digitar la fecha inicial del pago para poder guardar los cambios',
            'monto'                 => 'Debe digitar el monto para poder guardar los cambios',
            'interes'               => 'Debe digitar el interes para poder guardar los cambios',
            'cuotas'                => 'Debe digitar el no. de cuotas para poder guardar los cambios',
            'total_interes'         => 'Se encontraron problemas, realice nuevamente el calculo del interes para poder guardar los cambios',
            'total_general'         => 'Se encontraron problemas, realice nuevamente el calculo del total para poder guardar los cambios'
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Llenamos el objeto con los datos a guardar
        $clase = $this->insertarCampos(new Prestamo(),$request);

        $clase->no_prestamo = HerramientaStidsController::cerosIzquierda(Prestamo::obtenerNoPrestamo($request));

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'crear';


        #3. Guardamos los datos
        $rPrestamo = self::$hs->ejecutarSave($clase, self::$hs->mensajeGuardar, self::$transaccion);


        #4. Guardamos el detalle del prestamo
        $prestamoDetalle = new PrestamoDetalleController();

        $rDetalle = $prestamoDetalle->GuardarPorCadena(
            $request,
            $rPrestamo->original['id'],
            $request->get('cadena_cuotas'),
            $request->get('id_cliente'),
            $request->get('id_forma_pago')
        );

        return response()->json([
            'resultado'         => 1,
            'titulo'            => 'Realizado',
            'mensaje'           => 'Se guardó correctamente',
            'prestamo'          => $rPrestamo->original,
            'prestamo_detalle'  => $rDetalle,
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-18 - 03:08 PM
     *
     * Insertar campos.
     *
     * @param object  $clase:   Clase a llenar.
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    private function insertarCampos($clase,$request) {

        $clase->id_empresa          = $request->session()->get('idEmpresa');
        $clase->id_cliente          = $request->get('id_cliente');
        $clase->id_forma_pago       = $request->get('id_forma_pago');
        $clase->id_estado_pago      = 4;
        $clase->id_tipo_prestamo    = $request->get('id_tipo_prestamo');
        $clase->monto_requerido     = $request->get('monto');
        $clase->intereses           = $request->get('interes');
        $clase->no_cuotas           = $request->get('cuotas');
        $clase->total_intereses     = $request->get('total_interes');
        $clase->total               = $request->get('total_general');
        $clase->fecha_pago_inicial  = $request->get('fecha_pago_inicial');

        return $clase;
    }





    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-22 - 08:41 PM
     * @see: 1. Prestamo::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Elimina un dato por id.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function GuardarObservacion($request)
    {
        $clase = Prestamo::Find((int)$request->get('id'));

        $clase->observacion = $request->get('observacion');

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'actualizar';

        return self::$hs->Guardar(
            $request,
            $clase,
            self::$hs->mensajeGuardar,
            self::$transaccion
        );
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 05:15 PM
     * @see: 1. Prestamo::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Cambia de estado.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CambiarEstado(Request $request) {

        $clase  = Prestamo::Find((int)$request->get('id'));

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
     * @see: 1. Prestamo::find.
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
        $clase = Prestamo::Find((int)$request->get('id'));

        $clase->estado = -1;

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,self::$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-17 - 10:25 PM
     * @see: 1. Modulo::ConsultarModulosActivos.
     *
     * Inicializa los parametros del formulario.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function InicializarFormulario(Request $request) {

        $idEmpresa = $request->session()->get('idEmpresa');

        $clientes       = Cliente::ConsultarCodigoNombreActivo($request, $idEmpresa);
        $tipoPrestamo   = TipoPrestamo::ConsultarActivo($request);
        $formaPago      = FormaPago::ConsultarActivo($request);

        return response()->json([
            'clientes'      => $clientes,
            'tipo_prestamo' => $tipoPrestamo,
            'forma_pago'    => $formaPago
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-23 - 12:35 PM
     * @see: 1. Modulo::ConsultarModulosActivos.
     *
     * Consulta los totales para estadisticas
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarTotales(Request $request) {

        $idEmpresa = $request->session()->get('idEmpresa');

        $totalCliente               = Cliente::ConsultarActivo($request, $idEmpresa)->count();
        $totalPrestamoRealizados    = Prestamo::Realizados($request, $idEmpresa)->count();
        $totalPrestamoCompletados   = Prestamo::Completados($request, $idEmpresa)->count();
        $totalPrestamoSinCompletar  = $totalPrestamoRealizados - $totalPrestamoCompletados;


        return response()->json([
            'clientes'      => $totalCliente,
            'realizados'    => $totalPrestamoRealizados,
            'completados'   => $totalPrestamoCompletados,
            'sin_completar' => $totalPrestamoSinCompletar
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-23 - 12:35 PM
     * @see: 1. Modulo::ConsultarModulosActivos.
     *
     * Consulta los totales para estadisticas
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function DetalleRecaudo(Request $request) {

        $insertar  = false;
        $idEmpresa = $request->session()->get('idEmpresa');

        $fecha = self::$hs->ObtenerInicioFinPorMes(date('m'),date('Y'));

        $totales = Prestamo::ConsultarTotalRecaudado($request, $idEmpresa);
        $detalle = Prestamo::ConsultarDetallePagosPorDia($request, $idEmpresa, $fecha['fecha_inicial'], $fecha['fecha_final']);

        if (!$totales[0]->total_general) {

            $total = Prestamo::ConsultarTotalGeneralAPagar($request, $idEmpresa);;

            $totales[0]->total_general  = $total[0]->total;
            $totales[0]->total_recaudar = $total[0]->total;
            $totales[0]->total_pagado = 0;
            $totales[0]->intereses = 0;
            $totales[0]->porcentaje_capital = 0;
            $totales[0]->porcentaje_interes = 0;
            $totales[0]->porcentaje_pagado = 0;
            $totales[0]->porcentaje_recaudar = 100;
        }


        if (isset($detalle[0]) && $detalle[0]->fecha !== $fecha['fecha_inicial']) {

            foreach ($detalle as $k => $i) {
                $detalle[$k + 1] = $i;
            }

            $insertar = true;
        }

        if (!$detalle || $insertar) {

            $detalle[0] = [
                'fecha' => $fecha['fecha_inicial'],
                'interes' => 0,
                'capital' => 0,
                'total' => 0
            ];
        }

        if (!isset($detalle[$fecha['final']-1])) {
            $detalle[] = [
                'fecha' => $fecha['fecha_final'],
                'interes' => null,
                'capital' => null,
                'total' => null
            ];
        }


        return response()->json([
            'totales'   => $totales[0],
            'detalle'   => $detalle
        ]);
    }
}