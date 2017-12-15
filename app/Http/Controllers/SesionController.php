<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Models\Parametrizacion\Usuario;
use App\Models\Parametrizacion\Empresa;

class SesionController extends Controller
{
    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-13 - 03:13 PM
     *
     * Cierra sesión y elimina la cookie del usuario en la pagina.
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return cookie: Cookie eliminadas
     */
    public function CerrarSesion(Request $request)
    {
        $request->session()->flush();

        $cookie = \Cookie::forget('codigo_ingreso');

        return redirect('/ingresar')
            ->cookie($cookie);
    }


    public function VerificarUsuario(Request $request)
    {
        if (!$request->get('usuario')) {
            return response()->json(array(
                'resultado' => 0,
                'mensaje' => 'Debe ingresar el campo usuario para continuar',
            ));
        }

        if (!trim($request->get('clave'))) {
            return response()->json(array(
                'resultado' => 0,
                'mensaje' => 'Debe ingresar el campo contraseña para continuar',
            ));
        }

        try {

            $idEmpresa = $request->get('id_empresa');

            if (!$idEmpresa) {

                $empresa = Empresa::consultarPorUsuarioActivo($request->get('usuario'));

                if ($empresa->count() > 1) {

                    return response()->json([
                            'resultado' => 2,
                            'mensaje' => 'Seleccine la empresa a la cual desea ingresar',
                            'empresas' => $empresa,
                        ]
                    );

                } else {

                    $idEmpresa = $empresa[0]->id;
                }
            }


            $usuario = Usuario::consultarPorUsuarioEmpresa($request->get('usuario'),$idEmpresa);


            if ($usuario) {

                if (password_verify($request->get('clave'), $usuario->clave)) {


                    $request->session()->put('idEmpresa', $usuario->id_empresa);
                    $request->session()->put('idUsuario', $usuario->id);
                    $request->session()->put('idRol', $usuario->id_rol);
                    $request->session()->put('nombres', $usuario->nombres . ' ' . $usuario->apellidos);
                    $request->session()->put('cambioEmpresa',false);

                    if ($request->get('recordar')) {

                        $cookie = $this->GenerarCookie($usuario->clave, $usuario->id);

                        return response()->json(
                            array(
                                'resultado' => 1,
                                'mensaje' => 'Espere mientras es redirigido'
                            )
                        )->cookie($cookie);
                    }
                    else {
                        return response()->json(array(
                            'resultado' => 1,
                            'mensaje' => 'Espere mientras es redirigido',
                        ));
                    }
                } else {
                    return response()->json(array(
                        'resultado' => 0,
                        'mensaje' => 'El usuario o clave no es correcto, vuelva a intentarlo',
                    ));
                }
            }
            else{
                return response()->json(array(
                    'resultado' => 0,
                    'mensaje' => 'El usuario no fue encontrado en la empresa seleccionada',
                ));
            }
        } catch (Exception $e) {
            return response()->json(array(
                'resultado' => -2,
                'mensaje' => 'Grave error: ' . $e,
            ));
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-13 - 03:13 PM
     * @see: 1. HerramientaStidsController::generarCadenaAlfanumerica.
     *
     * Generar una Cookie de identificacion para el usario.
     *
     * @param string    $clave: Clave del usuario registrado.
     * @param integer   $id:    Id del usuario registrado.
     *
     * @return cookie: Cookie
     */
    public function GenerarCookie($clave,$id) {

        $duracion       =  60 * 24 * 365;
        $claveCookie    = "{$clave}~s{$id}j~" . HerramientaStidsController::generarCadenaAlfanumerica(50);
        $cookieCodigo   =  $cookie = cookie('codigo_ingreso',$claveCookie,$duracion);             // 1 año

        return $cookieCodigo;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-13 - 03:29 PM
     *
     * Si el usuario escodió recuerdame de opcion y esta guardado en la cookie entonces inicia las sesiones.
     *
     * @param array     $request:   Peticiones realizadas.
     *
     * @return boolean: Resultado de la iniciacion de sesiones
     */
    public function IniciarSesionPorCookie($request) {

        $cookie = $request->cookie('codigo_ingreso');

        if (!(strpos($cookie, '~s') === false || strpos($cookie, 'j~') === false)) {

            $idUsuario = array_filter(explode('j~',array_filter(explode('~s',$cookie))[1]))[0];

            $usuario = Usuario::Find($idUsuario);

            if ($usuario->estado == 1) {

                $request->session()->put('idEmpresa', $usuario->id_empresa);
                $request->session()->put('idUsuario', $usuario->id);
                $request->session()->put('idRol', $usuario->id_rol);
                $request->session()->put('nombres', $usuario->nombres . ' ' . $usuario->apellidos);
                $request->session()->put('cambioEmpresa',false);

                return true;
            }
            else {
                return false;
            }
        }


        return false;
    }
}
