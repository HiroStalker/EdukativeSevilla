<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tratamiento de errores</title>
    <link rel="stylesheet" type="text/css"  href="../estilo_formulario.css" />
  </head>
  <body>

  	<?php
		session_start();

		require_once("../compartida/gestionarBD.php");
  		require_once("../compartida/gestionarVehiculos.php");

		$conexion = crearConexionBD();

		if (isset($_SESSION["formularioreparacion"]) ){
			if($_REQUEST["vid"]=="-1"){
	  			$_SESSION["error"] = "No se puede crear una reparación ya que no se ha seleccionado un vehículo.";
	  			$_SESSION["destino"] = "reparaciones/formCrearReparacion.php";
				Header("Location:../error.php");
	  		}else{
	  			$cid="-1";
	  			$vehis=seleccionarVehiculo($conexion, $_REQUEST["vid"]);
				foreach($vehis as $vehi){
					$cid=$vehi["C_ID"];
				}
				if($cid!="-1"){
					$formulario["C_ID"]=$cid;
					$formulario["V_ID"]=$_REQUEST["vid"];
					$formulario["RM"]=$_REQUEST["rm"];
					$formulario["TIPOESTADO"]=$_REQUEST["tipoestado"];
					$formulario["HORAS"]=$_REQUEST["horas"];
					$_SESSION["formularioreparacion"]=$formulario;
					$errores = validar($formulario);
					if ( count ($errores) > 0 ) {
						foreach($errores as $error){
							$_SESSION["error"] = $error . "<br>" . $_SESSION["error"] ;
						}
						$_SESSION["destino"] = "reparaciones/formCrearReparacion.php";
						Header("Location:../error.php");
					}else
						Header("Location:../reparaciones/insertarReparacion.php");
				}else{
					$_SESSION["error"] = "Ha ocurrido un error con la obtención de la reparación, por favor pruebe más tarde.";
	  				$_SESSION["destino"] = "reparaciones/formCrearReparacion.php";
					Header("Location:../error.php");
				}
		 	}
		}else Header("Location:../reparaciones/formCrearReparacion.php");

		function validar($formulario) {
			if (strlen($formulario["HORAS"])==0 ){
				$errores[] = "Las horas no pueden ser vacías";
			}

      //if (!preg_match("/^([0-9])+[\.]\d\d$/", $formulario["HORAS"]) || preg_match("/^([0])+[\.]([0])*$/", $formulario["HORAS"])){ //TODO yo diria que está bien que no deberian haber valores negativos o 0
			//if (!preg_match("/^\d+$/", $formulario["HORAS"]) || preg_match("/^([0])+[\.]([0])*$/", $formulario["HORAS"])){
			if(!preg_match("/^\d+$/", $formulario["HORAS"])){
				$errores[] = "El valor de las horas no es válido, debe ser estrictamente mayor a 0";
			}
			return $errores;
		}

		cerrarConexionBD($conexion);
  	?>
  </body>
</html>
