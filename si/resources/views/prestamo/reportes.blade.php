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
                @php($pExportar = false)
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
                            @php($pExportar = true)
                    @elseif($permiso['id_permiso'] == 6)
                        <button type="button" class="btn btn-info" title="Importar archivo"><i class="fa fa-cloud-upload"></i></button>
                    @endif

                    @php($cnt++)
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <br>
        <div class="col-lg-12" id="mensaje"></div>

        <div class="col-lg-4" id="contenedor-prestamos-finalizados">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-pdf-o fa-1x azul"></i> &nbsp;Prestamos finalizados</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <div class="row">
                        <form id="form-prestamos-finalizados" method=POST action="reportes" onsubmit="return Api.Reportes.prestamosFinalizados();" target="_blank">
                            {{ csrf_field() }}
                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reportes">
                            <input type="hidden" name="carpetaControlador" value="Prestamo">
                            <input type="hidden" name="funcionesVariables" value="PrestamosFinalizados">
                            <div class="col-lg-12">
                                Reporte de prestamos finalizados por rango de fecha.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="col-lg-6">
                                    <label>Fecha Inicial</label>
                                </div>
                                <div class="col-lg-5">
                                    <label>Fecha Final</label>
                                </div>
                                <div class="rangedatepicker input-group col-lg-10" id="datepicker" align="center">
                                    <input type="text" class="form-control fecha-inicio" name="fecha_inicio" id="fecha-inicio">
                                    <span class="input-group-addon">a</span>
                                    <input type="text" class="form-control fecha-fin" name="fecha_fin" id="fecha-fin">
                                </div>
                            </div>
                            <br>
                            @if($pExportar)
                                <div class="text-center">
                                    <button class="btn btn-info">
                                        <i class="fa fa-cloud-download"></i>
                                        &nbsp;
                                        Generar Reporte
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="contenedor-relacion-prestamo">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-pdf-o fa-1x azul"></i> &nbsp;Relación de Prestamo</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <div class="row">
                        <form id="form-relacion-prestamo" method=POST action="reportes" onsubmit="return Api.Reportes.relacionPrestamo();" target="_blank">
                            {{ csrf_field() }}
                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reportes">
                            <input type="hidden" name="carpetaControlador" value="Prestamo">
                            <input type="hidden" name="funcionesVariables" value="RelacionPrestamo">
                            <div class="col-lg-12">
                                Reporte de relación de prestamo por rango de fecha.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="col-lg-6">
                                    <label>Fecha Inicial</label>
                                </div>
                                <div class="col-lg-5">
                                    <label>Fecha Final</label>
                                </div>
                                <div class="rangedatepicker input-group col-lg-10" id="datepicker" align="center">
                                    <input type="text" class="form-control fecha-inicio" name="fecha_inicio" id="fecha-inicio">
                                    <span class="input-group-addon">a</span>
                                    <input type="text" class="form-control fecha-fin" name="fecha_fin" id="fecha-fin">
                                </div>
                            </div>
                            <br>
                            @if($pExportar)
                                <div class="text-center">
                                    <button class="btn btn-info">
                                        <i class="fa fa-cloud-download"></i>
                                        &nbsp;
                                        Generar Reporte
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="contenedor-prestamo-sin-completar">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-pdf-o fa-1x azul"></i> &nbsp;Prestamos sin completar</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <div class="row">
                        <form id="form-prestamos-sin-completar" method=POST action="reportes" onsubmit="return Api.Reportes.prestamosSinCompletar();" target="_blank">
                            {{ csrf_field() }}
                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reportes">
                            <input type="hidden" name="carpetaControlador" value="Prestamo">
                            <input type="hidden" name="funcionesVariables" value="PrestamosSinCompletar">
                            <div class="col-lg-12">
                                Reporte de prestamos que no han sido completados por rango de fecha.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="col-lg-6">
                                    <label>Fecha Inicial</label>
                                </div>
                                <div class="col-lg-5">
                                    <label>Fecha Final</label>
                                </div>
                                <div class="rangedatepicker input-group col-lg-10" id="datepicker" align="center">
                                    <input type="text" class="form-control fecha-inicio" name="fecha_inicio" id="fecha-inicio">
                                    <span class="input-group-addon">a</span>
                                    <input type="text" class="form-control fecha-fin" name="fecha_fin" id="fecha-fin">
                                </div>
                            </div>
                            <br>
                            @if($pExportar)
                                <div class="text-center">
                                    <button class="btn btn-info">
                                        <i class="fa fa-cloud-download"></i>
                                        &nbsp;
                                        Generar Reporte
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="contenedor-recaudo-diario">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-pdf-o fa-1x azul"></i> &nbsp;Recaudo Diario</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <div class="row">
                        <form id="form-recaudo-diario" method=POST action="reportes" onsubmit="return Api.Reportes.recaudoDiario();" target="_blank">
                            {{ csrf_field() }}
                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reportes">
                            <input type="hidden" name="carpetaControlador" value="Prestamo">
                            <input type="hidden" name="funcionesVariables" value="RecaudoDiario">
                            <div class="col-lg-12">
                                Reporte de Recaudo por día.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="form-group w200">
                                    <label>Fecha:</label>
                                    <input type="text" class="form-control datepicker" id="fecha" name="fecha">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                @if($pExportar)
                                    <div class="text-center">
                                        <button class="btn btn-info">
                                            <i class="fa fa-cloud-download"></i>
                                            &nbsp;
                                            Generar Reporte
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <br>
            <br>
            <div class="footer">
                <div class="pull-right">
                    <strong>Copyright </strong> Stids Jeal &copy; 2017
                </div>
            </div>
        </div>
    </div>
    <!-- Fin contenido de la pagina -->

@endsection

@section('script')
    <script>var globalPermisos = [{{$idsPermiso}}]</script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/reportes.js')}}"></script>
    <script>_verificarPermisos()</script>
@endsection