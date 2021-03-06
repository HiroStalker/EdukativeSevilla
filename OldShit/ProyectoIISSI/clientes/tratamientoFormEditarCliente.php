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
		if (isset($_SESSION["cliente"]) ){
			$cliente=$_SESSION["cliente"];
			$formulario["C_ID"] = $cliente["C_ID"];
			$formulario["NOMBRE"] = $cliente["NOMBRE"];
			$formulario["APELLIDOS"] = $cliente["APELLIDOS"];
			$formulario["DNI"] = $cliente["DNI"];
			$formulario["DIRECCION"] = $cliente["DIRECCION"];
			$formulario["POBLACION"] = $cliente["POBLACION"];
			$formulario["CODIGOPOSTAL"] = $cliente["CODIGOPOSTAL"];
			$formulario["TELEFONO"] = $cliente["TELEFONO"];
			$formulario["CONFLICTIVO"] = (int)$cliente["CONFLICTIVO"];
			$formulario["VISITAS"] = $cliente["VISITAS"];
			$formulario["NUMEROCUENTA"] = $cliente["NUMEROCUENTA"];
			$formulario["NUMEROIMPAGOS"] = $cliente["NUMEROIMPAGOS"];
			$formulario["TIPOCLIENTE"] = $cliente["TIPOCLIENTE"];
			$formulario["EDAD"] = $cliente["EDAD"];
      
			$errores = validar($formulario);
			if ( count ($errores) > 0 ) {
				foreach($errores as $error){
					$_SESSION["error"] = $error . "<br>" . $_SESSION["error"] ;
				}
				$_SESSION["destino"] = "vehiculos/vehiculos.php";
				$_SESSION["C_ID"]= $formulario["C_ID"];
				Header("Location:../error.php");
			}else{
				Header("Location:../clientes/modificarCliente.php");
			}
		}else {
			$_SESSION["C_ID"]=$formulario["C_ID"];
			Header("Location:../vehiculos/vehiculos.php");
		}
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
				$errores[] = "El población no puede estar vacía";
			}
			if (strlen($formulario["CODIGOPOSTAL"])==0){
				$errores[] = "El código postal no puede estar vacío";
			}
			if (strlen($formulario["TELEFONO"])==0){
				$errores[] = "El teléfono no puede estar vacío";
			}
			if (strlen($formulario["NUMEROCUENTA"])==0 and $formulario["TIPOCLIENTE"]=="EMPRESA"){
				$errores[] = "El número de cuenta bancario no puede estar vacío si el cliente es una empresa";
			}
			if (strlen($formulario["EDAD"])==0){
				$errores[] = "La edad no puede estar vacía";
			}
    	 	if (strlen($formulario["VISITAS"])==0){
				$errores[] = "Las visitas no pueden estar vacías";
			}
      		if (!(preg_match("/^[[:digit:]]+$/", $formulario["VISITAS"]))){
				$errores[] = "Las visitas deben estar formadas por dígitos";
			}
      		if (strlen($formulario["NUMEROIMPAGOS"])==0){
				$errores[] = "El número de impagos no puede estar vacío";
			}
      		if (!(preg_match("/^[[:digit:]]+$/", $formulario["NUMEROIMPAGOS"]))){
				$errores[] = "El número de impagos debe estar formado por dígitos";
			}
			if (!(preg_match("/^[[:digit:]]+$/", $formulario["CODIGOPOSTAL"]) and strlen($formulario["CODIGOPOSTAL"])==5)){
				$errores[] = "El código postal debe estar formado 5 dígitos";
			}
			if (!(preg_match("/^[[:digit:]]+$/", $formulario["TELEFONO"]) and strlen($formulario["TELEFONO"])==9)){
				$errores[] = "El teléfono debe estar formado por 9 dígitos";
			}
			if (!(preg_match("/^[[:digit:]]+$/", $formulario["NUMEROCUENTA"]) and strlen($formulario["NUMEROCUENTA"])==22) and strlen($formulario["NUMEROCUENTA"])!=0){
				$errores[] = "El número de cuenta bancario debe estar formado 22 dígitos";
			}
			if (!(preg_match("/^[[:digit:]]+$/", $formulario["EDAD"]) or strlen($formulario["EDAD"])>1) or (intVal($formulario["EDAD"])<18)){
				$errores[] = "La edad debe estar formada únicamente por números y debe ser mayor de edad (+18 años)";
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
