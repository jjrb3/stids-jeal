<?php

use Illuminate\Database\Seeder;

class s_usuario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$opciones = ['cost' => 13];

        DB::table('s_usuario')->insert(array(
		   'id' => 1,
		   'id_empresa' => 1,
		   'id_tipo_identificacion' => 1,
		   'id_rol' => 1,
		   'id_municipio' => 1,
		   'id_sexo' => 1,
		   'usuario' => 'jeremy.reyes',
		   'clave' => password_hash("Jeremy.Reyes", PASSWORD_BCRYPT, $opciones),
		   'no_documento' => '1.140.830.649',
		   'nombres' => 'Jeremy José',
		   'apellidos' => 'Reyes Barrios',
		   'correo' => 'jeremy.reyes@stids.net',
		   'fecha_nacimiento' => '1990-06-08',
		   'telefono' => NULL,
		   'celular' => '(+57) 301 759 7689',
		   'estado' => 1,
		));
        DB::table('s_usuario')->insert(array(
		   'id' => 2,
		   'id_empresa' => 1,
		   'id_tipo_identificacion' => 1,
		   'id_rol' => 3,
		   'id_municipio' => 1,
		   'id_sexo' => 1,
		   'usuario' => 'alvaro.perez',
		   'clave' => password_hash("Alvaro.Perez", PASSWORD_BCRYPT, $opciones),
		   'no_documento' => '1.143.144.245',
		   'nombres' => 'Alvaro Enrrique',
		   'apellidos' => 'Pérez Malo',
		   'correo' => 'alvaro.perez@stids.net',
		   'fecha_nacimiento' => NULL,
		   'telefono' => NULL,
		   'celular' => '(+57) 301 495 4136',
		   'estado' => 1,
		));
        DB::table('s_usuario')->insert(array(
		   'id' => 3,
		   'id_empresa' => 1,
		   'id_tipo_identificacion' => 1,
		   'id_rol' => 3,
		   'id_municipio' => 1,
		   'id_sexo' => 1,
		   'usuario' => 'victor.parodi',
		   'clave' => password_hash("Victor.Parodi", PASSWORD_BCRYPT, $opciones),
		   'no_documento' => '1.118.813.831',
		   'nombres' => 'Víctor Mario',
		   'apellidos' => 'Parodi Montero',
		   'correo' => 'victor.parodi@stids.net',
		   'fecha_nacimiento' => NULL,
		   'telefono' => NULL,
		   'celular' => '(+57) 318 570 4494',
		   'estado' => 1,
		));
    }
}
