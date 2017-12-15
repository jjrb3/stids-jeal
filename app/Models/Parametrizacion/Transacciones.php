<?php

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Transacciones extends Model
{
    public $timestamps = false;
    protected $table = "s_transacciones";
}