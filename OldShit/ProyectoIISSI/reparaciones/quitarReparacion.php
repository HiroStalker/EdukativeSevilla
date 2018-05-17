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
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "reparaciones/reparaciones.php";
		Header("Location:../error.php"); }
	else{
		if(isset($_SESSION["paginareparacion"])){
			$pagina=$_SESSION["paginareparacion"];
			if(((int)$pagina["TOTAL"]%(int)$pagina["INTERVALO"])==1){
				$pagina["PAGINA"]=(int)$pagina["PAGINA"]-1;
				$_SESSION["paginareparacion"]=$pagina;
			}
			Header("Location:../reparaciones/reparaciones.php");
		}	
	}
	cerrarConexionBD($conexion);
?>
