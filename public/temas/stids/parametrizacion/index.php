<?php
session_start();
include("../includes/conexion.php");
include("../includes/VerificarSesion.php");
include("../includes/UsuarioDAO.php");
include("../includes/entidades/UsuarioVO.php"); 
include("../includes/PersonaDAO.php");
include("../includes/entidades/PersonaVO.php"); 
include("../includes/MenuDAO.php"); 
include("../includes/entidades/MenuVO.php"); 
include("../includes/parametrizacionVisual.php"); 


$verificarSesion = new VerificarSesion();

$usuario = $verificarSesion->verificarSesionActiva();
$persona = $usuario->get_persona();


$menuDAO = new MenuDAO();
$pVisual = new ParametrizacionVisual();

$menu = $menuDAO->consultarPadres(1);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <title>Stids S.A.S - Inicio</title>

    <?=$pVisual->estiloPorDefecto();?>

</head>
<body>
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
                            <a href="../inicio/index.php" style="color:#fff;">Stids</a>
                        </div>
                    </li>
                    <?=$pVisual->menuIngreso("Parametrización","");?>              
                </ul>
            </div>
        </nav>
        <!-- Fin del menú -->

        <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">

        <!-- Barra superior -->
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
	        <div class="navbar-header">
	            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
	        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message"><?=ucwords(strtolower($persona->get_nombres() . " " . $persona->get_apellidos()));?></span>
                </li>
                <li>
                    <a href="../cerrarSesion.php">
                        <i class="fa fa-sign-out"></i> Salir
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Fin barra superior -->
        </div>
        
        <div class="row  border-bottom white-bg dashboard-header">
            <div class="col-sm-12">
                <h2 style="font-weight: 500;">Parametrización</h2>
                <small>En esta sesión podrás realizar la configuración y Administración de los datos de la plataforma, usuarios, menú, entre otras características.</small>
            </div>
        </div>

        <!-- Contenido de la pagina -->    
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
    </div>

    <?=$pVisual->scriptPorDefecto();?>
</body>
</html>