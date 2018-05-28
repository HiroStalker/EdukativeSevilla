<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
session_start();

require_once("../compartida/gestionarBD.php");
require_once("../compartida/gestionarUsuarios.php");

if (isset ($_SESSION["formulariousuario"])){
	$formulario = $_SESSION["formulariousuario"];
	unset ($_SESSION["formulariousuario"]);
}else Header("Location:../index.php");

$conexion = crearConexionBD();

$error=meterUsuario($conexion, $formulario["NOMBRE"], $formulario["APELLIDOS"], $formulario["DNI"], $formulario["DIRECCION"], $formulario["POBLACION"], $formulario["NUMERODECUENTA"], $formulario["CODIGOPOSTAL"], $formulario["TELEFONO"],  $formulario["NUMERODEIMPAGOS"], $formulario["TIPOUSUARIO"], $formulario["MOROSIDAD"]);
if ($error<>"") {
	$_SESSION["error"] = $error;
	$_SESSION["destino"] = "Usuarios/formCrearUsuario.php";
	Header("Location:../error.php"); }
	else{
		Header("Location:../Usuarios/Usuarios.php");
	}
	cerrarConexionBD($conexion);
	?>