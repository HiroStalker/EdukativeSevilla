<?php
	session_start();

	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarPiezasUsadas.php");

	if (isset($_SESSION["piezasusadas"]) ){
		$piezasusadas = $_SESSION["piezasusadas"];
		unset($_SESSION["piezasusadas"]);
	}else Header("Location:../index.php");

	$conexion = crearConexionBD();
	/*
	$rm=-1;
	$filas=selecionarReparacionVid($conexion, $piezasusadas["V_ID"]);
	foreach($filas as $fila){
		if($fila["TIPOESTADO"]!="COMPLETADO"){
			$rm=$fila["RM_ID"];
		}else if(rm==-1){
			$rm=$fila["RM_ID"];
		}
	}*/

	$error = modificarPiezasUsadas($conexion,$piezasusadas["LR_ID"],$piezasusadas["P_ID"],$piezasusadas["RM_ID"],$piezasusadas["PRECIOPORCANTIDAD"], $piezasusadas["CANTIDADUSADA"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "piezasusadas/piezasusadas.php";
		$_SESSION["F_ID"]= $piezasusadas["F_ID"];
		Header("Location:../error.php"); }
	else{
		$_SESSION["F_ID"]= $piezasusadas["F_ID"];
		Header("Location:../piezasusadas/piezasusadas.php");
	}
	cerrarConexionBD($conexion);
?>
