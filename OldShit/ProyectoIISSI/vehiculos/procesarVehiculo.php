<?php
	session_start();
	if (isset($_SESSION["vehiculo"])) {
		Header("Location:../index.php");
	}
	else{
		$vehiculo["editarvehiculo"]=FALSE;

		$vehiculo["V_ID"] = $_REQUEST["V_ID"];
		$vehiculo["C_ID"] = $_REQUEST["C_ID"];
		$vehiculo["MATRICULA"] = $_REQUEST["MATRICULA"];
		$vehiculo["MARCA"] = $_REQUEST["MARCA"];
		$vehiculo["MODELO"] = $_REQUEST["MODELO"];
		$vehiculo["CHASIS"] = $_REQUEST["CHASIS"];
		$vehiculo["COLOR"] = $_REQUEST["COLOR"];
		$vehiculo["KMS"] = $_REQUEST["KMS"];
		$vehiculo["ABANDONADO"] = $_REQUEST["ABANDONADO"];

//var_dump($_REQUEST["imp"]);
//exit();
		if (isset($_REQUEST["editarvehiculo"])){
			$vehiculo["editarvehiculo"]=TRUE;
			$_SESSION["vehiculo"] = $vehiculo;
			Header("Location:../facturas/facturas.php");
		}else if (isset($_REQUEST["quitarvehiculo"])){
			$_SESSION["vehiculo"]= $vehiculo;
			Header("Location:../vehiculos/quitarVehiculo.php");
		}else if (isset($_REQUEST["grabarvehiculo"])){
			$_SESSION["vehiculo"]= $vehiculo;
			Header("Location:../vehiculos/tratamientoFormEditarVehiculo.php");
		}else if (isset($_REQUEST["ver_facturas"])){
			$_SESSION["vehiculo"] = $vehiculo;
			Header("Location:../facturas/facturas.php");
		/*}else if(isset($_REQUEST["INCIMPAGOS"])){
			$_SESSION["vehiculo"] = $vehiculo;
			Header("Location:../vehiculos/tratamientoFormEditarVehiculo.php");
		*/}else{
			Header("Location:../index.php");
		}
	}
?>
