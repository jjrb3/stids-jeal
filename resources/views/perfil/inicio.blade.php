@extends('temas.'.$empresa['nombre_administrador'])

@section('content')
    @php($idPadre = $_REQUEST['padre'])
    <input type="hidden" id="idPadre" value="{{$idPadre}}">
    <input type="hidden" id="rutaImagen" value="../../../temas/{{$empresa['tema_nombre']}}">
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-8">
            <h2 style="font-weight: 500;">{{$menuAdministrador['menu'][$idPadre]['nombre']}}</h2>
            <small>{{$menuAdministrador['menu'][$idPadre]['descripcion']}}</small>
            <br><br>
            <ol class="breadcrumb">
                <li>
                    <a href="../inicio"><i class="fa fa-home"></i> Inicio</a>
                </li>
                @if(isset($navegacion['padre']))
                    @if(!isset($navegacion['hijo']))
                        <li class="active">
                            <strong>{{$navegacion['padre']['nombre']}}</strong>
                        </li>
                    @else
                        <li><a href="../{{$navegacion['padre']['enlace']}}">{{$navegacion['padre']['nombre']}}</a></li>
                    @endif
                @endif
                @if(isset($navegacion['hijo']))
                    <li class="active">
                        <strong>{{$navegacion['hijo']['nombre']}}</strong>
                    </li>
                @endif
            </ol>
        </div>
        <div class="col-sm-4">
            <div style="float:right;">
                @if($op->guardar)
                    <button type="button" class="btn btn-primary" title="Crear"><i class="fa fa-floppy-o"></i></button>
                @endif
                @if($op->actualizar)
                    <button type="button" class="btn btn-success" title="Actualizar"><i class="fa fa-pencil-square-o"></i></button>
                @endif
                @if($op->estado)
                    <button type="button" class="btn btn-warning" title="Activar y desactivar"><i class="fa fa-toggle-on"></i></button>
                @endif
                @if($op->eliminar)
                    <button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
                @endif
                @if($op->exportar)
                    <button type="button" class="btn btn-info" title="Exportar archivo"><i class="fa fa-cloud-download"></i></button>
                @endif
                @if($op->importar)
                    <button type="button" class="btn btn-info" title="Importar archivo"><i class="fa fa-cloud-upload"></i></button>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <br>
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#informacion"> Actualizar Información</a></li>
                    <li class=""><a data-toggle="tab" href="#seguridad">Seguridad</a></li>
                    <li class=""><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
                </ul>
                <div class="tab-content">
                    <div id="informacion" class="tab-pane active">
                        <div class="panel-body ">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p>
                                        Seleccione la información que desea actualizar de su perfil.
                                        <br><br>
                                    </p>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Empresa.</label>
                                        <input id="empresa" type="text" readonly="readonly" class="form-control readonly">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Tipo de identificación.</label>
                                        <input id="tipo-identificacion" type="text" readonly="readonly" class="form-control readonly">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Documento.</label>
                                        <input id="documento" type="text" readonly="readonly" class="form-control readonly">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Rol o cargo.</label>
                                        <input id="rol" type="text" readonly="readonly" class="form-control readonly">
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Nombre de usuario.</label>
                                        <input id="usuario" type="text" readonly="readonly" class="form-control readonly">
                                    </div>
                                </div>
                                <form id="formulario">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Contraseña.</label>
                                            <input type="password" id="clave" name="clave" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Nombres.</label>
                                            <input type="text" id="nombres" name="nombres" class="form-control" placeholder="Digite sus nombres" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Apellidos.</label>
                                            <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Digite sus apellidos" maxlength="100">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Sexo.</label>
                                            <select id="sexo" name="sexo" class="form-control chosen-select"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Ciudad.</label>
                                            <input type="text" id="ciudad" class="form-control autocompletar-ciudades" data-id="id-municipio" data-name="id_municipio">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Email.</label>
                                            <input type="email" id="correo" name="correo" class="form-control" maxlength="80" placeholder="Digite su dirección de Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Fecha de Nacimiento.</label>
                                            <div class="input-group">
                                                <input type="text" id="fecha-nacimiento" name="fecha_nacimiento" class="form-control datepicker" maxlength="10" placeholder="AAAA-MM-DD">
                                                <span class="input-group-addon icono-calendario"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Teléfono.</label>
                                            <input type="text" id="telefono" name="telefono" class="form-control" maxlength="50" placeholder="Digite su numero telefónico">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Celular.</label>
                                            <input type="text" id="celular" name="celular" class="form-control formato-celular"  maxlength="10">
                                        </div>
                                    </div>
                                    @if($op->actualizar)
                                        <div class="col-lg-12">
                                            <button id="botonActualizar" class="btn btn-success" type="button" onClick="Api.Perfil.guardar()">
                                                <i class="fa fa fa-pencil-square-o"></i>&nbsp;
                                                Actualizar
                                            </button>
                                            <br><br>
                                            <div id="mensaje"></div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="seguridad" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p>
                                        Seleccione 4 preguntas con sus respectivas respuestas para facilitar su identificación y poder habilitar la recuperación de su clave.
                                        <br><br>
                                    </p>
                                </div>

                                <div class="col-lg-6">
                                    <label>Seleccione una pregunta.</label>
                                </div>
                                <div class="col-lg-6">
                                    <label>Responda la pregunta seleccionada.</label>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select id="pregunta-1" class="form-control m-b chosen-select" onchange="Api.Seguridad.verificarSeleccion(1,this.value)" required></select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="respuesta-1" placeholder="Digite su respuesta">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select id="pregunta-2" class="form-control m-b chosen-select" onchange="Api.Seguridad.verificarSeleccion(2,this.value)" required></select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="respuesta-2" placeholder="Digite su respuesta">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select id="pregunta-3" class="form-control m-b chosen-select" onchange="Api.Seguridad.verificarSeleccion(3,this.value)" required></select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="respuesta-3" placeholder="Digite su respuesta">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select id="pregunta-4" class="form-control m-b chosen-select" onchange="Api.Seguridad.verificarSeleccion(4,this.value)" required></select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="respuesta-4" placeholder="Digite su respuesta">
                                    </div>
                                </div>

                                @if($op->guardar)
                                    <div class="col-lg-12">
                                        <button id="botonActualizar" class="btn btn-primary " type="button" onClick="Api.Seguridad.guardar()">
                                            <i class="fa fa-floppy-o"></i>&nbsp;
                                            Guardar
                                        </button>
                                        <br><br>
                                        <div id="mensaje"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="dashboard" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    Seleccione que tipo de información desea visualizar cuando ingrese al Dashboard.
                                    <br>
                                    <br>
                                </div>
                                <div class="col-lg-12" align="center">
                                    <div class="btn-group">
                                        <button id="btn-modulo" class="btn btn-white" onclick="Api.Dashboard.mostrarContenedor(1)" @if(!$op->actualizar) disabled @endif>
                                            <i class="fa fa-list-alt"></i>
                                            Módulos
                                        </button>
                                        <button id="btn-grafica" class="btn btn-white" onclick="Api.Dashboard.mostrarContenedor(2)" @if(!$op->actualizar) disabled @endif>
                                            <i class="fa fa-line-chart"></i>
                                            Gráficas
                                        </button>
                                    </div>
                                    <br>
                                    <br>
                                </div>

                                <!-- Contenedor de Módulos -->
                                <div id="modulos" class="col-lg-12 ocultar">
                                    <div class="col-lg-5">
                                        <h3 align="center">Lista de Módulos</h3>
                                        <div class="row">
                                            <div class="col-lg-12" id="tabla-modulo-1"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 vertical text-center">
                                        <div style="padding-top: 150px">
                                            <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.Dashboard.agregarModulo()">
                                                <i class="fa fa-plus verde"></i>
                                                <span class="bold">Agregar</span>
                                            </button>
                                        </div>
                                        <br>
                                        <div>
                                            <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.Dashboard.quitarModulo()">
                                                <i class="fa fa-close rojo"></i>
                                                <span class="bold">Quitar</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <h3 align="center">Módulos agregados</h3>
                                        <div class="row">
                                            <div class="col-lg-12" id="tabla-modulo-agregados"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin contenedor de Módulos -->

                                <!-- Contenedor de Gráficas -->
                                <div id="graficas" class="col-lg-12 ocultar">
                                    <div class="col-lg-5">
                                        <h3 align="center">Lista de Gráficas</h3>
                                        <div class="row">
                                            <div class="col-lg-12" id="tabla-grafica"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 vertical text-center">
                                        <div style="padding-top: 150px">
                                            <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.Dashboard.agregarGrafica()">
                                                <i class="fa fa-plus verde"></i>
                                                <span class="bold">Agregar</span>
                                            </button>
                                        </div>
                                        <br>
                                        <div>
                                            <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.Dashboard.quitarGrafica()">
                                                <i class="fa fa-close rojo"></i>
                                                <span class="bold">Quitar</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <h3 align="center">Gráficas agregadas</h3>
                                        <div class="row">
                                            <div class="col-lg-12" id="tabla-grafica-agregados"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin Contenedor de Gráficas -->

                                <div class="col-lg-12" id="mensaje"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
        </div>
    </div>
    <!-- Fin contenido de la pagina -->
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/perfil/perfil.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/perfil/seguridad.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/perfil/dashboard.js')}}"></script>
    <script>
        Api.permisos = [{{$permisos}}];
        Api.Perfil.constructor('#informacion #mensaje');
        Api.Seguridad.constructor('#seguridad #mensaje');
        Api.Dashboard.constructor('#dashboard #mensaje');
    </script>
@endsection