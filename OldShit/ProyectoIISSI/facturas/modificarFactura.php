<?php
	session_start();

	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarFacturas.php");
	require_once("../compartida/gestionarReparaciones.php");

	if (isset($_SESSION["factura"]) ){
		$factura = $_SESSION["factura"];
		unset($_SESSION["factura"]);
	}else Header("Location:../index.php");

	$conexion = crearConexionBD();
	/*
	$rm=-1;
	$filas=selecionarReparacionVid($conexion, $factura["V_ID"]);
	foreach($filas as $fila){
		if($fila["TIPOESTADO"]!="COMPLETADO"){
			$rm=$fila["RM_ID"];
		}else if(rm==-1){
			$rm=$fila["RM_ID"];
		}
	}*/

	$error = modificarFactura($conexion,$factura["F_ID"],$factura["C_ID"],$factura["RM_ID"],$factura["PRECIOTOTAL"], $factura["ABONADO"], $factura["FECHAINICIO"], $factura["FECHAFIN"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "facturas/facturas.php";
		$_SESSION["V_ID"]= $factura["V_ID"];
		Header("Location:../error.php"); }
	else{
		$_SESSION["F_ID"]= $factura["F_ID"];
		Header("Location:../piezasusadas/piezasusadas.php");
	}
	cerrarConexionBD($conexion);
?>
