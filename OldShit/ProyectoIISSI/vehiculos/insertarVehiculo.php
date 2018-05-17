<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
    session_start();
	
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarVehiculos.php");
	
	if (isset ($_SESSION["formulariovehiculo"])){
			$formulario = $_SESSION["formulariovehiculo"];
			unset ($_SESSION["formulariovehiculo"]);
	}else Header("Location:../index.php");
	
	$conexion = crearConexionBD();
	
	$error=meterVehiculo($conexion, $formulario["C_ID"], $formulario["MATRICULA"], $formulario["MARCA"], $formulario["MODELO"], $formulario["CHASIS"], $formulario["COLOR"], 
					$formulario["KMS"], $formulario["ABANDONADO"]);
	if ($error<>"") {
		$_SESSION["C_ID"]= $formulario["C_ID"];
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "vehiculos/formCrearVehiculo.php";
		Header("Location:../error.php"); }
	else{
		$_SESSION["C_ID"]= $formulario["C_ID"];	
		Header("Location:../vehiculos/vehiculos.php");
	}
	cerrarConexionBD($conexion);
?>