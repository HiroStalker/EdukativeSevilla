<?php	
	session_start();	
	
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarProveedores.php");
		
	if (isset($_SESSION["proveedor"]) ){
		$proveedor = $_SESSION["proveedor"];
		unset($_SESSION["proveedor"]);
	}else Header("Location:../index.php");
	
	$conexion = crearConexionBD();
		
	$error = modificarProveedor($conexion,$proveedor["PV_ID"],$proveedor["EMPRESA"],$proveedor["DIRECCION"],$proveedor["CORREO"],$proveedor["TELEFONO"],$proveedor["CUENTABANCARIA"],(int)$proveedor["EFICIENCIA"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "proveedores/proveedores.php";
		Header("Location:../error.php"); }
	else{
		$_SESSION["C_ID"]= $proveedor["C_ID"];
		Header("Location:../proveedores/proveedores.php");
	}
	cerrarConexionBD($conexion);
?>