<?php	
	session_start();	
	
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarClientes.php");
		
	if (isset($_SESSION["cliente"]) ){
		$cliente = $_SESSION["cliente"];
		unset($_SESSION["cliente"]);
	}else Header("Location:../index.php");
	
	$conexion = crearConexionBD();
		
	$error = modificarCliente($conexion,$cliente["C_ID"],$cliente["NOMBRE"],$cliente["APELLIDOS"],$cliente["DNI"],$cliente["DIRECCION"],$cliente["POBLACION"],$cliente["CODIGOPOSTAL"],
				$cliente["TELEFONO"],$cliente["CONFLICTIVO"],$cliente["VISITAS"],$cliente["NUMEROCUENTA"],$cliente["NUMEROIMPAGOS"],$cliente["TIPOCLIENTE"],$cliente["EDAD"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "clientes/clientes.php";
		Header("Location:../error.php"); }
	else{
		$_SESSION["C_ID"]= $cliente["C_ID"];
		Header("Location:../vehiculos/vehiculos.php");
	}
	cerrarConexionBD($conexion);
?>
