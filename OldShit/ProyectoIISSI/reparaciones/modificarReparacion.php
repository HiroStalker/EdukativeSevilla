<?php	
	session_start();	
	
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarReparaciones.php");
		
	if (isset($_SESSION["reparacion"]) ){
		$reparacion = $_SESSION["reparacion"];
		unset($_SESSION["reparacion"]);
	}else Header("Location:../index.php");
	
	$conexion = crearConexionBD();
		
	$error = modificarReparacion($conexion,$reparacion["RM_ID"],$reparacion["TIPOESTADO"],$reparacion["RM"],(int)$reparacion["HORAS"],$reparacion["C_ID"],$reparacion["V_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "reparaciones/reparaciones.php";
		Header("Location:../error.php"); }
	else{
		Header("Location:../reparaciones/reparaciones.php");
	}
	cerrarConexionBD($conexion);
?>
