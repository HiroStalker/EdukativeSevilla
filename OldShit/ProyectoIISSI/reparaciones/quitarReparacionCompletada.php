<?php	
	session_start();	
		
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarReparaciones.php");
		
	if (isset($_SESSION["reparacion"])) {
		$reparacion = $_SESSION["reparacion"];
		unset($_SESSION["reparacion"]);
	}
	else Header("Location:../index.php");
		
	$conexion = crearConexionBD();
	
	$error = quitarReparacion($conexion,$reparacion["RM_ID"]);
	if ($error<>"") {
		$_SESSION["completado"]=TRUE;
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "reparaciones/reparaciones.php";
		Header("Location:../error.php"); }
	else{
		$_SESSION["completado"]=TRUE;
		if(isset($_SESSION["paginareparacioncom"])){
			$pagina=$_SESSION["paginareparacioncom"];
			if(((int)$pagina["TOTALCOM"]%(int)$pagina["INTERVALOCOM"])==1){
				$pagina["PAGINACOM"]=(int)$pagina["PAGINACOM"]-1;
				$_SESSION["paginareparacioncom"]=$pagina;
			}
			Header("Location:../reparaciones/reparaciones.php");
		}	
	}
	cerrarConexionBD($conexion);
?>
