@extends('temas.'.$empresa['nombre_administrador'])

@section('content')
    <input type="hidden" id="rutaImagen" value="../../temas/{{$empresa['tema_nombre']}}">
	<div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <h2 style="font-weight: 500;">Bievenidos a Stids Jeal</h2>
            <small>Stids Jeal es un Sistema de Información creado por Stids para facilitar los procesos de configuración y administración de los datos para las empresas. ¡Esperamos que sea de su agrado!  :)</small>
        </div>
    </div>

	<div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                @php($cnt = 0)
                @if($menuAdministrador['menu'])
                    @foreach($menuAdministrador['menu'] as $listaMenu)
                        @php($cnt++)
                        @if($cnt == 1)
                            <div class="col-lg-12">
                        @endif
                        <div class="col-lg-3">
                            <a href="{{$listaMenu['enlace_administrador']}}?padre={{$listaMenu['id']}}" class="etiqueta">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <center><i class="fa {{$listaMenu['icono']}} fa-2x"></i></center>
                                    </div>
                                    <div class="ibox-content ibox-heading">
                                        <center>
                                            <span>
                                                <h3>{{$listaMenu['nombre']}}</h3>
                                                <small>{{$listaMenu['descripcion']}}</small>                                
                                            </span>
                                        </center>
                                    </div>
                                    <div class="ibox-content inspinia-timeline"></div> 
                                </div>
                                <br>
                                <br>
                            </a>
                        </div>
                        @if($cnt == 4)
                            </div>
                            @php($cnt=0)
                        @endif
                    @endforeach
                @endif                   

                </div>
                <div class="footer">
                    <div class="pull-right">
                        <strong>Copyright </strong> Stids S.A.S &copy; 2016
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin contenido de la pagina -->        
    </div>
@endsection

@section('script') 
<script>
    $(document).ready(function() {
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.success('Puede disfrutar de las opciones que ofrece la plataforma', 'Bienvenido a Stids Jeal');

        }, 1300);
    });
</script>
@endsection