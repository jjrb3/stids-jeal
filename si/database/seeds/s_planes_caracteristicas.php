<?php

use Illuminate\Database\Seeder;

class s_planes_caracteristicas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Básico
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 1,
		   'titulo' => '4',
		   'descripcion' => 'Enlaces',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 1,
		   'titulo' => 'N°.',
		   'descripcion' => 'Imagenes estáticas',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 1,
		   'titulo' => '7',
		   'descripcion' => 'Correos Corporativos',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 1,
		   'titulo' => 'Diseño',
		   'descripcion' => 'Responsive',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 1,
		   'titulo' => 'Soporte',
		   'descripcion' => '5 días',
		));

    	// Estándar
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 2,
		   'titulo' => '6',
		   'descripcion' => 'Enlaces',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 2,
		   'titulo' => 'N°.',
		   'descripcion' => 'Imagenes rotativas',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 2,
		   'titulo' => '10',
		   'descripcion' => 'Correos Corporativos',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 2,
		   'titulo' => 'Diseño',
		   'descripcion' => 'Responsive',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 2,
		   'titulo' => 'Soporte',
		   'descripcion' => '5 días',
		));

    	// Avanzado
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 3,
		   'titulo' => '8',
		   'descripcion' => 'Enlaces + panel administrativo',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 3,
		   'titulo' => 'N°.',
		   'descripcion' => 'Cambio de imagenes + información',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 3,
		   'titulo' => '15',
		   'descripcion' => 'Correos Corporativos',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 3,
		   'titulo' => 'Diseño',
		   'descripcion' => 'Responsive + filtros',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 3,
		   'titulo' => 'Soporte',
		   'descripcion' => '10 días',
		));

    	// Pro
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 4,
		   'titulo' => '8',
		   'descripcion' => 'Enlaces + panel administrativo',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 4,
		   'titulo' => 'N°.',
		   'descripcion' => 'Imagenes + cambio de información',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 4,
		   'titulo' => '20',
		   'descripcion' => 'Correos Corporativos',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 4,
		   'titulo' => 'Diseño',
		   'descripcion' => 'Responsive + efectos ultimate',
		));
        DB::table('s_planes_caracteristicas')->insert(array(
		   'id' => NULL,
		   'id_planes' => 4,
		   'titulo' => 'Soporte',
		   'descripcion' => '15 días',
		));
    }
}
