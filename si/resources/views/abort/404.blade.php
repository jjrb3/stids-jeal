@extends('temas.'.$empresa['nombre_administrador'])

@section('content') 
    
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-lg-12">
            <div class="text-center animated fadeInDown">
                <h1>404</h1>
                <h3 class="font-bold">Pagina no existe</h3>

                <div class="error-desc">
                    Lo sentimos, la pagina que esta buscando no fue encontrada. <br>
                    Puede volver a la pagina principal: <br><a href="../inicio" class="btn btn-primary m-t">Inicio Stids Jeal</a>
                </div>
            </div>
        </div>
    </div>

@endsection
