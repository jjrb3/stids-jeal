<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{asset('temas')}}/{{$empresa['tema_nombre']}}/img/favicon.png" type="image/png">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('temas/stids/img/ico/favicon.png')}}">
    <title>.: {{$empresa['nombre_cabecera']}} - {{$empresa['empresa_nombre']}} :.</title>
    <link href="{{asset('temas/stids/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('temas/stids/bootstrap/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('temas/stids/bootstrap/css/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('temas/stids/bootstrap/css/jquery.gritter.css')}}" rel="stylesheet">
    <link href="{{asset('temas/stids/bootstrap/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('temas/stids/bootstrap/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/stids-jeal.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-inspina.css')}}" rel="stylesheet">
    <link href="{{asset('css/checkbox.css')}}" rel="stylesheet">

    <!-- Chosen -->
    <link rel="stylesheet" href="{{asset('temas/stids/librerias/chosen_v1.8.2/chosen.css')}}">

    <!-- Datepicker -->
    <link rel="stylesheet" href="{{asset('temas/stids/librerias/datepicker/bootstrap-datepicker.css')}}">

    <!-- Rangedatepicker -->
    <link rel="stylesheet" href="{{asset('temas/stids/librerias/daterangepicker/daterangepicker.css')}}">

    <!-- Touchspin -->
    <link rel="stylesheet" href="{{asset('temas/stids/librerias/touchspin/jquery.bootstrap-touchspin.css')}}">

    <!-- Sweet alert -->
    <link rel="stylesheet" href="{{asset('temas/stids/librerias/sweet-alert/sweet-alert.css')}}">

    <!-- Datatables -->
    <link rel="stylesheet" href="{{asset('temas/stids/librerias/datatables/datatables.css')}}">

    <!-- Dropzone -->
    <link rel="stylesheet" href="{{asset('temas/stids/librerias/dropzone/basic.css')}}">


    <link rel="stylesheet" href="{{asset('temas/stids/librerias/jquery-mask/mask.css')}}" type="text/css" media="all">

    <!-- Mainly scripts -->
    <script src="{{asset('temas/stids/bootstrap/js/jquery-2.1.1.js')}}"></script>
    <script src="{{asset('temas/stids/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('temas/stids/bootstrap/js/jquery.metisMenu.js')}}"></script>
</head>
<body>
    <input type="hidden" id="directorioRecursos" value="{{asset('recursos')}}/">
    <input type="hidden" id="ruta" value="{{asset('/')}}">
    <div id="wrapper">
    	<!-- Menú de Stids -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> 
                            <div style="color:#fff;font-size:16px;font-weight:bold;">Menú de herramientas</div>
                        </div>
                        <div class="logo-element">
                            <a href="{{$menuAdministrador['ruta']}}inicio" style="color:#fff;">Stids</a>
                        </div>
                    </li>
                    @if($menuAdministrador['menu'])
                        @foreach($menuAdministrador['menu'] as $listaMenu)
                            <li @if($listaMenu['activo']) class="active" @endif>
                                <a href="{{$menuAdministrador['ruta']}}{{$listaMenu['enlace_administrador']}}?padre={{$listaMenu['id']}}">
                                    <i class="fa {{$listaMenu['icono']}}"></i>
                                    <span class="nav-label">{{$listaMenu['nombre']}}</span>
                                    @if(isset($listaMenu['submenu']))
                                        <span class="fa arrow"></span>
                                    @endif
                                    @if($listaMenu['nombre_etiqueta'])
                                        <span class="label label-{{$listaMenu['clase']}} pull-right" title="{{$listaMenu['nombre_etiqueta']}}">{{$listaMenu['diminutivo']}}</span>
                                    @endif
                                </a>
                                @if(isset($listaMenu['submenu']))
                                    <ul class="nav nav-second-level collapse">
                                    @foreach($listaMenu['submenu'] as $submenu)                                        
                                        <li class="w200 @if($submenu['activo']){{'active'}}@endif">
                                            <a href="{{$menuAdministrador['ruta']}}{{$submenu['enlace_administrador']}}?padre={{$submenu['id_padre']}}&hijo={{$submenu['id']}}">
                                                <i class="fa {{$submenu['icono']}}"></i> 
                                                {{$submenu['nombre']}}
                                                @if($submenu['nombre_etiqueta'])
                                                    <span class="label label-{{$submenu['clase']}} pull-right" title="{{$submenu['nombre_etiqueta']}}">{{$submenu['diminutivo']}}</span>
                                                @endif
                                            </a>
                                        </li>                                        
                                    @endforeach
                                    </ul>
                                @endif
                            </li>  
                        @endforeach
                    @endif       
                </ul>

                @if($menu_minimizado == 'true')
                <script>
                    $("body").toggleClass("mini-navbar");
                </script>
                @endif

            </div>
        </nav>
        <!-- Fin del menú -->

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <!-- Barra superior -->
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <button id="btn-menu-izquierdo"
                                data-estado-minimizado="@if($menu_minimizado == 'true'){{'false'}}@else{{'true'}}@endif"
                                class="minimalize-styl-2 btn btn-primary"
                                onclick="Api.Menu.menuIzquierdoDinamico()"
                                title="Cambiar tamaño del menú izquierdo"
                        >
                            <i class="fa @if($menu_minimizado == 'true'){{'fa-bars'}}@else{{'fa-th-large'}}@endif"></i>
                        </button>
                    </div>
                    <div class="navegacion-superior">
                        @if($id_rol == 1 || $cambio_empresa)
                            <button id="btn-navegar" class="btn btn-info btn-menu" onclick="Api.Menu.mostrarNavegacionMaestra()" title="Cambiar de empresa">
                                <i class="fa fa-share-square-o"></i>
                            </button>
                        @endif
                    </div>

                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Hola, {{$nombres}}</span>
                        </li>
                        <li>
                            <a href="{{$menuAdministrador['ruta']}}cerrarSesion">
                                <i class="fa fa-sign-out"></i> Salir
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- Fin barra superior -->
            </div>

            @yield('content')

            <div class="footer">
                <div class="pull-right">
                    <strong>Copyright </strong> Stids Jeal &copy; 2018
                </div>
            </div>
        </div>

        <div id="clonar" style="display: none">
        </div>

        <!-- Modals -->
        <!-- Modal de Eliminar -->
        <div id="modal-eliminar" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:center">
                            <h3 class="m-t-none m-b">¿Estas seguro de eliminar esta información?</h3>
                                <div>
                                    <button id="siModalEliminar" data-dismiss="modal" class="btn btn-sm btn-primary m-t-n-xs"><strong>Sí quiero eliminarlo</strong></button>
                                    <button data-dismiss="modal" class="btn btn-sm btn-default m-t-n-xs"><strong>No quiero eliminarlo</strong></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin del Modal de Eliminar -->
        <!-- Modal para reutilizar -->
        <div id="modal-pequenhio" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:center">
                                <h3 class="m-t-none m-b" id="mensaje"></h3>
                                <div>
                                    <button id="si" data-dismiss="modal" class="btn btn-sm btn-primary m-t-n-xs"><strong>Sí quiero eliminarlo</strong></button>
                                    <button id="no" data-dismiss="modal" class="btn btn-sm btn-default m-t-n-xs"><strong>No quiero eliminarlo</strong></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin del Modal de Eliminar -->

        @if($id_rol == 1 || $cambio_empresa)
            <!-- Cambiar de Empresas solo habilitado para el Rol Administrador de Stids-->
            <div id="modal-cambiar-empresa" class="modal fade" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                                <i class="fa fa-share-square-o icono-modal"></i>
                                &nbsp;
                                <span style="margin-left: 15px">
                                    Cambiar de empresa
                                </span>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>Empresa:</label>
                                    <select id="id-empresa" class="chosen-select form-control" data-placeholder="Seleccione..." tabindex="2" onchange="Api.Menu.cargarRol(this.value)">
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Rol:</label>
                                    <select id="id-rol" class="chosen-select form-control" data-placeholder="Seleccione..." tabindex="2">
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Clave Maestra:</label>
                                    <input id="clave-maestra" type="password" class="form-control m-b" placeholder="******" autocomplete="off" maxlength="100">
                                </div>
                                <div id="mensaje" class="col-lg-12"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="si" class="btn btn-sm btn-primary m-t-n-xs" onclick="Api.Menu.cambiarDeEmpresa()">
                                <strong>
                                    Cambiar
                                </strong>
                            </button>
                            <button id="no" data-dismiss="modal" class="btn btn-sm btn-default m-t-n-xs">
                                <strong>Salir</strong>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin del Modal de Eliminar -->
        @endif

        <!-- Clonar -->
        <!-- Input -->
        <div id="clonar-input" class="ocultar">
            <input>
        </div>
        <!-- Fin Input -->
        <!-- Select -->
        <div id="clonar-select" class="ocultar">
            <select></select>
        </div>
        <!-- Fin Select -->
        <!-- Select -->
        <div id="clonar-tabla" class="ocultar">
            <div class="table-responsive">
                <table>
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- Fin Select -->
        <!-- Select -->
        <div id="clonar-grupo-menu" class="ocultar">
            <div class="btn-group">
                <button></button>
                <ul></ul>
            </div>
        </div>
        <!-- Fin Select -->
        <!-- Clonar cargando -->
        <div id="clonar-cargando" class="ocultar">
            <div class="sk-spinner sk-spinner-chasing-dots" align="center">
                <div class="sk-dot1"></div>
                <div class="sk-dot2"></div>
            </div>
        </div>
        <!-- Fin clonar cargando -->
        <!-- Clonar checkbox -->
        <div id="clonar-checkbox" class="ocultar">
            <label class="control control-checkbox">                    &nbsp;
                <input type="checkbox">
                <div class="control_indicator"></div>
            </label>
        </div>
        <!-- Fin clonar checkbox -->
        <!-- Boton -->
        <div id="clonar-boton" class="ocultar">
            <button></button>
        </div>
        <!-- Fin Boton -->
        <!-- Boton -->
        <div id="clonar-etiqueta" class="ocultar">
            <div class="col-lg-3">
                <a id="href" href="" class="etiqueta">
                    <div class="ibox float-e-margins centrado">
                        <div class="ibox-title">
                            <i id="icono" class="fa  fa-2x"></i>
                        </div>
                        <div class="ibox-content ibox-heading">
                            <span>
                                <h3 id="titulo"></h3>
                                <small id="descripcion"></small>
                            </span>
                        </div>
                        <div class="ibox-content inspinia-timeline"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Fin Boton -->
        <!-- Fin de clonar -->


        <!-- Fin Modals -->

        <!-- Custom and plugin javascript -->
        <script src="{{asset('temas/stids/bootstrap/js/inspinia.js')}}"></script>
        <script src="{{asset('temas/stids/bootstrap/js/pace.min.js')}}"></script>

        <!-- Toastr -->
        <script src="{{asset('temas/stids/bootstrap/js/toastr.min.js')}}"></script>

        <!-- Select2 -->
        <script src="{{asset('temas/stids/librerias/select2/select2.min.js')}}"></script>

        <!-- JQuery Mask -->
        <script src="{{asset('temas/stids/librerias/jquery-mask/mask.js')}}"></script>

        <!-- Chosen -->
        <script src="{{asset('temas/stids/librerias/chosen_v1.8.2/chosen.jquery.js')}}" type="text/javascript"></script>
        <script src="{{asset('temas/stids/librerias/chosen_v1.8.2/docsupport/prism.js')}}" type="text/javascript" charset="utf-8"></script>
        <script src="{{asset('temas/stids/librerias/chosen_v1.8.2/docsupport/init.js')}}" type="text/javascript" charset="utf-8"></script>

        <!-- Datepicker -->
        <script src="{{asset('temas/stids/librerias/datepicker/bootstrap-datepicker.js')}}" type="text/javascript" charset="utf-8"></script>

        <!-- Rangedatepicker -->
        <script src="{{asset('temas/stids/librerias/daterangepicker/moment.js')}}" type="text/javascript" charset="utf-8"></script>
        <script src="{{asset('temas/stids/librerias/daterangepicker/daterangepicker.js')}}" type="text/javascript" charset="utf-8"></script>

        <!-- Touchspin -->
        <script src="{{asset('temas/stids/librerias/touchspin/jquery.bootstrap-touchspin.js')}}" type="text/javascript" charset="utf-8"></script>

        <!-- Typeahead -->
        <script src="{{asset('temas/stids/librerias/typeahead/typeahead.js')}}" type="text/javascript" charset="utf-8"></script>

        <!-- Chart -->
        <script src="{{asset('temas/stids/librerias/chart/chart.js')}}" type="text/javascript" charset="utf-8"></script>

        <!-- Sweet alert -->
        <script src="{{asset('temas/stids/librerias/sweet-alert/sweet-alert.js')}}" type="text/javascript" charset="utf-8"></script>

        <!-- Datatables -->
        <script src="{{asset('temas/stids/librerias/datatables/datatables.js')}}" type="text/javascript" charset="utf-8"></script>

        <!-- Dropzone -->
        <script src="{{asset('temas/stids/librerias/dropzone/dropzone.js')}}" type="text/javascript" charset="utf-8"></script>


        <!-- Stids -->
        <script type="text/javascript" src="{{asset('js/stids/api.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/stids/urls.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/stids/ajax.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/stids/crearElementos.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/stids/herramientasRapidas.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/stids/mensajes.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/stids/inicializador.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/si/graficas/graficas.js')}}"></script>

        <script type="text/javascript" src="{{asset('js/si/menu.js')}}"></script>

        @yield('script')

        <script>
            const ID_ROL        = '{{$id_rol}}';
            const ID_EMPRESA    = '{{$id_empresa}}';

            var $AM = Api.Menu;

            $AM.jsonEmpresaRoles = <?=$json_empresa_roles;?>

            $AM.constructor();

            @if($menu_minimizado == 'true')
            SmoothlyMenu();
            @endif

            Api.Inicializador.parametrosPagina("{{asset('js/stids/ciudades.json')}}");
        </script>

    </div>
</body>
</html>