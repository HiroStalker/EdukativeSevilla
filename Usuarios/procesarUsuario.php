<?php
	session_start();
	if (isset($_SESSION["usuario"])) {
		Header("Location:../index.php");
	}
	else{
		$usuario["editarusuario"]=FALSE;

		$usuario["C_ID"] = $_REQUEST["C_ID"];
		$usuario["NOMBRE"] = $_REQUEST["NOMBRE"];
		$usuario["APELLIDOS"] = $_REQUEST["APELLIDOS"];
		$usuario["DNI"] = $_REQUEST["DNI"];
		$usuario["DIRECCION"] = $_REQUEST["DIRECCION"];
		$usuario["POBLACION"] = $_REQUEST["POBLACION"];
		$usuario["NUMEREDECUENTA"] = $_REQUEST["NUMERODECUENTA"];
		$usuario["CODIGOPOSTAL"] = $_REQUEST["CODIGOPOSTAL"];
		$usuario["TELEFONO"] = $_REQUEST["TELEFONO"];	
		$usuario["NUMERODEIMPAGOS"] = $_REQUEST["NUMERODEIMPAGOS"];
		$usuario["TIPOusuario"] = $_REQUEST["TIPOusuario"];
		$usuario["MOROSIDAD"] = (int)$_REQUEST["MOROSIDAD"];

		if (isset($_REQUEST["editarusuario"])){
			$usuario["editarusuario"]=TRUE;
			$_SESSION["usuario"] = $usuario;
			/*Header("Location:../vehiculos/vehiculos.php");*/
		}else if (isset($_REQUEST["quitarusuario"])){
			$_SESSION["usuario"]= $usuario;
			Header("Location:../usuarios/quitarusuario.php");
		}else if (isset($_REQUEST["grabarusuario"])){
			$_SESSION["usuario"]= $usuario;
			Header("Location:../usuarios/tratamientoFormEditarusuario.php");
		}/*else if (isset($_REQUEST["ver_vehiculos"])){
			$_SESSION["usuario"] = $usuario;
			Header("Location:../vehiculos/vehiculos.php");
		}else if(isset($_REQUEST["INCIMPAGOS"])){
			$usuario["editarusuario"]=TRUE;
			$_SESSION["usuario"] = $usuario;
			Header("Location:../vehiculos/vehiculos.php");
		}else if(isset($_REQUEST["INCVISITAS"])){
			$usuario["editarusuario"]=TRUE;
			$_SESSION["usuario"] = $usuario;
			Header("Location:../vehiculos/vehiculos.php");
		}*/else {
			Header("Location:../index.php");
		}
	}
?>
