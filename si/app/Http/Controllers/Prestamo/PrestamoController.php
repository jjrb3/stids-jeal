<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Prestamo\PrestamoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Models\Prestamo\Prestamo;
use App\Models\Parametrizacion\Empresa;


class PrestamoController extends Controller
{
    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2017-10-08 - 09:54 am
     * @see 1. Prestamo::consultarTodo.
     *
     * Consultamos todos los datos activos del prestamo
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json
     */
    public static function Consultar(Request $request) {

        return Prestamo::consultarTodo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhioPagina')
        );
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

        #1. Obtenemos el numero de refinanciación
        $noRefinanciacion = PrestamoDetalle::generarNumeroRefinanciacion($request,$idPrestamo);


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


        $mensaje        = ['Se guardó correctamente','Se encontraron problemas al guardar'];
        $transaccion    = [$request,32,'actualizar','p_prestamo'];

        $rPrestamo =  json_decode(json_encode(HerramientaStidsController::ejecutarSave($prestamo,$mensaje,$transaccion)));


        #3. Eliminamos el detalle del prestamo
        PrestamoDetalle::eliminarCuotasMayores($request,$idPrestamo,$request->get('ultima_cuota_pagada'));


        #4. Creamos el detalle de la refinanciacion
        $rDetalle = PrestamoDetalleController::guardarPorCadena(
            $rPrestamo->original->id,
            $request->get('cadena_refinaciacion'),
            $request,
            $prestamo->id_cliente,
            $prestamo->id_forma_pago,
            $request->get('ultima_cuota_pagada'),
            $noRefinanciacion
        );


        #5. Actualizamos los datos financieros de este prestamo
        $rDatosFinancieros = Prestamo::actualizarDatosFinacieros($request,[$idPrestamo]);


        return response()->json([
            'resultado'         => 1,
            'mensaje'           => 'Se guardó la refinanciación correctamente',
            'id'                => $rPrestamo->original->id,
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


    public function Guardar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(new Prestamo(),$request);

        $clase->no_prestamo = HerramientaStidsController::cerosIzquierda(Prestamo::obtenerNoPrestamo($request));

        $mensaje = ['Se guardó correctamente','Se encontraron problemas al guardar'];

        $transaccion = [$request,32,'crear','p_prestamo'];

        $rPrestamo  = json_decode(json_encode(HerramientaStidsController::ejecutarSave($clase,$mensaje,$transaccion)));
        $rDetalle   = PrestamoDetalleController::guardarPorCadena(
            $rPrestamo->original->id,
            $request->get('detalle'),
            $request,
            $request->get('id_cliente'),
            $request->get('id_forma_pago'));

        return response()->json(array(
            'resultado'         => 1,
            'mensaje'           => 'Se guardó correctamente',
            'prestamo'          => $rPrestamo->original,
            'prestamo_detalle'  => $rDetalle,
        ));
    }


    public function Eliminar($request)
    {
        return Prestamo::eliminarPorId($request,$request->get('id'));
    }


    private function insertarCampos($clase,$request) {

        $clase->id_empresa          = $request->session()->get('idEmpresa');
        $clase->id_cliente          = $request->get('id_cliente');
        $clase->id_forma_pago       = $request->get('id_forma_pago');
        $clase->id_estado_pago      = 4;
        $clase->id_tipo_prestamo    = $request->get('id_tipo_prestamo');
        $clase->monto_requerido     = $request->get('monto_requerido');
        $clase->intereses           = $request->get('interes');
        //$clase->mora                = $request->get('mora');
        $clase->no_cuotas           = $request->get('no_cuotas');
        $clase->total_intereses     = $request->get('total_intereses');
        $clase->total               = $request->get('total');
        $clase->fecha_pago_inicial  = $request->get('fecha_pago_inicial');

        return $clase;
    }


    public function verificacion($request){

        $campos = array(
            'id_cliente'         => 'Debe seleccionar el cliente para continuar',
            //'mora'             => 'Debe digitar el porcentaje de mora para continuar',
            'monto_requerido'    => 'Debe digitar el monto requerido para continuar',
            'interes'            => 'Debe digitar el campo interes para continuar',
            'id_forma_pago'      => 'Debe seleccionar la forma de pago para continuar',
            'no_cuotas'          => 'Debe digitar el numero de cuotas para continuar',
            'fecha_pago_inicial' => 'Debe digitar el campo fecha de pago inicial para continuar para continuar',
        );

        foreach ($campos as $campo => $mensaje) {

            $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

            if ($resultado) {
                return $resultado;
            }
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-08 - 10:50 AM
     * @see: 1. Empresa::Find.
     *       2. App::make.
     *
     * Descarga la simulación creada en el prestamo.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return pdf
     */
    public static function DescargarSimulacion(Request $request) {

        $pdf     = App::make('dompdf.wrapper');

        $empresa = Empresa::Find($request->session()->get('idEmpresa'));

        $pdf->loadHTML(
            View('prestamo.pdf-simulacion',[
                'nombre_empresa'    => $empresa->nombre,
                'logo_empresa'      => $empresa->imagen_logo,
                'usuario_generador' => $request->session()->get('nombres'),
                'encabezado'        => explode(';',$request->get('encabezado')),
                'tabla'             => array_filter(explode('}',$request->get('tabla'))),
                'meses'             => HerramientaStidsController::$nombreMeses
            ])
        )
            ->setWarnings(false)
            ->save('Simulación.pdf');

        return $pdf->download('Simulación.pdf');
        //return $pdf->stream();
    }
}