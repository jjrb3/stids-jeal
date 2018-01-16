<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\Prestamo\PrestamoDetallePagoController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrestamoDetallePago extends Model
{
    public $timestamps = false;
    protected $table = "p_prestamo_detalle_pago";

    public static function consultarActivo() {
        try {
            return PrestamoDetallePagoController::select(DB::raw("p_tipo_prestamo.descripcion AS nombre"),'p_tipo_prestamo.*')
                ->where('estado',1)
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-11 - 02:29 PM
     *
     * Elimina los pagos por id de cuota
     *
     * @param array     $request:    Peticiones realizadas.
     * @param integer   $idPrestamo: Id detalle del prestamo.
     *
     * @return array: Resultado de la eliminación
     */
    public static function eliminarPorDetallePrestamo($request,$idPrestamoDetalle) {
        try {

            $resultado = PrestamoDetallePago::where('id_empresa',$request->session()->get('idEmpresa'))
                ->where('id_prestamo_detalle',$idPrestamoDetalle)
                ->update(['estado' => -1]);

            if ($resultado > 0) {

                return array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                );
            }
            else {
                return array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar',
                );
            }
        }
        catch (\Exception $e) {
            return array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            );
        }
    }
}