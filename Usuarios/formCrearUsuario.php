<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
		session_start();
		if (!isset($_SESSION["formulariousuario"]) ) {
			$formulario["NOMBRE"]="";
			$formulario["APELLIDOS"]="";
			$formulario["DNI"]="";
			$formulario["DIRECCION"]="";
			$formulario["POBLACION"]="";
			$formulario["NUMERODECUENTA"]="";
			$formulario["CODIGOPOSTAL"]="";
			$formulario["TELEFONO"]="";
			$formulario["NUMERODEIMPAGOS"]="";
			$formulario["TIPOusuario"]="PARTICULAR";

			$_SESSION["formulariousuario"] = $formulario;
		}else{
			$formulario=$_SESSION["formulariousuario"];
		}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Crear nuevo usuario</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="formUsuario.js"></script>
	</head>
<body>
<?php
	include_once("../compartida/cabecera.php");
?>
	<div id="titulo">
		<h3>Creación de un Usuario</h3>
	</div>
	<div id="div_form">
	<form form name="formCrearUsuario" enctype="multipart/form-data" action="../Usuarios/tratamientoFormCrearUsuario.php" onsubmit="return procesarUsuario()" method="post" >
		<div id="div_nombre">
			<label for="nombre" id="label_nombre">Nombre:</label>
			<input id="nombre" name="nombre" type="text" onchange="procesarUsuario()" value="" size="20"></input>
			<div id="erroresnombreusuario"></div>
		</div>
		<div id="div_apellidos">
			<label for="apellidos" id="label_apellidos">Apellidos:</label>
			<input id="apellidos" name="apellidos" type="text" onchange="procesarUsuario()" value="" size="30"></input>
			<div id="erroresapellidosusuario"></div>
		</div>
		<div id="div dni">
			<label for="dni" id="label_dni">D.N.I.:</label>
			<input id="dni" name="dni" type="text" onchange="procesarUsuario()" value="" maxlength="9" size="15"></input>
			<div id="erroresdniusuario"></div>
		</div>
		<div id="div direccion">
			<label for="direccion" id="label_direccion">Dirección:</label>
			<input id="direccion" name="direccion" type="text" onchange="procesarUsuario()" value="" size="20"></input>
			<div id="erroresdireccionusuario"></div>
		</div>
		<div id="div poblacion">
			<label for="poblacion" id="label_poblacion">Población:</label>
			<input id="poblacion" name="poblacion" type="text" onchange="procesarUsuario()" value="" size="15"></input>
			<div id="errorespoblacionusuario"></div>
		</div>
		<div id="div_numerodecuenta">
			<label for="numerodecuenta" id="label_numerodecuenta">Cuenta bancaria: ES </label>
			<input id="numerodecuenta" name="numerodecuenta" type="text" onchange="procesarUsuario()" value="" maxlength="22" size="35"></input>
			<div id="erroresnumerocuentausuario"></div>
		</div>
		<div id="div codigopostal">
			<label for="codigopostal" id="label_codigopostal">Código Postal:</label>
			<input id="codigopostal" name="codigopostal" type="text" onchange="procesarUsuario()" value="" maxlength="5" size="10"></input>
			<div id="errorescodigopostalusuario"></div>
		</div>
		<div id="div_telefono">
			<label for="telefono" id="label_telefono">Teléfono: +34 </label>
			<input id="telefono" name="telefono" type="text" onchange="procesarUsuario()" value="" maxlength="9" size="15"></input>
			<div id="errorestelefonousuario"></div>
		</div>
		<div id="div_tipousuario">
			<label for="tipousuario" id="label_tipousuario">Tipo:</label>
			<select name="tipousuario" id="tipousuario" onchange="procesarUsuario()">
				<option selected="selected" value="PARTICULAR">Particular</option>
				<option value="EMPRESA">Empresa</option>
			</select>
			<div id="errorestipousuarioUsuario"></div>
		</div>
		<input type="submit" value="Crear"></input>

	</form>
	</div>
	<div id="volver">
		<form method="post" action="../Usuarios/Usuarios.php">
			<button id='volver' name='volver' type='submit' class='crear'>Volver</button>
		</form>
	</div>
<?php
	include_once("../compartida/pie.php");
?>
</body>
</html>
