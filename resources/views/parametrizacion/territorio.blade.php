@extends('temas.'.$empresa['nombre_administrador'])

@section('content')
    @php($idPadre = $_REQUEST['padre'])
    @php($idHijo = $_REQUEST['hijo'])
    <input type="hidden" id="idPadre" value="{{$idPadre}}">
    <input type="hidden" id="idHijo" value="{{$idHijo}}">

    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-8">
            <h2 style="font-weight: 500;">{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['nombre']}}</h2>
            <small>{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['descripcion']}}</small>
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
            <div class="float-right">
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
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de Países</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if($op->guardar)
                                                <div class="form-group">
                                                    <label>País.</label>
                                                    <input type="text"
                                                           id="pais-nombre"
                                                           class="form-control"
                                                           placeholder="Digite el nombre para crear"
                                                           onkeypress="Api.Territorio.Pais.guardarActualizar(event)"
                                                           maxlength="50"
                                                    >
                                                </div>
                                                <br>
                                            @endif
                                        </div>
                                        <div class="col-lg-12" id="pais-mensaje"></div>
                                        <div class="col-lg-12" id="pais-tabla"></div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de Departamentos</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="mensajeDepartamento"></div>
                                        </div>
                                        <div class="col-lg-12">
                                            @if($op->guardar)
                                                <div class="form-group">
                                                    <label>Departamento.</label>
                                                    <input type="text"
                                                           id="departamento-nombre"
                                                           class="form-control"
                                                           placeholder="Digite el nombre para crear"
                                                           onkeypress="Api.Territorio.Departamento.guardarActualizar(event)"
                                                           maxlength="50"
                                                    >
                                                </div>
                                                <br>
                                            @endif
                                        </div>                                                                         
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12" id="departamento-mensaje"></div>
                                        <div class="col-lg-12" id="departamento-tabla"></div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de Municipio</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="mensajeMunicipio"></div>
                                        </div>
                                        <div class="col-lg-12">
                                            @if($op->guardar)
                                                <div class="form-group">
                                                    <label>Municipio.</label>
                                                    <input type="text"
                                                           id="municipio-nombre"
                                                           class="form-control"
                                                           placeholder="Digite el nombre para crear"
                                                           onkeypress="Api.Territorio.Municipio.guardarActualizar(event)"
                                                           maxlength="50"
                                                    >
                                                </div>
                                                <br>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12" id="municipio-mensaje"></div>
                                        <div class="col-lg-12" id="municipio-tabla"></div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>
                </div>


                </div>
                <div class="footer">
                    <div class="pull-right">
                        <strong>Copyright </strong> Stids Jeal &copy; 2017
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin contenido de la pagina -->

        
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/parametrizacion/territorio.js')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Territorio.constructor();
    </script>
@endsection