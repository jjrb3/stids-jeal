<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;
use App\Models\Prestamo\Cliente;
use App\Models\Prestamo\Codeudor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Models\Parametrizacion\Empresa;
use App\Models\Prestamo\Reportes;

class ReportesController extends Controller
{
    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 10:10 AM
     * @see: 1. Empresa::Find.
     *       2. App::make.
     *       3. Reportes::ConsultarPrestamosFinalizadosPorFechas
     *
     * Consulta el listado de prestamos finalizados.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return pdf
     */
    public static function PrestamosFinalizados(Request $request) {

        $pdf     = App::make('dompdf.wrapper');

        $empresa = Empresa::Find($request->session()->get('idEmpresa'));
        $tabla   = Reportes::ConsultarPrestamosFinalizadosPorFechas(
            $request,
            $request->get('fecha_inicio'),
            $request->get('fecha_fin')
        );

        $pdf->loadHTML(
            View('prestamo.pdf-prestamos-finalizados',[
                'nombre_empresa' => $empresa->nombre,
                'logo_empresa' => $empresa->imagen_logo,
                'fecha_inicial' => $request->get('fecha_inicio'),
                'fecha_final' => $request->get('fecha_fin'),
                'usuario_generador' => $request->session()->get('nombres'),
                'tabla' => $tabla,
            ])
        )
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->save('Reporte.pdf');

        //return $pdf->download('Reporte de relación de prestamo.pdf');
        return $pdf->stream('Reporte de relación de prestamo.pdf');
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 10:10 AM
     * @see: 1. Empresa::Find.
     *       2. App::make.
     *       3. Reportes::ConsultarRelacionPrestamoPorFechas
     *
     * Consulta el listado de codeudores por el cliente
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return pdf
     */
    public static function RelacionPrestamo(Request $request) {

        $pdf     = App::make('dompdf.wrapper');

        $empresa = Empresa::Find($request->session()->get('idEmpresa'));
        $tabla   = Reportes::ConsultarRelacionPrestamoPorFechas(
            $request,
            $request->get('fecha_inicio'),
            $request->get('fecha_fin')
        );


        $pdf->loadHTML(
            View('prestamo.pdf-relacion-prestamo',[
                'nombre_empresa' => $empresa->nombre,
                'logo_empresa' => $empresa->imagen_logo,
                'fecha_inicial' => $request->get('fecha_inicio'),
                'fecha_final' => $request->get('fecha_fin'),
                'usuario_generador' => $request->session()->get('nombres'),
                'tabla' => $tabla,
            ])
        )
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->save('Reporte.pdf');

        //return $pdf->download('Reporte de relación de prestamo.pdf');
        return $pdf->stream('Reporte de relación de prestamo.pdf');
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 10:10 AM
     * @see: 1. Empresa::Find.
     *       2. App::make.
     *       3. Reportes::ConsultarRelacionPrestamoPorFechas
     *
     * Consulta el listado de codeudores por el cliente
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return pdf
     */
    public static function PrestamosSinCompletar(Request $request) {


        $pdf     = App::make('dompdf.wrapper');

        $empresa = Empresa::Find($request->session()->get('idEmpresa'));
        $tabla   = Reportes::ConsultarPrestamosSinCompletar(
            $request,
            $request->get('fecha_inicio'),
            $request->get('fecha_fin')
        );

        $pdf->loadHTML(
            View('prestamo.pdf-prestamo-sin-completar',[
                'nombre_empresa'    => $empresa->nombre,
                'logo_empresa'      => $empresa->imagen_logo,
                'fecha_inicial'     => $request->get('fecha_inicio'),
                'fecha_final'       => $request->get('fecha_fin'),
                'usuario_generador' => $request->session()->get('nombres'),
                'tabla'             => $tabla,
            ])
        )
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->save('Reporte.pdf');

        //return $pdf->download('Reporte de prestamos sin completar.pdf');
        return $pdf->stream('Reporte de prestamos sin completar.pdf');
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 10:10 AM
     * @see: 1. Empresa::Find.
     *       2. App::make.
     *       3. Reportes::ConsultarRecaudoDiarioPorFecha
     *
     * Consulta el listado de codeudores por el cliente
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return pdf
     */
    public static function RecaudoDiario(Request $request) {

        $pdf     = App::make('dompdf.wrapper');

        $empresa = Empresa::Find($request->session()->get('idEmpresa'));
        $tabla   = Reportes::ConsultarRecaudoDiarioPorFecha(
            $request,
            $request->get('fecha')
        );

        $pdf->loadHTML(
            View('prestamo.pdf-recaudo-diario',[
                'nombre_empresa'    => $empresa->nombre,
                'logo_empresa'      => $empresa->imagen_logo,
                'fecha'             => $request->get('fecha'),
                'usuario_generador' => $request->session()->get('nombres'),
                'tabla'             => $tabla,
            ])
        )
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->save('Reporte.pdf');

        //return $pdf->download('Reporte de recaudo diario.pdf');
        return $pdf->stream('Reporte de recaudo diario.pdf');
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 10:10 AM
     * @see: 1. Empresa::Find.
     *       2. App::make.
     *       3. Reportes::ConsultarRecaudoDiarioPorFecha
     *
     * Consulta el listado de codeudores por el cliente
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return pdf
     */
    public static function InformacionGeneralCliente(Request $request) {

        $idCliente = $request->get('id_cliente');

        $pdf     = App::make('dompdf.wrapper');

        $empresa     = Empresa::Find($request->session()->get('idEmpresa'));
        $informacion = Cliente::ConsultarInformacionPorId($request, $idCliente);
        $codeudores  = Codeudor::ConsultarPorIdCliente($request, $idCliente);



        $pdf->loadHTML(
            View('prestamo.pdf-informacion-cliente',[
                'nombre_empresa'    => $empresa->nombre,
                'logo_empresa'      => $empresa->imagen_logo,
                'fecha'             => date('Y-m-d H:i:s'),
                'usuario_generador' => $request->session()->get('nombres'),
                'informacion'       => $informacion[0],
                'codeudores'        => $codeudores
            ])
        )
            ->setPaper('A4', 'portrait')
            ->setWarnings(false)
            ->save('Reporte.pdf');

        //return $pdf->download('Reporte de recaudo diario.pdf');
        return $pdf->stream("Información de {$informacion[0]->nombres} {$informacion[0]->apellidos}.pdf");
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

        //return $pdf->download('Simulación.pdf');
        return $pdf->stream('Simulación.pdf');
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-25 - 10:15 AM
     * @see: 1. Empresa::Find.
     *       2. App::make.
     *       3. Reportes::ConsultarRelacionPrestamoPorFechas
     *
     * Consulta el total de recaudo hecho por rango de fecha
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return pdf
     */
    public static function TotalRecaudado(Request $request) {

        $pdf     = App::make('dompdf.wrapper');

        $empresa = Empresa::Find($request->session()->get('idEmpresa'));
        $tabla   = Reportes::ConsultarTotalRecaudado(
            $request,
            $request->session()->get('idEmpresa'),
            $request->get('fecha_inicio'),
            $request->get('fecha_fin')
        );

        $pdf->loadHTML(
            View('prestamo.pdf-prestamo-total-recaudado',[
                'nombre_empresa'    => $empresa->nombre,
                'logo_empresa'      => $empresa->imagen_logo,
                'fecha_inicial'     => $request->get('fecha_inicio'),
                'fecha_final'       => $request->get('fecha_fin'),
                'usuario_generador' => $request->session()->get('nombres'),
                'tabla'             => $tabla,
            ])
        )
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->save('Reporte.pdf');

        //return $pdf->download('Reporte de prestamos sin completar.pdf');
        return $pdf->stream('Reporte total recaudado.pdf');
    }
}