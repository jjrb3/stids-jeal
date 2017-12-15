@extends('temas.'.$empresa['nombre_administrador'])

@section('content')	
	@php($idPadre = $_REQUEST['padre'])
    <input type="hidden" id="idPadre" value="{{$idPadre}}">
    <input type="hidden" id="rutaImagen" value="../../../temas/{{$empresa['tema_nombre']}}">
	<div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <h2 style="font-weight: 500;">{{$menuAdministrador['menu'][$idPadre]['nombre']}}</h2>
            <small>{{$menuAdministrador['menu'][$idPadre]['descripcion']}}</small>
        </div>
    </div>

	<div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                @if($menuAdministrador['menu'][$idPadre])
                    @php($cnt = 0)
                    @foreach($menuAdministrador['menu'][$idPadre]['submenu'] as $listaMenu)
                        @php($cnt++)
                        @if($cnt == 1)
                            <div class="col-lg-12">
                        @endif
                        <div class="col-lg-3">
                            <a href="{{$menuAdministrador['ruta']}}{{$listaMenu['enlace_administrador']}}?padre={{$idPadre}}&hijo={{$listaMenu['id']}}" class="etiqueta">
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