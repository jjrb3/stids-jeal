<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    public $timestamps = false;
    protected $table = "s_permiso";


	public static function consultarTodosLosPermisos() {
		try {
	        return Permiso::orderBy('nombre')
	        			->get();
	    } catch (Exception $e) {
            return array();
        } 
    }
}