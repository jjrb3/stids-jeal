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

include("../includes/RolDAO.php"); 
include("../includes/entidades/RolVO.php"); 
include("../includes/Informacion_PaginaDAO.php"); 
include("../includes/entidades/Informacion_PaginaVO.php"); 

$verificarSesion = new VerificarSesion();

$usuario = $verificarSesion->verificarSesionActiva();
$persona = $usuario->get_persona();


$pVisual                = new ParametrizacionVisual();
$rolDAO                 = new RolDAO();
$rolVO                  = new RolVO();
$informacion_paginaDAO  = new Informacion_PaginaDAO();
$informacion_paginaVO   = new Informacion_PaginaVO();

$aRol    = array();
$aInfPag = array();

$aRol["ID"]         = $usuario->get_id_rol();
$aRol["ETADO"]      = 1;
$aInfPag["ID"]      = $usuario->get_id_inf_pag();
$aInfPag["ESTADO"]  = 1;

$rol    = $rolDAO->consultarTabla($aRol);
$rolVO  = $rol[0];

$informacion_pagina     = $informacion_paginaDAO->consultarTabla($aInfPag);
$informacion_paginaVO   = $informacion_pagina[0];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <title>Stids S.A.S - Perfil</title>

    <?=$pVisual->estiloPorDefecto();?>
    <script type="text/javascript" src="perfil.js"></script>
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
                    <?=$pVisual->menuIngreso("Perfil","Editar perfil");?>                  
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
                    <span class="m-r-sm text-muted welcome-message"><?=$persona->get_nombres() . " " . $persona->get_apellidos();?></span>
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
        <!-- Bloques -->

        <div class="row  border-bottom white-bg dashboard-header">

                    <div class="col-sm-3">
                        <h2><strong>Adminisrtación de Modulos</strong></h2>
                    </div>

            </div>

        <!-- Fin bloques -->
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de Roles</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline">
                                <div class="timeline-item">
                                    <div class="row">
                                    <table>
                                        <tr>
                                            <td>
                                                <input type="text" id="rol" class="form-control" style="width:200px" placeholder="Digite el nombre del Rol">
                                            </td>
                                            <td>
                                                &nbsp;
                                            </td>
                                            <td>
                                                <button name="singlebutton" class="btn btn-success" onclick="agregarRol();">Agregar</button>
                                            </td>
                                        </tr>
                                    </table>

<?php

$arrayRol = array();

$arrayRol["ESTADO"] = 1;

$rol = $rolDAO->consultarTabla($arrayRol);

if ($rol) {

    echo '<table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
                <td>Nombre</td>
                <td align="center">Opción</td>
            </thead>';

    foreach ($rol as $fila) {
        
        echo '<tr>';
        echo '<td>' . $fila->get_nombre() . '</td>';
        echo '<td align="center">';
        echo '<a href="#" "' . $fila->get_id() . '"><i class="fa fa-user fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;';
        echo '<a href="#" "' . $fila->get_id() . '"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;';
        echo '<a href="#" "' . $fila->get_id() . '"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

?>                                        


                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>
             
                </div>
            </div>
        </div>

    </div>

    <?=$pVisual->scriptPorDefecto();?>
</body>
</html>