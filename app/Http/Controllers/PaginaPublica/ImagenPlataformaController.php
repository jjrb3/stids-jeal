<?php

namespace App\Http\Controllers\PaginaPublica;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\PaginaPublica\ImagenPlataforma;
use App\Models\PaginaPublica\TipoImagen;

class ImagenPlataformaController extends Controller
{
    public static function Consultar(Request $request) {

        return ImagenPlataforma::consultarTodo($request);
    }

    public static function ConsultarId(Request $request) {

        return response()->json(ImagenPlataforma::Find($request->get('id')));
    }


    public function Guardar(Request $request)
    {
        if ($this->verificacion($request)) {
            return $this->verificacion($request);
        }

        $clase = $this->insertarCampos(new ImagenPlataforma(),$request);

        $mensaje = ['Se guardó correctamente',
                    'Se encontraron problemas al guardar'];

        $resultado = HerramientaStidsController::ejecutarSaveArreglo($clase,$mensaje);

        if ($resultado['resultado'] == 1) {

            $archivo    = $request->file('imagen');
            $directorio = public_path('../../recursos/imagenes/') . TipoImagen::consultarCarpetaPorId($request->get('id_tipo_imagen'));

            if ($archivo->move($directorio, "{$resultado['id']}.png")) {
                return response()->json(array(
                    'resultado' => 1,
                    'mensaje' => $resultado['mensaje'],
                    'id' => $resultado['id'],
                ));
            } else {

                ImagenPlataforma::eliminarPorId($resultado['id']);

                return response()->json(array(
                    'resultado' => 0,
                    'mensaje' => 'Se encontraron problemas al cargar el archivo',
                ));
            }
        }
        else {

            return $resultado;
        }
    }


    public function Actualizar(Request $request)
    {
        if ($this->verificacion($request))
            return $this->verificacion($request);


        $clase = $this->insertarCampos(ImagenPlataforma::Find((int)$request->get('id')),$request);

        $mensaje = ['Se actualizó correctamente',
            'Se encontraron problemas al actualizar'];

        return HerramientaStidsController::ejecutarSaveArreglo($clase,$mensaje);
    }

    public function Eliminar($request)
    {
        $directorio = public_path('../../recursos/imagenes/') . TipoImagen::consultarCarpetaPorId($request->get('id_tipo_imagen'));
        $archivo = "$directorio/" . $request->get('id') . '.png';

        if (file_exists($archivo)) {
            if (!unlink($archivo)) {
                return response()->json(array(
                    'resultado' => 0,
                    'mensaje' => 'Se encontraron problemas al eliminar la imagen',
                ));
            }
        }

        return ImagenPlataforma::eliminarPorId($request->get('id'));
    }


    private function insertarCampos($clase,$request) {

        $clase->id_empresa          = $request->session()->get('idEmpresa');
        $clase->id_tipo_imagen      = $request->get('id_tipo_imagen');
        $clase->titulo              = $request->get('titulo');
        $clase->descripcion         = $request->get('descripcion');
        $clase->nombre_boton        = $request->get('nombre_boton');
        $clase->enlace              = $request->get('enlace');
        $clase->posicion_horizontal = $request->get('posicion_horizontal');
        $clase->posicion_vertical   = $request->get('posicion_vertical');

        return $clase;
    }


    public function verificacion($request){

        if (!$request->get('id')) {

            $campos = array(
                'imagen' => 'Debe seleccionar una imagen para continuar',
            );

            foreach ($campos as $campo => $mensaje) {

                $resultado = HerramientaStidsController::verificacionCampos($request,$campo,$mensaje);

                if ($resultado) {
                    return $resultado;
                }
            }
        }
    }
}