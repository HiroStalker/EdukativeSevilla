<?php
	session_start();

	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarPiezasUsadas.php");

	if (isset($_SESSION["piezasusadas"])) {
		$piezasusadas = $_SESSION["piezasusadas"];
		unset($_SESSION["piezasusadas"]);
	}
	else Header("Location:../index.php");

	$conexion = crearConexionBD();

	$error = quitarPiezasUsadas($conexion,$piezasusadas["LR_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "piezasusadas/piezasusadas.php";
		$_SESSION["F_ID"]= $piezasusadas["F_ID"];
		Header("Location:../error.php"); }
	else{
		if(isset($_SESSION["paginapiezasusadas"])){
			$pagina=$_SESSION["paginapiezasusadas"];
			if(((int)$pagina["TOTAL"]%(int)$pagina["INTERVALO"])==1){
				$pagina["PAGINA"]=(int)$pagina["PAGINA"]-1;
				$_SESSION["paginapiezasusadas"]=$pagina;
			}
			$_SESSION["F_ID"]= $piezasusadas["F_ID"];
			Header("Location:../piezasusadas/piezasusadas.php");
		}
	}
	cerrarConexionBD($conexion);
?>
