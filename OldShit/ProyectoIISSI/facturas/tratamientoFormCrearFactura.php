<?php
session_start();
  require_once("../compartida/gestionarBD.php");
  require_once("../compartida/gestionarVehiculos.php");
  require_once("../compartida/gestionarFacturas.php");
  require_once("../compartida/gestionarReparaciones.php");

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

	  if (isset($_SESSION["formulariofactura"]) ){
	  	if($_REQUEST["rm_id"]=="-1"){
	  		$_SESSION["error"] = "Debe seleccionar una Reparación/Mantenimiento antes de crear una factura";
	  		$_SESSION["destino"] = "facturas/formCrearFactura.php";
			Header("Location:../error.php");
	  	}else{
      /*$precios=consultarPrecioTotal($conexion,$_REQUEST["rm_id"]);  //TODO POR AHORA NO HABRÁ PRECIOTOTAL HASTA QUE NO SE CREEN LAS PIEZAS USADAS Y BÁSICAMENTE ES SUMAR EL PRECIO DE TODOS SUS HIJOS
      $val=0;
      foreach($precios as $precio){                                  // SEGURAMENTE NO SE HAGA ESTO ASÍ
        $val=$precio;
      }*/
      //$val="0";
      if($_REQUEST["abonado"]=="1"){
        //$fech=date_default_timezone_get();
        //$formulario["FECHAFIN"]=date_format($fech,'d/m/Y');
        $formulario["FECHAFIN"]=date("d/m/Y", time());
      }else{
        $formulario["FECHAFIN"]="";
      }
      		//var_dump($_REQUEST["rm_id"]);
      		//exit();
      		$formulario["RM_ID"]=$_REQUEST["rm_id"];
     		$formulario["C_ID"]=$_REQUEST["c_id"];
     		$formulario["V_ID"]=$_REQUEST["v_id"];
			$formulario["ABONADO"]=$_REQUEST["abonado"];
			$formulario["PRECIOTOTAL"]=$_REQUEST["preciototal"];
      		//$fec=date_default_timezone_get();
			$formulario["FECHAINICIO"]=date("d/m/Y", time());
			//var_dump($formulario["FECHAINICIO"]);
      		//exit();
     		//$formulario["PRECIOTOTAL"]=$val;
			$_SESSION["formulariofactura"]=$formulario;
			$errores = validar($formulario);
			if ( count ($errores) > 0 ) {
				foreach($errores as $error){
					$_SESSION["error"] = $error . "<br>" . $_SESSION["error"] ;
				}
				$_SESSION["destino"] = "facturas/formCrearFactura.php";
				Header("Location:../error.php");
			}else
				Header("Location:../facturas/insertarFactura.php");
		}
		}else Header("Location:../facturas/formCrearFactura.php");

	  function validar($formulario) {
	  		if (strlen($formulario["PRECIOTOTAL"])==0){
				$errores[] = "El preciototal no puede ser vacío";
			}
      		//if (!preg_match("/^\d+$/", $formulario["PRECIOTOTAL"])){ //TODO VER EN EDITAR
			if (!preg_match("/^\d+,\d+$/", $formulario["PRECIOTOTAL"])){
				$errores[] = "El valor del precio total no es válido, debe ser un dato numérico";
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
