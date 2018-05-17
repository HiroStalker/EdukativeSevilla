<?php
session_start();
  require_once("../compartida/gestionarBD.php");
  require_once("../compartida/gestionarVehiculos.php");
  require_once("../compartida/gestionarFacturas.php");
  require_once("../compartida/gestionarReparaciones.php");
  require_once("../compartida/gestionarPiezasUsadas.php");
  require_once("../compartida/gestionarPiezas.php");

  $conexion = crearConexionBD();
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tratamiento de errores</title>
    <link rel="stylesheet" type="text/css"  href="../estilo_formulario.css" />
  </head>
  <body>

  	<?php

	  if (isset($_SESSION["formulariopiezasusadas"]) ){
	  	if($_REQUEST["p_id"]=="-1"){
	  		$_SESSION["error"] = "Debe seleccionar una Pieza antes de poder colocarla en una Factura";
	  		$_SESSION["destino"] = "piezasusadas/formCrearPiezasUsadas.php";
			Header("Location:../error.php");
	  	}else{

      		$formulario["F_ID"]=$_REQUEST["f_id"];
     		$formulario["RM_ID"]=$_REQUEST["rm_id"];
     		$formulario["P_ID"]=$_REQUEST["p_id"];
			$formulario["CANTIDADUSADA"]=$_REQUEST["cantidadusada"];
			$pies=seleccionarPieza($conexion,$_REQUEST["p_id"]);
			foreach($pies as $pie){
				$formulario["PRECIOPORCANTIDAD"]=(int)$pie["PVP"]*$_REQUEST["cantidadusada"];
				$cant=$pie["CANTIDAD"];
			}
			$_SESSION["formulariopiezasusadas"]=$formulario;
			$errores = validar($formulario);
			if ( count ($errores) > 0 ) {
				foreach($errores as $error){
					$_SESSION["error"] = $error . "<br>" . $_SESSION["error"] ;
				}
				$_SESSION["destino"] = "piezasusadas/formCrearPiezasUsadas.php";
				Header("Location:../error.php");
			}else
				Header("Location:../piezasusadas/insertarPiezasUsadas.php");
		}
		}else Header("Location:../piezasusadas/formCrearPiezasUsadas.php");

	  function validar($formulario) {
	  		if (strlen($formulario["CANTIDADUSADA"])==0){
				$errores[] = "La cantidad usada no puede ser vacía";
			}
      		//if (!preg_match("/^\d+$/", $formulario["CANTIDADUSADA"]) or preg_match("/^([0])+$/", $formulario["CANTIDADUSADA"])){ //TODO VER EN EDITAR
			if (!preg_match("/^\d+,\d+$/", $formulario["PRECIOTOTAL"])){	
				$errores[] = "El valor de la cantidad usada debe ser mayor a 0";
			}
			if ((int)$formulario["CANTIDADUSADA"]>(int)$cant){
				$errores[] = "La cantidad usada no puede ser superior a la cantidad en almacén";
			}
			return $errores;
		}

  /*  function esFechaValida($fecha){
      return preg_match("/^(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/]\d\d\d\d$/", $fecha);
    }*/
    cerrarConexionBD($conexion);
  	?>
  </body>
</html>
