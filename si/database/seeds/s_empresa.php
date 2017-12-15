<?php

use Illuminate\Database\Seeder;

class s_empresa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_empresa')->insert(array(
		   'id' => 1,
		   'id_tema' => 1,
		   'nit' => '1',
		   'nombre_cabecera' => 'Stids Jeal',
		   'nombre' => 'Stids',
           'frase' => 'Desarrollando tus sueños',
		   'imagen_logo' => 'predeterminado.png',
		   'estado' => 1,
		));
    }
}
