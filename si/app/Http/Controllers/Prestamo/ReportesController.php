<?php

namespace App\Http\Controllers\Prestamo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Models\Parametrizacion\Empresa;
use App\Models\Prestamo\Reportes;

class ReportesController extends Controller{


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

        return $pdf->download('Reporte de relación de prestamo.pdf');
        //return $pdf->stream();
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

        return $pdf->download('Reporte de relación de prestamo.pdf');
        //return $pdf->stream();
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

        return $pdf->download('Reporte de prestamos sin completar.pdf');
        //return $pdf->stream();
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

        return $pdf->download('Reporte de recaudo diario.pdf');
        //return $pdf->stream();
    }
}