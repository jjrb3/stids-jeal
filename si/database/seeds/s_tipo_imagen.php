<?php

use Illuminate\Database\Seeder;

class s_tipo_imagen extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_tipo_imagen')->insert(array(
		   'id' => 1,
		   'nombre' => 'Slider',
            'carpeta' => 'slider',
		   'descripcion' => 'Slider que aparece en la pagina principal',
		   'estado' => 1,
		));
        DB::table('s_tipo_imagen')->insert(array(
		   'id' => 2,
		   'nombre' => 'Herramientas',
            'carpeta' => 'herramientas',
		   'descripcion' => 'Herramientas de la empresa',
		   'estado' => 1,
		));
        DB::table('s_tipo_imagen')->insert(array(
		   'id' => 3,
		   'nombre' => 'Servicios',
            'carpeta' => 'servicios',
		   'descripcion' => 'Servicios de la empresa',
		   'estado' => 1,
		));
        DB::table('s_tipo_imagen')->insert(array(
		   'id' => 4,
		   'nombre' => 'Clientes',
            'carpeta' => 'clientes',
		   'descripcion' => 'Clientes de la empresa',
		   'estado' => 1,
		));
        DB::table('s_tipo_imagen')->insert(array(
		   'id' => 5,
		   'nombre' => 'Portafolio',
            'carpeta' => 'portafolio',
		   'descripcion' => 'Portafolio de la empresa',
		   'estado' => 1,
		));
    }
}
