<?php	
	session_start();	
	
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarVehiculos.php");
		
	if (isset($_SESSION["vehiculo"]) ){
		$vehiculo = $_SESSION["vehiculo"];
		unset($_SESSION["vehiculo"]);
	}else Header("Location:../index.php");
	
	$conexion = crearConexionBD();
		
	$error = modificarVehiculo($conexion,$vehiculo["V_ID"],$vehiculo["MATRICULA"],$vehiculo["MARCA"],$vehiculo["MODELO"],$vehiculo["CHASIS"],$vehiculo["COLOR"],$vehiculo["KMS"],
				$vehiculo["ABANDONADO"],$vehiculo["C_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "vehiculos/vehiculos.php";
		$_SESSION["C_ID"]= $vehiculo["C_ID"];
		Header("Location:../error.php"); }
	else{
		$_SESSION["V_ID"]= $vehiculo["V_ID"];
		Header("Location:../facturas/facturas.php");
	}
	cerrarConexionBD($conexion);
?>
