<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
    session_start();

	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarReparaciones.php");

	if (isset ($_SESSION["formularioreparacion"])){
			$formulario = $_SESSION["formularioreparacion"];
			unset ($_SESSION["formularioreparacion"]);
	}else Header("Location:../index.php");

	$conexion = crearConexionBD();
	$error=meterReparacion($conexion, $formulario["TIPOESTADO"], $formulario["RM"], (double)$formulario["HORAS"], $formulario["C_ID"], $formulario["V_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "reparaciones/formCrearReparacion.php";
		Header("Location:../error.php"); }
	else{
		Header("Location:../reparaciones/reparaciones.php");
	}
	cerrarConexionBD($conexion);
?>
