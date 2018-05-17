<?php
	session_start();
	if (isset($_SESSION["cliente"])) {
		Header("Location:../index.php");
	}
	else{
		$cliente["editarcliente"]=FALSE;

		$cliente["C_ID"] = $_REQUEST["C_ID"];
		$cliente["NOMBRE"] = $_REQUEST["NOMBRE"];
		$cliente["APELLIDOS"] = $_REQUEST["APELLIDOS"];
		$cliente["DNI"] = $_REQUEST["DNI"];
		$cliente["DIRECCION"] = $_REQUEST["DIRECCION"];
		$cliente["POBLACION"] = $_REQUEST["POBLACION"];
		$cliente["CODIGOPOSTAL"] = $_REQUEST["CODIGOPOSTAL"];
		$cliente["TELEFONO"] = $_REQUEST["TELEFONO"];
		$cliente["CONFLICTIVO"] = (int)$_REQUEST["CONFLICTIVO"];
		$cliente["VISITAS"] = $_REQUEST["VISITAS"];
		$cliente["NUMEROCUENTA"] = $_REQUEST["NUMEROCUENTA"];
		$cliente["NUMEROIMPAGOS"] = $_REQUEST["NUMEROIMPAGOS"];
		$cliente["TIPOCLIENTE"] = $_REQUEST["TIPOCLIENTE"];
		$cliente["EDAD"] = $_REQUEST["EDAD"];

		if (isset($_REQUEST["editarcliente"])){
			$cliente["editarcliente"]=TRUE;
			$_SESSION["cliente"] = $cliente;
			Header("Location:../vehiculos/vehiculos.php");
		}else if (isset($_REQUEST["quitarcliente"])){
			$_SESSION["cliente"]= $cliente;
			Header("Location:../clientes/quitarCliente.php");
		}else if (isset($_REQUEST["grabarcliente"])){
			$_SESSION["cliente"]= $cliente;
			Header("Location:../clientes/tratamientoFormEditarCliente.php");
		}else if (isset($_REQUEST["ver_vehiculos"])){
			$_SESSION["cliente"] = $cliente;
			Header("Location:../vehiculos/vehiculos.php");
		}else if(isset($_REQUEST["INCIMPAGOS"])){
			$cliente["editarcliente"]=TRUE;
			$_SESSION["cliente"] = $cliente;
			Header("Location:../vehiculos/vehiculos.php");
		}else if(isset($_REQUEST["INCVISITAS"])){
			$cliente["editarcliente"]=TRUE;
			$_SESSION["cliente"] = $cliente;
			Header("Location:../vehiculos/vehiculos.php");
		}else {
			Header("Location:../index.php");
		}
	}
?>
