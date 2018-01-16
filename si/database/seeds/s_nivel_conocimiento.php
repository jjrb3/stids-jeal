<?php

use Illuminate\Database\Seeder;

class s_nivel_conocimiento extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_nivel_conocimiento')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Laravel',
		   'color' => '#d9534f',
		   'porcentaje' => 93.0,
		));
        DB::table('s_nivel_conocimiento')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Prestashop',
		   'color' => '#428bca',
		   'porcentaje' => 80.0,
		));
        DB::table('s_nivel_conocimiento')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Symfony',
		   'color' => '#5bc0de',
		   'porcentaje' => 90.0,
		));
        DB::table('s_nivel_conocimiento')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Boostrap',
		   'color' => '#5cb85c',
		   'porcentaje' => 91.0,
		));
        DB::table('s_nivel_conocimiento')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'JQuery',
		   'color' => '#f0ad4e',
		   'porcentaje' => 95.0,
		));
        DB::table('s_nivel_conocimiento')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Photoshop',
		   'color' => '#B088BA',
		   'porcentaje' => 88.0,
		));
        DB::table('s_nivel_conocimiento')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'MySQL',
		   'color' => '#B3CE84',
		   'porcentaje' => 91.0,
		));
        DB::table('s_nivel_conocimiento')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'SQL Server',
		   'color' => '#79EED6',
		   'porcentaje' => 96.0,
		));
    }
}
