@extends('temas.'.$empresa['nombre_administrador'])

@section('content') 
    @php($idPadre = $_REQUEST['padre'])
    @php($idHijo = $_REQUEST['hijo'])
    <input type="hidden" id="rutaImagen" value="../../../temas/{{$empresa['tema_nombre']}}">
    <input type="hidden" id="idPadre" value="{{$idPadre}}">
    <input type="hidden" id="idHijo" value="{{$idHijo}}">

    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <h2 style="font-weight: 500;">{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['nombre']}}</h2>
            <small>{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['descripcion']}}</small>
            <div style="float:right;">
                @php($cnt = 0)
                @php($idsPermiso = '')
                @php($permisoGuardar = false)
                @foreach($permisos as $permiso)
                    @if($cnt>0)
                        @php($idsPermiso .= ',' . $permiso['id_permiso'])
                    @else
                        @php($idsPermiso .= $permiso['id_permiso'])
                    @endif

                    @if($permiso['id_permiso'] == 1)
                        <button type="button" class="btn btn-primary" title="Crear"><i class="fa fa-floppy-o"></i></button>
                        @php($permisoGuardar = true)
                    @elseif($permiso['id_permiso'] == 2)
                        <button type="button" class="btn btn-success" title="Rapida actualización"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-success" title="Actualizar"><i class="fa fa-pencil-square-o"></i></button>
                    @elseif($permiso['id_permiso'] == 3)
                        <button type="button" class="btn btn-warning" title="Activar y desactivar"><i class="fa fa-toggle-on"></i></button>
                    @elseif($permiso['id_permiso'] == 4)
                        <button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
                    @elseif($permiso['id_permiso'] == 5)
                        <button type="button" class="btn btn-info" title="Exportar archivo"><i class="fa fa-cloud-download"></i></button>
                    @elseif($permiso['id_permiso'] == 6)
                        <button type="button" class="btn btn-info" title="Importar archivo"><i class="fa fa-cloud-upload"></i></button>
                    @endif

                    @php($cnt++)
                @endforeach  
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
                                        <div id="mensaje"></div>
                                        <div class="col-lg-12">
                                            @if($permisoGuardar == true)
                                                <input type="text" id="nombre" class="form-control" placeholder="Digite el nombre para crear" onkeypress="enterPais(event)">
                                                <br>
                                            @endif
                                        </div>
                                        <div id='tablaPais'></div>
                                        <div id='paginacionPais'></div>
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
                                            @if($permisoGuardar == true)
                                                <input type="text" id="nombreDepartamento" class="form-control" placeholder="Digite el nombre para crear" onkeypress="enterDepartamento(event)">
                                                <input type="hidden" id="id_pais" value="">
                                                <br>
                                            @endif
                                        </div>                                                                         
                                    </div>
                                    <div class="row">
                                        <div id='tablaDepartamento'></div>
                                        <div id='paginacionDepartamento'></div>
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
                                            @if($permisoGuardar == true)
                                                <input type="text" id="nombreMunicipio" class="form-control" placeholder="Digite el nombre para crear" onkeypress="enterMunicipio(event)">
                                                <input type="hidden" id="id_departamento" value="">
                                                <br>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id='tablaMunicipio'></div>
                                        <div id='paginacionMunicipio'></div>
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
    <script>var globalPermisos = [{{$idsPermiso}}]</script>
    <script type="text/javascript" src="{{asset('js/si/parametrizacion/territorio.js')}}"></script>
    <script>listado();</script>
@endsection