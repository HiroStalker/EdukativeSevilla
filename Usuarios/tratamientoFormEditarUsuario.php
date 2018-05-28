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
		if (isset($_SESSION["usuario"]) ){
			$usuario=$_SESSION["usuario"];
			$formulario["U_ID"] = $usuario["U_ID"];
			$formulario["NOMBRE"] = $usuario["NOMBRE"];
			$formulario["APELLIDOS"] = $usuario["APELLIDOS"];
			$formulario["DNI"] = $usuario["DNI"];
			$formulario["DIRECCION"] = $usuario["DIRECCION"];
			$formulario["POBLACION"] = $usuario["POBLACION"];
			$formulario["NUMERODECUENTA"] = $usuario["NUMERODECUENTA"];
			$formulario["CODIGOPOSTAL"] = $usuario["CODIGOPOSTAL"];
			$formulario["TELEFONO"] = $usuario["TELEFONO"];
			$formulario["NUMERODEIMPAGOS"] = $usuario["NUMERODEIMPAGOS"];
			$formulario["TIPOUSUARIO"] = $usuario["TIPOUSUARIO"];
			$formulario["MOROSIDAD"] = (int)$usuario["MOROSIDAD"];
			

			$errores = validar($formulario);
			if ( count ($errores) > 0 ) {
				foreach($errores as $error){
					$_SESSION["error"] = $error . "<br>" . $_SESSION["error"] ;
				}
				/*$_SESSION["destino"] = "vehiculos/vehiculos.php";*/
				$_SESSION["U_ID"]= $formulario["U_ID"];
				Header("Location:../error.php");
			}else{
				Header("Location:../Usuarios/modificarUsuario.php");
			}
		}/*else {
			$_SESSION["U_ID"]=$formulario["U_ID"];
			Header("Location:../vehiculos/vehiculos.php");
		}*/
		function validar($formulario) {
			if (strlen($formulario["NOMBRE"])==0){
				$errores[] = "El nombre no puede ser vacío";
			}
			if (strlen($formulario["APELLIDOS"])==0){
				$errores[] = "Los apellidos no pueden estar vacíos";
			}
			if (strlen($formulario["DNI"])==0){
				$errores[] = "El D.N.I. no puede estar vacío";
			}
			if (strlen($formulario["DIRECCION"])==0){
				$errores[] = "La dirección no puede estar vacía";
			}
			if (strlen($formulario["POBLACION"])==0){
				$errores[] = "La población no puede estar vacía";
			}
			if (strlen($formulario["CODIGOPOSTAL"])==0){
				$errores[] = "El código postal no puede estar vacío";
			}
			if (strlen($formulario["TELEFONO"])==0){
				$errores[] = "El teléfono no puede estar vacío";
			}
			if (strlen($formulario["NUMERODECUENTA"])==0 and $formulario["TIPOUSUARIO"]=="EMPRESA"){
				$errores[] = "El número de cuenta bancaria no puede estar vacío si el usuario es una empresa";
			}
			if (!(preg_match("/^[[:digit:]]+$/", $formulario["CODIGOPOSTAL"]) and strlen($formulario["CODIGOPOSTAL"])==5)){
				$errores[] = "El código postal debe estar formado 5 dígitos";
			}
			if (!(preg_match("/^[[:digit:]]+$/", $formulario["TELEFONO"]) and strlen($formulario["TELEFONO"])==9)){
				$errores[] = "El teléfono debe estar formado por 9 dígitos";
			}
			if (!(preg_match("/^[[:digit:]]+$/", $formulario["NUMERODECUENTA"]) and strlen($formulario["NUMERODECUENTA"])==22) and strlen($formulario["NUMERODECUENTA"])!=0){
				$errores[] = "El número de cuenta bancario debe estar formado 22 dígitos";
			}
			if(!validar_dni($formulario["DNI"])){
				$errores[] = "El D.N.I es inválido";
			}
			return $errores;
		}

		function validar_dni($dni){
			$letra = substr($dni, -1);
			$numeros = substr($dni, 0, -1);
			if ( substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 ){
				return TRUE;
			}else{
				return FALSE;
			}
		}
  	?>
  </body>
</html>
