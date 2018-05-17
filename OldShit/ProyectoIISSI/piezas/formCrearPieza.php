<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
		session_start();
		if (!isset($_SESSION["formulariopieza"]) ) {
			$formulario["NOMBRE"]="";
			$formulario["CANTIDAD"]="";
			$formulario["MARCA"]="";
			$formulario["TIPOCATEGORIA"]="";
			$formulario["PRECIOPROVEEDOR"]="";
			$formulario["PVP"]="";
			$formulario["CODIGO"]="";
			$_SESSION["formulariopieza"] = $formulario;
		}else{
			$formulario=$_SESSION["formulariopieza"];
		}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Crear nuevo pieza</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="formPieza.js"></script>
	</head>
<body>
<?php
	include_once("../compartida/cabecera.php");
?>
	<div id="titulo">
		<h3>Creación de un Pieza</h3>
	</div>
	<div id="div_form">
	<form form name="formCrearClient" enctype="multipart/form-data" action="../piezas/tratamientoFormCrearPieza.php" onsubmit="return procesarPieza()" method="post" >
		<div id="div_nombre">
			<label for="nombre" id="label_nombre">Nombre:</label>
			<input id="nombre" name="nombre" type="text" onchange="procesarPieza()" value="" size="20"></input>
			<div id="erroresnombrepieza"></div>
		</div>
		<div id="div_apellidos">
			<label for="cantidad" id="label_cantidad">Cantidad:</label>
			<input id="cantidad" name="cantidad" type="text" onchange="procesarPieza()" value="" size="30"></input>
			<div id="errorescantidadpieza"></div>
		</div>
		<div id="div marca">
			<label for="marca" id="label_marca">Marca:</label>
			<input id="marca" name="marca" type="text" onchange="procesarPieza()" value=""  size="80"></input>
			<div id="erroresmarcapieza"></div>
		</div>
		<div id="div tipocategoria">
			<label for="tipocategoria" id="label_tipocategoria">Dirección:</label>
			<select name="tipocategoria" id="tipocategoria">
				<option selected="selected" value="CONSUMIBLE">Consumible</option>
				<option value="GRAN_VOLUME">Gran volume</option>
				<option value="COMPLEMENTARIAS">Complementarias</option>		
		</div>
		<div id="div precioporcantidad">
			<label for="precioporcantidad" id="label_precioporcantidad">Precio por cantidad:</label>
			<input id="precioporcantidad" name="precioporcantidad" type="text" onchange="procesarPieza()" value="" size="15"></input>
			<div id="errorespoblacioncpieza"></div>
		</div>
		<div id="div pvp">
			<label for="pvp" id="label_pvp">PVP:</label>
			<input id="pvp" name="pvp" type="text" onchange="procesarPieza()" value="" maxlength="5" size="10"></input>
			<div id="errorescodigopostalpieza"></div>
		</div>
		<div id="div_codigo">
			<label for="codigo" id="label_codigo">Codigo: </label>
			<input id="codigo" name="codigo" type="text" onchange="procesarPieza()" value="" size="50"></input>
			<div id="errorestelefonopieza"></div>
		</div>
		<input type="submit" value="Crear"></input>

	</form>
	</div>
	<div id="volver">
		<form method="post" action="../piezas/piezas.php">
			<button id='volver' name='volver' type='submit' class='crear'>Volver</button>
		</form>
	</div>
<?php
	include_once("../compartida/pie.php");
?>
</body>
</html>
