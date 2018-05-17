<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
    session_start();
	
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarClientes.php");
	
	if (isset ($_SESSION["formulariocliente"])){
			$formulario = $_SESSION["formulariocliente"];
			unset ($_SESSION["formulariocliente"]);
	}else Header("Location:../index.php");
	
	$conexion = crearConexionBD();

	$error=meterCliente($conexion, $formulario["NOMBRE"], $formulario["APELLIDOS"], $formulario["DNI"], $formulario["DIRECCION"], $formulario["POBLACION"], $formulario["CODIGOPOSTAL"], 
					$formulario["TELEFONO"], $formulario["CONFLICTIVO"], $formulario["VISITAS"], $formulario["NUMEROCUENTA"], $formulario["NUMEROIMPAGOS"], $formulario["TIPOCLIENTE"], $formulario["EDAD"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "clientes/formCrearCliente.php";
		Header("Location:../error.php"); }
	else{
		Header("Location:../clientes/clientes.php");
	}
	cerrarConexionBD($conexion);
?>