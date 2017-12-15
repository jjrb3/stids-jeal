@extends('temas.'.$empresa['nombre_administrador'])

@section('content')	
	
	<div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <h2 style="font-weight: 500;">Parametrización</h2>
            <small>En esta sesión podrás realizar la configuración y Administración de los datos de la plataforma, usuarios, menú, entre otras características.</small>
        </div>
    </div>

	<div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">

                <!-- Comienzo de etiqueta -->
                <div class="col-lg-3">
                    <a href="permisoModulos.php" class="etiqueta">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <center><i class="fa fa-th-large fa-2x"></i></center>
                            </div>
                            <div class="ibox-content ibox-heading">
                                <center>
                                    <span>
                                        <h3>Permisos Modulos</h3>
                                        <small>Selecciona los permisos para los modulos de la plataforma.</small>                                
                                    </span>
                                </center>
                            </div>
                            <div class="ibox-content inspinia-timeline"></div> 
                        </div>
                        <br>
                        <br>
                    </a>
                </div>
                <!-- Fin de etiqueta -->

                <!-- Comienzo de etiqueta -->
                <div class="col-lg-3">
                    <a href="../perfil/index.php" class="etiqueta">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <center><i class="fa fa-user fa-2x"></i></center>
                            </div>
                            <div class="ibox-content ibox-heading">
                                <center>
                                    <span>
                                        <h3>Perfil de Usuario</h3>
                                        <small>Actualiza tus datos de acceso a la plataforma.</small>                            
                                    </span>
                                </center>
                            </div>
                            <div class="ibox-content inspinia-timeline"></div> 
                        </div>
                        <br>
                        <br>
                    </a>
                </div>
                <!-- Fin de etiqueta -->   

                <!-- Comienzo de etiqueta -->
                <div class="col-lg-3">
                    <a href="../perfil/index.php" class="etiqueta">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <center><i class="fa fa-user fa-2x"></i></center>
                            </div>
                            <div class="ibox-content ibox-heading">
                                <center>
                                    <span>
                                        <h3>Perfil de Usuario</h3>
                                        <small>Actualiza tus datos de acceso a la plataforma.</small>                            
                                    </span>
                                </center>
                            </div>
                            <div class="ibox-content inspinia-timeline"></div> 
                        </div>
                        <br>
                        <br>
                    </a>
                </div>
                <!-- Fin de etiqueta -->   

                <!-- Comienzo de etiqueta -->
                <div class="col-lg-3">
                    <a href="../perfil/index.php" class="etiqueta">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <center><i class="fa fa-user fa-2x"></i></center>
                            </div>
                            <div class="ibox-content ibox-heading">
                                <center>
                                    <span>
                                        <h3>Perfil de Usuario</h3>
                                        <small>Actualiza tus datos de acceso a la plataforma.</small>                            
                                    </span>
                                </center>
                            </div>
                            <div class="ibox-content inspinia-timeline"></div> 
                        </div>
                        <br>
                        <br>
                    </a>
                </div>
                <!-- Fin de etiqueta -->  

                <!-- Comienzo de etiqueta -->
                <div class="col-lg-3">
                    <a href="menu.php" class="etiqueta">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <center><i class="fa fa-user fa-2x"></i></center>
                            </div>
                            <div class="ibox-content ibox-heading">
                                <center>
                                    <span>
                                        <h3>Menú y Submenú</h3>
                                        <small>Actualiza tus datos de acceso a la plataforma.</small>                            
                                    </span>
                                </center>
                            </div>
                            <div class="ibox-content inspinia-timeline"></div> 
                        </div>
                        <br>
                        <br>
                    </a>
                </div>
                <!-- Fin de etiqueta -->                    

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