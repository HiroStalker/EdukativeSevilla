<?php	
	session_start();	
		
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarusuarios.php");
		
	if (isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];
		unset($_SESSION["usuario"]);
	}
	else Header("Location:../index.php");
		
	$conexion = crearConexionBD();
	
	$error = quitarusuario($conexion,$usuario["C_ID"]);
	if ($error<>"") {
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "Usuarios/Usuarios.php";
		Header("Location:../error.php"); }
	else{
		if(isset($_SESSION["paginausuario"])){
			$pagina=$_SESSION["paginausuario"];
			if(((int)$pagina["TOTAL"]%(int)$pagina["INTERVALO"])==1){
				$pagina["PAGINA"]=(int)$pagina["PAGINA"]-1;
				$_SESSION["paginausuario"]=$pagina;
			}
			Header("Location:../Usuarios/Usuarios.php");
		}	
	}
	cerrarConexionBD($conexion);
?>
