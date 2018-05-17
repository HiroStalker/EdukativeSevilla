<?php
    session_start();

	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarFacturas.php");
	require_once("../compartida/gestionarReparaciones.php");

	if (isset ($_SESSION["formulariofactura"])){
			$formulario = $_SESSION["formulariofactura"];
			unset ($_SESSION["formulariofactura"]);
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
  //var_dump(doubleval($formulario["PRECIOTOTAL"]));
  //exit();
  //preg_replace(",","\.",$formulario["PRECIOTOTAL"]);
	$error=meterFactura($conexion, $formulario["C_ID"], $formulario["RM_ID"],$formulario["PRECIOTOTAL"], $formulario["ABONADO"], $formulario["FECHAINICIO"], $formulario["FECHAFIN"]);
	if ($error<>"") {
		$_SESSION["V_ID"]= $formulario["V_ID"];
		//var_dump(isset($_SESSION["V_ID"]));
		//exit();
		$_SESSION["error"] = $error;
		$_SESSION["destino"] = "facturas/formCrearFactura.php";
		Header("Location:../error.php"); }
	else{
		$_SESSION["V_ID"]= $formulario["V_ID"];
		Header("Location:../facturas/facturas.php");
	}
	cerrarConexionBD($conexion);
?>
