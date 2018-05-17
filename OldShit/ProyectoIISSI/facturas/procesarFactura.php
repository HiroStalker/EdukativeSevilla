<?php
	session_start();
	if (isset($_SESSION["factura"])) {
		Header("Location:../index.php");
	}
	else{
		$factura["editarfactura"]=FALSE;

		$factura["F_ID"] = $_REQUEST["F_ID"];
		$factura["RM_ID"] = $_REQUEST["RM_ID"];
		$factura["C_ID"] = $_REQUEST["C_ID"];
		$factura["V_ID"] = $_REQUEST["V_ID"];
		$factura["PRECIOTOTAL"] = $_REQUEST["PRECIOTOTAL"];
		$factura["ABONADO"] = $_REQUEST["ABONADO"];
		$factura["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
		$factura["FECHAFIN"] = $_REQUEST["FECHAFIN"];
		
		if (isset($_REQUEST["editarfactura"])){
			$factura["editarfactura"]=TRUE;
			$_SESSION["factura"] = $factura;
			Header("Location:../piezasusadas/piezasusadas.php");
		}else if (isset($_REQUEST["quitarfactura"])){
			$_SESSION["factura"]= $factura;
			Header("Location:../facturas/quitarFactura.php");
		}else if (isset($_REQUEST["grabarfactura"])){
			$_SESSION["factura"]= $factura;
			Header("Location:../facturas/tratamientoFormEditarFactura.php");
		}else if (isset($_REQUEST["ver_lineareparacion"])){
			$_SESSION["factura"] = $factura;
			Header("Location:../piezasusadas/piezasusadas.php");
		}else {
			Header("Location:../index.php");
		}
	}
?>
