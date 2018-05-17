<?php
    session_start();

	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarFacturas.php");
	require_once("../compartida/gestionarReparaciones.php");
	require_once("../compartida/gestionarPiezasUsadas.php");

	if (isset ($_SESSION["formulariopiezasusadas"])){
			$formulario = $_SESSION["formulariopiezasusadas"];
			unset ($_SESSION["formulariopiezasusadas"]);
	}else Header("Location:../index.php");

	$conexion = crearConexionBD();
	/*$rm=-1;
	$filas=selecionarReparacionVid($conexion, $formulario["V_ID"]);
	foreach($filas as $fila){
		if($fila["TIPOESTADO"]!="COMPLETADO"){
			$rm=$fila["RM_ID"];
		}else if(rm==-1){
			$rm=$fila["RM_ID"];
		}
	}*/

	$error=meterPiezasUsadas($conexion, $formulario["P_ID"], $formulario["RM_ID"],$formulario["PRECIOPORCANTIDAD"], $formulario["CANTIDADUSADA"]);
	if ($error<>"") {
		$_SESSION["F_ID"]= $formulario["F_ID"];
		//var_dump(isset($_SESSION["V_ID"]));
		//exit();
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "piezasusadas/formCrearPiezasUsadas.php";
		Header("Location:../error.php"); }
	else{
		$_SESSION["F_ID"]= $formulario["F_ID"];
		Header("Location:../piezasusadas/piezasusadas.php");
	}
	cerrarConexionBD($conexion);
?>
