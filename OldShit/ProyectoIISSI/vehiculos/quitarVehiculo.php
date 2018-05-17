<?php	
	session_start();	
		
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarVehiculos.php");
		
	if (isset($_SESSION["vehiculo"])) {
		$vehiculo = $_SESSION["vehiculo"];
		unset($_SESSION["vehiculo"]);
	}
	else Header("Location:../index.php");
		
	$conexion = crearConexionBD();
	
	$error = quitarVehiculo($conexion,$vehiculo["V_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "vehiculos/vehiculos.php";
		$_SESSION["C_ID"]= $vehiculo["C_ID"];
		Header("Location:../error.php"); }
	else{
		if(isset($_SESSION["paginavehiculo"])){
			$pagina=$_SESSION["paginavehiculo"];
			if(((int)$pagina["TOTAL"]%(int)$pagina["INTERVALO"])==1){
				$pagina["PAGINA"]=(int)$pagina["PAGINA"]-1;
				$_SESSION["paginavehiculo"]=$pagina;
			}
			$_SESSION["C_ID"]= $vehiculo["C_ID"];
			Header("Location:../vehiculos/vehiculos.php");
		}	
	}
	cerrarConexionBD($conexion);
?>
