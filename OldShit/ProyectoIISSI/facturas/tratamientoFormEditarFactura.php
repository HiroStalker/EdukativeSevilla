<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<!-- TODO LO QUE HAY QUE HACER EN EDICION ES CONSIDERAR QUE EL USUARIO PUEDE EDITAR SOLAMENTE LA FECHA FIN Y COMPROBAR QUE INTRODUCE
UNA FECHA CORRECTA Y QUE NO ESTA VACIO Y QUE ES MAYOR QUE LA FECHA INICIO (ES LA FECHA EN LA QUE SE ABONA, CUANDO PONGA DICHA FECHA
EL VALOR DE ABONADO PASA A SER 1)(EN LA CREACION CREO QUE ESTA TERMINADO SOLO SE DEJA PONER ABONADO) Y DEBERIA HACER REPARACIONES
PARA QUE ASI PUEDA CREAR REPARACIONES ADEMÁS DE VER LOS FALLOS QUE SE PRODUCEN) -->

<!-- FECHA INICIO NO SE PUEDE MODIFICAR -->
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tratamiento de errores</title>
    <link rel="stylesheet" type="text/css"  href="../estilo_formulario.css" />
  </head>
  <body>

  	<?php
		session_start();
		if (isset($_SESSION["factura"]) ){
			$factura=$_SESSION["factura"];

     		$formulario["F_ID"] = $factura["F_ID"];
			$formulario["RM_ID"] = $factura["RM_ID"];
			$formulario["C_ID"] = $factura["C_ID"];
     		$formulario["PRECIOTOTAL"]=$factura["PRECIOTOTAL"]; //SÍ ESTARÁ YA QUE DEJAREMOS AL USUARIO QUE PUEDA PONER DESCUENTOS
			$formulario["ABONADO"]=$factura["ABONADO"];
			$formulario["FECHAINICIO"]=$factura["FECHAINICIO"]; //NO LO MODIFICARÉ PERO NECESITO METERLO PARA CONSULTAR COSAS
			$formulario["FECHAFIN"]=$factura["FECHAFIN"];
			//var_dump($factura["PRECIOTOTAL"]);
			//exit();
			$errores = validar($formulario);
			if ( count ($errores) > 0 ) {
				foreach($errores as $error){
					$_SESSION["error"] = $error . "<br>" . $_SESSION["error"] ;
				}
				$_SESSION["destino"] = "piezasusadas/piezasusadas.php";
				$_SESSION["F_ID"]= $formulario["F_ID"];
				Header("Location:../error.php");
			}else{
				Header("Location:../facturas/modificarFactura.php");
			}
		}else{
			$_SESSION["F_ID"]=$formulario["F_ID"];
			Header("Location:../piezasusadas/piezasusadas.php");
		}

		function validar($formulario) {
      		if (strlen($formulario["PRECIOTOTAL"])==0){
				$errores[] = "El preciototal no puede ser vacío";
			}
			if (strlen($formulario["FECHAFIN"])==0 and $formulario["ABONADO"]=="1"){
				$errores[] = "La fecha fin no puede estar vacía si la factura está abonada";
			}
			if (!preg_match("/^\d+,\d+$/", $formulario["PRECIOTOTAL"])){
			//if (!preg_match("/^\d+$/", $formulario["PRECIOTOTAL"])){  //TODO EN PRINCIPIO EL USUARIO TENDRA QUE PONERLO COMO UN VALOR ENTERO YA QUE NO SÉ COMO PUEDO ARREGLAR LO QUE PASA
				$errores[] = "El preciototal debe estar formado únicamente por números.";
			}
			if (!esFechaValida($formulario["FECHAFIN"]) and strlen($formulario["FECHAFIN"])!=0){
				$errores[] = "La fecha fin no es válida";
			}
			if(!esMayor($formulario["FECHAFIN"], $formulario["FECHAINICIO"]) and strlen($formulario["FECHAFIN"])!=0){
				$errores[] = "La fecha fin debe ser superior o igual a la fecha inicio";
			}
			return $errores;
		}

		function esFechaValida($fecha){
			//if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/]\d\d\d\d$/", $fecha)){ //Cumple el formato de fecha dd/mm/aaaa
			if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/]\d\d$/", $fecha)){ //TODO Quizás los ] no vayan y tenga que poner /]
				list($dia,$mes,$anno)= split("/",$fecha);
				if($dia == "31" and ($mes == "04" or $mes == "06" or $mes == "09" or $mes == "11")){
					return false;//No cumple que sea un mes con solamente 30 días
				}else if(30<=(int)$dia and $mes == "02"){
					return false;//Es mayor a 30 dias siendo febrero
				}else if($mes == "02" and $dia == "29" and !((int)$anno % 4 == 0 and ((int)$anno % 100 != 0 or (int)$anno % 400 == 0))){
					return false;//Es 29 de febrero pero no es año bisiesto
				}else{
					return true; //Es una fecha válida
				}
			}else{
				return false; //No es una fecha válida
			}
    	}

		function esMayor($fechafin, $fechainicio){
			if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/]\d\d$/", $fechafin) and preg_match("/^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/]\d\d$/", $fechainicio)){
				list($diafin,$mesfin,$annofin)= split("/",$fechafin);
				list($diaini,$mesini,$annoini)= split("/",$fechainicio);
				//var_dump($diafin);
				//exit();
				$inicio = 10000*(int)$annoini + 100*(int)$mesini + (int)$diaini;
				$fin = 10000*(int)$annofin + 100*(int)$mesfin + (int)$diafin;
				if($fin>=$inicio){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

  	?>
  </body>
</html>
