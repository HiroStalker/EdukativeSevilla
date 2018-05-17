<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
		session_start();
		if (!isset($_SESSION["formulariocliente"]) ) {
			$formulario["NOMBRE"]="";
			$formulario["APELLIDOS"]="";
			$formulario["DNI"]="";
			$formulario["DIRECCION"]="";
			$formulario["POBLACION"]="";
			$formulario["CODIGOPOSTAL"]="";
			$formulario["TELEFONO"]="";
			$formulario["NUMEROCUENTA"]="";
			$formulario["TIPOCLIENTE"]="PARTICULAR";
			$formulario["EDAD"]="";
			$_SESSION["formulariocliente"] = $formulario;
		}else{
			$formulario=$_SESSION["formulariocliente"];
		}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Crear nuevo cliente</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="formCliente.js"></script>
	</head>
<body>
<?php
	include_once("../compartida/cabecera.php");
?>
	<div id="titulo">
		<h3>Creación de un Cliente</h3>
	</div>
	<div id="div_form">
	<form form name="formCrearClient" enctype="multipart/form-data" action="../clientes/tratamientoFormCrearCliente.php" onsubmit="return procesarCliente()" method="post" >
		<div id="div_nombre">
			<label for="nombre" id="label_nombre">Nombre:</label>
			<input id="nombre" name="nombre" type="text" onchange="procesarCliente()" value="" size="20"></input>
			<div id="erroresnombrecliente"></div>
		</div>
		<div id="div_apellidos">
			<label for="apellidos" id="label_apellidos">Apellidos:</label>
			<input id="apellidos" name="apellidos" type="text" onchange="procesarCliente()" value="" size="30"></input>
			<div id="erroresapellidoscliente"></div>
		</div>
		<div id="div dni">
			<label for="dni" id="label_dni">D.N.I.:</label>
			<input id="dni" name="dni" type="text" onchange="procesarCliente()" value="" maxlength="9" size="15"></input>
			<div id="erroresdnicliente"></div>
		</div>
		<div id="div direccion">
			<label for="direccion" id="label_direccion">Dirección:</label>
			<input id="direccion" name="direccion" type="text" onchange="procesarCliente()" value="" size="20"></input>
			<div id="erroresdireccioncliente"></div>
		</div>
		<div id="div poblacion">
			<label for="poblacion" id="label_poblacion">Población:</label>
			<input id="poblacion" name="poblacion" type="text" onchange="procesarCliente()" value="" size="15"></input>
			<div id="errorespoblacioncliente"></div>
		</div>
		<div id="div codigopostal">
			<label for="codigopostal" id="label_codigopostal">Código Postal:</label>
			<input id="codigopostal" name="codigopostal" type="text" onchange="procesarCliente()" value="" maxlength="5" size="10"></input>
			<div id="errorescodigopostalcliente"></div>
		</div>
		<div id="div_telefono">
			<label for="telefono" id="label_telefono">Teléfono: +34 </label>
			<input id="telefono" name="telefono" type="text" onchange="procesarCliente()" value="" maxlength="9" size="15"></input>
			<div id="errorestelefonocliente"></div>
		</div>
		<div id="div_numerocuenta">
			<label for="numerocuenta" id="label_numerocuenta">Cuenta bancaria: ES </label>
			<input id="numerocuenta" name="numerocuenta" type="text" onchange="procesarCliente()" value="" maxlength="22" size="35"></input>
			<div id="erroresnumerocuentacliente"></div>
		</div>
		<div id="div_tipocliente">
			<label for="tipocliente" id="label_tipocliente">Tipo:</label>
			<select name="tipocliente" id="tipocliente" onchange="procesarCliente()">
				<option selected="selected" value="PARTICULAR">Particular</option>
				<option value="EMPRESA">Empresa</option>
			</select>
			<div id="errorestipoclientecliente"></div>
		</div>
		<div id="div_edad">
			<label for="edad" id="label_edad">Edad:</label>
			<input id="edad" name="edad" type="text" onchange="procesarCliente()" value="" size="5"></input>
			<div id="erroresedadcliente"></div>
		</div>
		<input type="submit" value="Crear"></input>

	</form>
	</div>
	<div id="volver">
		<form method="post" action="../clientes/clientes.php">
			<button id='volver' name='volver' type='submit' class='crear'>Volver</button>
		</form>
	</div>
<?php
	include_once("../compartida/pie.php");
?>
</body>
</html>
