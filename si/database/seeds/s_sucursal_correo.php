<?php

use Illuminate\Database\Seeder;

class s_sucursal_correo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_sucursal_correo')->insert(array(
           'id' => NULL,
           'id_sucursal' => 1,
           'corre' => 'jeremy.reyes@stids.net',
    	));
        DB::table('s_sucursal_correo')->insert(array(
           'id' => NULL,
           'id_sucursal' => 1,
           'corre' => 'alvaro.perez@stids.net',
    	));
    }
}
