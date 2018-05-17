<?php	
	session_start();	
		
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarPiezas.php");
		
	if (isset($_SESSION["pieza"])) {
		$pieza = $_SESSION["pieza"];
		unset($_SESSION["pieza"]);
	}
	else Header("Location:../index.php");
		
	$conexion = crearConexionBD();
	
	$error = quitarPieza($conexion,$pieza["P_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "piezas/piezas.php";
		Header("Location:../error.php"); }
	else{
		if(isset($_SESSION["paginapieza"])){
			$pagina=$_SESSION["paginapieza"];
			if(((int)$pagina["TOTAL"]%(int)$pagina["INTERVALO"])==1){
				$pagina["PAGINA"]=(int)$pagina["PAGINA"]-1;
				$_SESSION["paginapieza"]=$pagina;
			}
			Header("Location:../piezas/piezas.php");
		}	
	}
	cerrarConexionBD($conexion);
?>
