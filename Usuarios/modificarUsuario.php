<?php	
	session_start();	
	
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarusuarios.php");
		
	if (isset($_SESSION["usuario"]) ){
		$usuario = $_SESSION["usuario"];
		unset($_SESSION["usuario"]);
	}else Header("Location:../index.php");
	
	$conexion = crearConexionBD();
		
	$error = modificarusuario($conexion,$usuario["U_ID"],$usuario["NOMBRE"],$usuario["APELLIDOS"],$usuario["DNI"],$usuario["DIRECCION"],$usuario["POBLACION"],$usuario["NUMERODECUENTA"],$usuario["CODIGOPOSTAL"],
				$usuario["TELEFONO"],,$usuario["NUMERODEIMPAGOS"],$usuario["TIPOusuario"],$usuario["MOROSIDAD"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "usuarios/usuarios.php";
		Header("Location:../error.php"); }
	else{
		/*
		$_SESSION["C_ID"]= $usuario["C_ID"];
		Header("Location:../vehiculos/vehiculos.php");
		*/
	}
	cerrarConexionBD($conexion);
?>
 