<head>
	<meta charset="utf-8">
</head>
<form action="crearIncludes.php" method="get">
	<center>
		<input type="hidden" name="generar" value="1">
		<input type="text" name="usuario" placeholder="Usuario que genera">
		<br>
		<input type="text" name="db" placeholder="Base de datos">
		<br>
		<input type="text" name="tabla" placeholder="Tabla">
		<br>
		<br>
		<input type="submit" value="Generar">
	</center>
</form>
<?php
if ($_REQUEST["generar"]) {

	include('../includes/conexion.php');
	include("../includes/Generar_IncludesDAO.php");
	include("../includes/entidades/Generar_IncludesVO.php");


	$generar_includesDAO = new Generar_IncludesDAO();
	$generar_includesVO  = new Generar_IncludesVO();

	$arreglo["TABLE_SCHEMA"] = $_REQUEST["db"];
	$arreglo["TABLE_NAME"]  = $_REQUEST["tabla"];

	$usuario = $_REQUEST['usuario'];

	$resultado = $generar_includesDAO->consultarTabla($arreglo,$usuario);

	echo "<br>$resultado";
	
}
?>