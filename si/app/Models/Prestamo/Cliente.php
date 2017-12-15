<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    public $timestamps = false;
    protected $table = "p_cliente";

    public static function consultarTodo($request,$buscar,$pagina,$tamanhioPagina) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Cliente::whereRaw(
                "( identificacion like '%$buscar%'
                OR nombres like '%$buscar%'
                OR apellidos like '%$buscar%'
                OR direccion like '%$buscar%'
                OR telefono like '%$buscar%'
                OR celular like '%$buscar%')")
                ->where('estado','>=',0)
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->orderBy('id','desc')
                ->paginate($tamanhioPagina);

        } catch (Exception $e) {
            return array();
        }
    }


    public static function consultarActivo($request) {
        try {
            return Cliente::select(DB::raw("CONCAT(p_cliente.nombres,' ',p_cliente.apellidos) as nombre"),'p_cliente.*')
                ->where('estado',1)
                ->where('id_empresa',$request->session()->get('idEmpresa'))
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }


    public static function consultarId($id) {
        try {
            return Cliente::where('id','=',$id)->get()->toArray();
        } catch (Exception $e) {
            return array();
        }
    }

    public static function eliminarPorId($request,$id) {
        try {

            $clase = Cliente::Find((int)$id);

            $clase->estado = -1;

            if ($clase->save()) {

                HerramientaStidsController::guardarTransaccion($request,31,5,$id,'p_cliente');

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
        catch (Exception $e) {
            return array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            );
        }
    }
}