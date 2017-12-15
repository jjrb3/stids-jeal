<?php

use Illuminate\Database\Seeder;

class s_sexo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_sexo')->insert(array(
           'id' => 1,
           'nombre' => 'Masculino',
           'estado' => 1,
    	));
    	DB::table('s_sexo')->insert(array(
           'id' => 2,
           'nombre' => 'Femenino',
           'estado' => 1,
    	));
    }
}
