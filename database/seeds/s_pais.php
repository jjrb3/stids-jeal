<?php

use Illuminate\Database\Seeder;

class s_pais extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_pais')->insert(array(
           'id' => 1,
           'nombre' => 'Colombia',
    	));
    }
}
