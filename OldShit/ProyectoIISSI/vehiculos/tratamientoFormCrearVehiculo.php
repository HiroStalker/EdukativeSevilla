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
		if (isset($_SESSION["formulariovehiculo"]) ){
			$formulario["C_ID"]=$_REQUEST["c_id"];
			$formulario["MATRICULA"]=$_REQUEST["matricula"];
			$formulario["MARCA"]=$_REQUEST["marca"];
			$formulario["MODELO"]=$_REQUEST["modelo"];
			$formulario["CHASIS"]=$_REQUEST["chasis"];
			$formulario["COLOR"]=$_REQUEST["color"];
			$formulario["KMS"]=$_REQUEST["kms"];
			$formulario["ABANDONADO"]=0;
			$_SESSION["formulariovehiculo"]=$formulario;
			$errores = validar($formulario);
			if ( count ($errores) > 0 ) {
				foreach($errores as $error){
					$_SESSION["error"] = $error . "<br>" . $_SESSION["error"] ;
				}	
				$_SESSION["destino"] = "vehiculos/formCrearVehiculo.php";
				Header("Location:../error.php");
			}else
				Header("Location:../vehiculos/insertarVehiculo.php");
		}else Header("Location:../vehiculos/formCrearVehiculo.php");
		
		function validar($formulario) {
			if (strlen($formulario["MATRICULA"])==0){
				$errores[] = "La matricula no puede ser vacía";
			}
			if (strlen($formulario["MARCA"])==0){
				$errores[] = "La marca no puede estar vacía";
			}
			if (strlen($formulario["MODELO"])==0){
				$errores[] = "El modelo no puede estar vacío";
			}
			if (strlen($formulario["CHASIS"])==0){
				$errores[] = "El chasis no puede estar vacío";
			}
			if (strlen($formulario["COLOR"])==0){
				$errores[] = "El color no puede estar vacío";
			}
			if (strlen($formulario["KMS"])==0){
				$errores[] = "El kilometraje no puede estar vacío";
			}
			if (!preg_match("/^[[:digit:]]+$/", $formulario["KMS"])){
				$errores[] = "El kilometraje debe estar formado únicamente por números";
			}
			return $errores;
		}	
  	?>
  </body>
</html>