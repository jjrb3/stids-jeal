@extends('temas.'.$empresa['nombre_administrador'])

@section('content') 
    
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-lg-12">
            <div class="text-center animated fadeInDown">
                <h1>500</h1>
                <h3 class="font-bold">Error interno del servidor</h3>

                <div class="error-desc">
                    El servidor encontró problemas para la pagina solicitada por la cual no se puede acceder por el momento. <br>
                    Le pedimos disculpas. Puede volver a la pagina principal: <br><a href="../inicio" class="btn btn-primary m-t">Inicio Stids Jeal</a>
                </div>
            </div>
        </div>
    </div>

@endsection
