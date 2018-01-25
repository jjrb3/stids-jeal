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

                <div id="bg-prestamo-total-cliente" class="col-lg-3 ocultar">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">Activos</span>
                            <h5>Clientes</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins valor-total"></h1>
                            <div class="stat-percent font-bold text-success"><i class="fa fa-bolt"></i></div>
                            <small>Total general</small>
                        </div>
                    </div>
                </div>

                <div id="bg-prestamo-total-realizados" class="col-lg-3 ocultar">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">Realizados</span>
                            <h5>Prestamos</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins valor-total"></h1>
                            <div class="stat-percent font-bold text-info"><i class="fa fa-level-up"></i></div>
                            <small>Total general</small>
                        </div>
                    </div>
                </div>

                <div id="bg-prestamo-total-completados" class="col-lg-3 ocultar">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">Completados</span>
                            <h5>Prestamos</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins valor-total"></h1>
                            <div class="stat-percent font-bold text-navy"><i class="fa fa-level-up"></i></div>
                            <small>Total general</small>
                        </div>
                    </div>
                </div>

                <div id="bg-prestamo-total-sin-completar" class="col-lg-3 ocultar">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">Sin completar</span>
                            <h5>Prestamos</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins valor-total"></h1>
                            <div class="stat-percent font-bold text-danger"><i class="fa fa-level-down"></i></div>
                            <small>Total general</small>
                        </div>
                    </div>
                </div>

                <div id="bg-prestamo-detalle-recaudo" class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Detalle general del recaudo de los prestamos</h5>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-white ocultar">Hoy</button>
                                    <button type="button" class="btn btn-xs btn-white ocultar">Semanal</button>
                                    <button type="button" class="btn btn-xs btn-white active">Mensual</button>
                                    <button type="button" class="btn btn-xs btn-white ocultar">Anual</button>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div id="chartdiv" style="width: 100%; height: 400px;margin-top: -16px;">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <ul id="lista-prestamo-totales" class="stat-list">
                                        <li>
                                            <h2 class="no-margins precio-interes">$0</h2>
                                            <small>Total G. Intereses pagados</small>
                                            <div class="stat-percent"><span class="proncentaje-interes">0%</span> <i class="fa fa-level-up text-success"></i></div>
                                            <div class="progress progress-mini">
                                                <div style="background-color: #1c84c6" class="progress-bar pb-interes"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <h2 class="no-margins precio-capital">$0</h2>
                                            <small>Total G. Abono a capital</small>
                                            <div class="stat-percent"><span class="proncentaje-capital">0%</span> <i class="fa fa-level-up text-info"></i></div>
                                            <div class="progress progress-mini">
                                                <div style="background-color:#23c6c8;" class="progress-bar pb-capital"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <h2 class="no-margins precio-total-pagado">$0</h2>
                                            <small>Total G. Recaudado</small>
                                            <div class="stat-percent"><span class="proncentaje-total-pagado">0%</span> <i class="fa fa-level-up text-navy"></i></div>
                                            <div class="progress progress-mini">
                                                <div class="progress-bar pb-total-pagado"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <h2 class="no-margins precio-por-recaudar">$0</h2>
                                            <small>Total G. Por recaudar</small>
                                            <div class="stat-percent"><span class="proncentaje-por-recaudar">0%</span> <i class="fa fa-level-down text-danger"></i></div>
                                            <div class="progress progress-mini">
                                                <div style="background-color: #ed5565" class="progress-bar pb-por-recaudar"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <h2 class="no-margins precio-general">$10,930,039,300</h2>
                                            <small>Total General</small>
                                            <div class="stat-percent"><span class="proncentaje-general">0%</span> <i class="fa fa-warning text-warning"></i></div>
                                            <div class="progress progress-mini">
                                                <div style="background-color: #f8ac59" class="progress-bar pb-general"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

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
    <br>
    <br>
    <!-- Fin de contenido de graficas -->

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/graficas/parametrizacion.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/graficas/prestamo.js')}}"></script>

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