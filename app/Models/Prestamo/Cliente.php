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

    const MODULO = 'Parametrizacion';
    const MODELO = 'Banco';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-15 - 12:07 PM
     *
     * Consultar todos con paginación
     *
     * @param request   $request:     Peticiones realizadas.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     * @param integer   $idEmpresa:   ID empresa.
     *
     * @return object
     */
    public static function consultarTodo($request, $buscar = null, $pagina = 1, $tamanhio = 10, $idEmpresa) {
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
                OR celular like '%$buscar%')"
            )
                ->where('estado','>','-1')
                ->where('id_empresa',$idEmpresa)
                ->orderBy('estado','desc')
                ->orderBy('nombres')
                ->orderBy('apellidos')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarTodo', $e, $request);
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