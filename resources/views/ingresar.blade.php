@extends('temas.'.$empresa['nombre_logueo'])

@section('meta-seo')
    <meta name="keywords" content="Stids Jeal, ingresar a Stids Jeal, login" />
    <meta name="description" content="Ingresar a la plataforma Stids Jeal. Sistema de Información creado por Stids para facilitar los procesos de configuración y administración de los datos para las empresas..">
@endsection

@section('content')

	<!-- Login -->
 	<div class="dentrodelcontainer">
		<div class="container">
			<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			  	<div class="panel panel-success">
					<div class="panel-heading" align="center">
						<a href="inicio">
							<img src="temas/{{$empresa['tema_nombre']}}/img/icono.png">
						</a>
					</div>
					<div class="panel-body">
						<div class="form-group">
				  			<label>
								<i class="fa fa-user size-16" aria-hidden="true"></i> Usuario
				  			</label>
				  			<input type="text" class="form-control" id="usuario" placeholder="Ingresar usuario" maxlength="30" onkeyup="Api.Ingresar.enter(event)">
						</div>
						<div class="form-group">
				  			<label>
								<i class="fa fa-key size-16" aria-hidden="true"></i> Contraseña
				  			</label>
							<div class="input-group" id="grupo-clave">
								<input type="password" class="form-control" id="clave" placeholder="Ingresar contraseña" maxlength="30" onkeyup="Api.Ingresar.enter(event)">
								<span class="input-group-addon apuntar" onclick="Api.Herramientas.mostrarInput('#grupo-clave',true)">
									<i class="fa fa-eye size-20" aria-hidden="true"></i>
								</span>
							</div>
						</div>
						<div class="form-group ocultar" id="contenedor-empresa">
				  			<label>
								<i class="fa fa-building-o size-16" aria-hidden="true"></i> Empresa
				  			</label>
							<select class="form-control" id="id-empresa">
								<option value="">Seleccione...</option>
							</select>
						</div>
						<div>
							<input type="checkbox" id="recordar-ingreso"> Recuerdame
						</div>
				  		<button type="submit" name="login" class="btn btn-success btn-block" onclick="Api.Ingresar.ingresar()">
				  			<span class="glyphicon glyphicon-off"></span> Ingresar
				  		</button>
			  			<br>
			  			<div id="mensaje"></div>
			   			<div class="form-group" align="center">
							<a href="#">
								Quiero recuperar mi contraseña
							</a>
				 		</div>
					</div>
		  		</div>
		  	</div>
		</div>
	</div>
	<!-- Fin login -->

	<input type="hidden" id="rutaImagen" value="{{$empresa['tema_nombre']}}">

	<!-- Stids -->
	<script type="text/javascript" src="{{asset('js/stids/api.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/stids/ajax.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/stids/mensajes.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/stids/herramientasRapidas.js')}}"></script>

	<script type="text/javascript" src="{{asset('js/ingresar.js')}}"></script>


@endsection