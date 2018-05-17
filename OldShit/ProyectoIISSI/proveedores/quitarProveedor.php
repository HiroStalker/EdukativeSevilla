<?php	
	session_start();	
		
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarProveedores.php");
		
	if (isset($_SESSION["proveedor"])) {
		$proveedor = $_SESSION["proveedor"];
		unset($_SESSION["proveedor"]);
	}
	else Header("Location:../index.php");
		
	$conexion = crearConexionBD();
	
	$error = quitarProveedor($conexion,$proveedor["PV_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "proveedores/proveedores.php";
		Header("Location:../error.php"); }
	else{
		if(isset($_SESSION["paginaproveedor"])){
			$pagina=$_SESSION["paginaproveedor"];
			if(((int)$pagina["TOTAL"]%(int)$pagina["INTERVALO"])==1){
				$pagina["PAGINA"]=(int)$pagina["PAGINA"]-1;
				$_SESSION["paginaproveedor"]=$pagina;
			}
			Header("Location:../proveedores/proveedores.php");
		}	
	}
	cerrarConexionBD($conexion);
?>
