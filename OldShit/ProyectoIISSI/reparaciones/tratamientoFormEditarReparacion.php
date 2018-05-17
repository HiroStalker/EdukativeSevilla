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
		if (isset($_SESSION["reparacion"]) ){
			$reparacion=$_SESSION["reparacion"];
			$formulario["RM_ID"] = $reparacion["RM_ID"];
			$formulario["C_ID"] = $reparacion["C_ID"];
			$formulario["V_ID"] = $reparacion["V_ID"];
			$formulario["RM"] = $reparacion["RM"];
			$formulario["TIPOESTADO"] = $reparacion["TIPOESTADO"];
			$formulario["HORAS"] = $reparacion["HORAS"];

			$errores = validar($formulario);
			if ( count ($errores) > 0 ) {
				foreach($errores as $error){
					$_SESSION["error"] = $error . "<br>" . $_SESSION["error"] ;
				}
				$_SESSION["destino"] = "reparaciones/reparaciones.php";
				Header("Location:../error.php");
			}else{
				Header("Location:../reparaciones/modificarReparacion.php");
			}
		}else {
			if($formulario["TIPOESTADO"]=="COMPLETADO"){
				$_SESSION["completado"]=TRUE;
				Header("Location:../reparaciones/reparaciones.php");
			}else{
				Header("Location:../reparaciones/reparaciones.php");
			}
		}
		function validar($formulario) {
			if (strlen($formulario["HORAS"])==0 ){
				$errores[] = "Las horas no pueden ser vacías";
			}
			//if (!preg_match("/^([0-9])+[\.]\d\d$/", $formulario["HORAS"]) || preg_match("/^([0])+[\.]([0])*$/", $formulario["HORAS"])){ //TODO yo diria que está bien que no deberian haber valores negativos o 0
			if (!preg_match("/^\d+$/", $formulario["HORAS"]) || preg_match("/^([0])+[\.]([0])*$/", $formulario["HORAS"])){
				$errores[] = "El valor de las horas no es válido, debe ser estrictamente mayor a 0";
			}
			return $errores;
		}
  	?>
  </body>
</html>
