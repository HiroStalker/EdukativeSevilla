<?php	
	session_start();	
		
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarClientes.php");
		
	if (isset($_SESSION["cliente"])) {
		$cliente = $_SESSION["cliente"];
		unset($_SESSION["cliente"]);
	}
	else Header("Location:../index.php");
		
	$conexion = crearConexionBD();
	
	$error = quitarCliente($conexion,$cliente["C_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "clientes/clientes.php";
		Header("Location:../error.php"); }
	else{
		if(isset($_SESSION["paginacliente"])){
			$pagina=$_SESSION["paginacliente"];
			if(((int)$pagina["TOTAL"]%(int)$pagina["INTERVALO"])==1){
				$pagina["PAGINA"]=(int)$pagina["PAGINA"]-1;
				$_SESSION["paginacliente"]=$pagina;
			}
			Header("Location:../clientes/clientes.php");
		}	
	}
	cerrarConexionBD($conexion);
?>
