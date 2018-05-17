<?php	
	session_start();	
	
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarPiezas.php");
		
	if (isset($_SESSION["pieza"]) ){
		$pieza = $_SESSION["pieza"];
		unset($_SESSION["pieza"]);
	}else Header("Location:../index.php");
	
	$conexion = crearConexionBD();
		
	$error = modificarPieza($conexion,$pieza["p_id"],$pieza["nombre"],$pieza["cantidad"],$pieza["marca"],$pieza["tipocategoria"],$pieza["precioproveedor"],$pieza["pvp"],$pieza["codigo"],$pieza["pv_id"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "piezas/piezas.php";
		Header("Location:../error.php"); }
	else{
		Header("Location:../piezas/piezas.php");
	}
	cerrarConexionBD($conexion);
?>
