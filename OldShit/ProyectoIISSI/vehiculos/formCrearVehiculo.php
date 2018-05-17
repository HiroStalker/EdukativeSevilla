<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
		session_start();
		if (!isset($_SESSION["formulariovehiculo"]) ) {
			if(isset($_REQUEST["CREAR"])){
				$formulario["C_ID"]=$_REQUEST["CREAR_C_ID"];
			}else if (isset($_SESSION["C_ID"])){
				//$clis=seleccionarCliente($conexion,$_SESSION["C_ID"]);
				//foreach ($clis as $cli) {
					$formulario["C_ID"]=$_SESSION["C_ID"];
				//}
				unset($_SESSION["C_ID"]);
			}else Header("../index.php");
			$formulario["MATRICULA"]="";
			$formulario["MARCA"]="";
			$formulario["MODELO"]="";
			$formulario["CHASIS"]="";
			$formulario["COLOR"]="";
			$formulario["KMS"]="";
			$_SESSION["formulariovehiculo"] = $formulario;
		}else{
			$formulario=$_SESSION["formulariovehiculo"];
		}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Crear nuevo vehículo</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="formVehiculo.js"></script>
	</head>
<body>
<?php
	include_once("../compartida/cabecera.php");
?>
	<div id="titulo">
		<h3>Creación de un Vehículo</h3><!-- TODO: vehículo del cliente X -->
	</div>
	<div id="div_form">
	<form form enctype="multipart/form-data" method="post" action="../vehiculos/tratamientoFormCrearVehiculo.php" onsubmit="return procesarVehiculo()">
		<input id="c_id" name="c_id" type="hidden" value="<?php echo $formulario["C_ID"] ?>"/>
		<div id="div_matricula">
			<label for="matricula" id="label_matricula">Matricula:</label>
			<input id="matricula" name="matricula" type="text" value="" onchange="procesarVehiculo()" size="30"></input>
			<div id="erroresmatriculavehiculo"></div>
		</div>
		<div id="div_marca">
			<label for="marca" id="label_marca">Marca:</label>
			<input id="marca" name="marca" type="text" value="" onchange="procesarVehiculo()" size="30"></input>
			<div id="erroresmarcavehiculo"></div>
		</div>
		<div id="div_modelo">
			<label for="modelo" id="label_modelo">Modelo:</label>
			<input id="modelo" name="modelo" type="text" value="" onchange="procesarVehiculo()" size="30"></input>
			<div id="erroresmodelovehiculo"></div>
		</div>
		<div id="div_chasis">
			<label for="chasis" id="label_chasis">Chasis:</label>
			<input id="chasis" name="chasis" type="text" value="" onchange="procesarVehiculo()" size="30"></input>
			<div id="erroreschasisvehiculo"></div>
		</div>
		<div id="div_color">
			<label for="color" id="label_color">Color:</label>
			<input id="color" name="color" type="text" value="" onchange="procesarVehiculo()" size="25"></input>
			<div id="errorescolorvehiculo"></div>
		</div>
		<div id="div_kms">
			<label for="kms" id="label_kms">Kms:</label>
			<input id="kms" name="kms" type="text" value="" onchange="procesarVehiculo()" size="10"></input>
			<div id="erroreskmsvehiculo"></div>
		</div>
		<input type="submit" value="Crear"></input>
	</form>
	</div>
	<div id="volver">
		<form method="post" action="../vehiculos/vehiculos.php">
			<input id="VOLVER_C_ID" name="VOLVER_C_ID" type="hidden" value="<?php echo $formulario["C_ID"] ?>"/>
			<button id='volver' name='volver' type='submit' class='crear'>Volver</button>
		</form>
	</div>
<?php
	include_once("../compartida/pie.php");
?>
</body>
</html>
