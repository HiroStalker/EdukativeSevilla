<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
    session_start();
	
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarProveedores.php");
	
	if (isset ($_SESSION["formularioproveedor"])){
			$formulario = $_SESSION["formularioproveedor"];
			unset ($_SESSION["formularioproveedor"]);
	}else Header("Location:../index.php");
	
	$conexion = crearConexionBD();

	$error=meterCliente($conexion, $formulario["empresa"], $formulario["direccion"], $formulario["correo"], $formulario["telefono"], $formulario["cuentabancaria"], (int)$formulario["eficiencia"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "proveedores/formCrearProveedor.php";
		Header("Location:../error.php"); }
	else{
		Header("Location:../proveedores/proveedores.php");
	}
	cerrarConexionBD($conexion);
?>