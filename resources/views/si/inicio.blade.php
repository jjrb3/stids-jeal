@extends('temas.'.$empresa['nombre_administrador'])

@section('content')
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <h2 style="font-weight: 500;">Bievenidos a Stids Jeal</h2>
            <small>Stids Jeal es un Sistema de Información creado por Stids para facilitar los procesos de configuración y administración de los datos para las empresas. ¡Esperamos que sea de su agrado!  :)</small>
        </div>
    </div>

    <!-- Contenido de accesos -->
	<div id="bloque-de-etiquetas" class="row ocultar">
        <div class="col-lg-12">
            <div id="etiquetas" class="wrapper wrapper-content">
                <div class="col-lg-12">

                </div>
            </div>
        </div>
    </div>
    <!-- Fin contenido de accesos -->

    <!-- Contenido de graficas -->
    <div id="bloque-de-graficas" class="row ocultar">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div id="bloque-grafica-usuario-transaccion" class="col-lg-8 ocultar">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>
                                <i class="fa fa-area-chart"></i>
                                Transacciones de usuarios
                            </h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content inspinia-timeline" style="display: block;">
                            <div class="timeline-item">
                                <div class="row">
                                    <canvas id="grafica-usuario-transacciones" height="120" width="450" style="display: block; width: 466px; height: 217px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="bloque-grafica-usuario-total" class="col-lg-4 ocultar">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>
                                <i class="fa fa-pie-chart"></i>
                                Total de usuarios
                            </h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content inspinia-timeline" style="display: block;">
                            <div class="timeline-item">
                                <div class="row">
                                    <canvas id="grafica-usuario-total" height="265" style="display: block; width: 466px; height: 217px;" width="466"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin de contenido de graficas -->

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/graficas/parametrizacion/usuario.js')}}"></script>

    <script>

        Api.consultarDashboard();

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