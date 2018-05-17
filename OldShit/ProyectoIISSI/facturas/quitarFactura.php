<?php
	session_start();

	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarFacturas.php");

	if (isset($_SESSION["factura"])) {
		$factura = $_SESSION["factura"];
		unset($_SESSION["factura"]);
	}
	else Header("Location:../index.php");

	$conexion = crearConexionBD();

	$error = quitarFactura($conexion,$factura["F_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "facturas/facturas.php";
		$_SESSION["V_ID"]= $factura["V_ID"];
		Header("Location:../error.php"); }
	else{
		if(isset($_SESSION["paginafactura"])){
			$pagina=$_SESSION["paginafactura"];
			if(((int)$pagina["TOTAL"]%(int)$pagina["INTERVALO"])==1){
				$pagina["PAGINA"]=(int)$pagina["PAGINA"]-1;
				$_SESSION["paginafactura"]=$pagina;
			}
			$_SESSION["V_ID"]= $factura["V_ID"];
			Header("Location:../facturas/facturas.php");
		}
	}
	cerrarConexionBD($conexion);
?>
