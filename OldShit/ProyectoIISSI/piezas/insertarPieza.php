<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
    session_start();

	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarPiezas.php");

	if (isset ($_SESSION["formulariopieza"])){
			$formulario = $_SESSION["formulariopieza"];
			unset ($_SESSION["formulariopieza"]);
	}else Header("Location:../index.php");

	$conexion = crearConexionBD();
	$error=meterPieza($conexion, $formulario["nombre"], (double)$formulario["cantidad"], $formulario["marca"], $formulario["tipocategoria"], $formulario["precioproveedor"], $formulario["pvp"], $formulario["codigo"], $formulario["pv_id"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "piezas/formCrearPieza.php";
		Header("Location:../error.php"); }
	else{
		Header("Location:../piezas/piezas.php");
	}
	cerrarConexionBD($conexion);
?>
