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

		require_once("../compartida/gestionarPiezasUsadas.php");
		require_once("../compartida/gestionarPiezas.php");
		$conexion = crearConexionBD();

		if (isset($_SESSION["piezasusadas"]) ){
			$piezasusadas=$_SESSION["piezasusadas"];

     		$formulario["LR_ID"] = $piezasusadas["LR_ID"];
			$formulario["RM_ID"] = $piezasusadas["RM_ID"];
			$formulario["P_ID"] = $piezasusadas["P_ID"];
			$formulario["F_ID"] = $piezasusadas["F_ID"];
     		$formulario["CANTIDADUSADA"]=$piezasusadas["CANTIDADUSADA"]; //SÍ ESTARÁ YA QUE DEJAREMOS AL USUARIO QUE PUEDA PONER DESCUENTOS

			$pies=seleccionarPieza($conexion,$piezasusadas["P_ID"]);
			foreach($pies as $pie){
				$formulario["PRECIOPORCANTIDAD"]=(int)$pie["PVP"]*$piezasusadas["CANTIDADUSADA"];
			}
			$errores = validar($formulario);
			if ( count ($errores) > 0 ) {
				foreach($errores as $error){
					$_SESSION["error"] = $error . "<br>" . $_SESSION["error"] ;
				}
				$_SESSION["destino"] = "piezasusadas/piezasusadas.php";
				$_SESSION["F_ID"]= $formulario["F_ID"];
				Header("Location:../error.php");
			}else{
				Header("Location:../piezasusadas/modificarPiezasUsadas.php");
			}
		}else{
			$_SESSION["F_ID"]=$formulario["F_ID"];
			Header("Location:../piezasusadas/piezasusadas.php");
		}

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

	cerrarConexionBD($conexion);
  	?>
  </body>
</html>
