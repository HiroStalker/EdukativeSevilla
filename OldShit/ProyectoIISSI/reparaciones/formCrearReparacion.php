<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
		session_start();
		
		require_once("../compartida/gestionarBD.php");
		require_once("../compartida/gestionarVehiculos.php");
		
		if (!isset($_SESSION["formularioreparacion"]) ) {
			$formulario["TIPOESTADO"]="EN_PROGRESO";
			$formulario["RM"]="0";
			$formulario["HORAS"]="1";
			$_SESSION["formularioreparacion"] = $formulario;
		}else{
			$formulario=$_SESSION["formularioreparacion"];
		}
		
		$conexion = crearConexionBD();
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Crear nueva reparación</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="formReparacion.js"></script>
	</head>
<body>
<?php
	include_once("../compartida/cabecera.php");
?>
	<div id="titulo">
		<h3>Creación de una Reparación</h3> <!-- TODO PARA EVITAR QUE PUEDA CREAR MÁS REPARACIONES DEBERIA HACER UN NUEVO MÉTODO QUE COMPRUEBE LAS FACTURAS QUE TIENEN ASOCIADAS LAS ID DE LAS REPARACIONES EXISTENTES Y SI ALGUNA NO TIENE FACTURA, IMPEDIR AL USUARIO CREAR UNA REPARACION -->
	</div>
	<div id="div_form">
	<form form enctype="multipart/form-data" method="post" action="../reparaciones/tratamientoFormCrearReparacion.php" onsubmit="return procesarReparacion()" >
		<div id="div_vid">
			<label for="vid" id="label_vid">Vehículo:</label> <!-- TODO se podría hacer con JS -->
			<select name="vid" id="vid" onchange="procesarReparacion()">
				<option selected="selected" value="-1">Seleccione el vehículo</option>
				<?php 
					  $todosv=seleccionarTodosVehiculos($conexion);
					  foreach ($todosv as $v) {
					  	if($v["ABANDONADO"]!="1"){
						  ?>
						  <option value="<?php echo $v["V_ID"] ?>"><?php echo $v["MATRICULA"] ?></option>
						  <?php
						  }
					  } ?>
			</select>
			<div id="erroresvidreparacion"></div>
		</div>
		<div id="div_rm">
			<label for="rm" id="label_rm">Tipo:</label>
			<select name="rm" id="rm">
				<option selected="selected" value="0">Reparación</option>
				<option value="1">Mantenimiento</option>
			</select>
		</div>
		<div id="div_tipoestado">
			<label for="tipoestado" id="label_tipoestado">Estado:</label>
			<select name="tipoestado" id="tipoestado">
				<option selected="selected" value="EN_PROGRESO">En progreso</option>
				<option value="EN_ESPERA">En espera</option>
				<option value="COMPLETADO">Completado</option>
			</select>
		</div>
		<div id="div_horas">
			<label for="horas" id="label_horas">Horas:</label>
			<input id="horas" name="horas" type="text" onchange="procesarReparacion()" value="" size="15"></input>
			<div id="erroreshorasreparacion"></div>
		</div>
		<input type="submit" value="Crear"></input>
	</form>
	</div>
	<div id="volver">
		<form method="post" action="../reparaciones/reparaciones.php">
			<button id='volver' name='volver' type='submit' class='volver'>Volver</button>
		</form>
	</div>
<?php
	include_once("../compartida/pie.php");
	cerrarConexionBD($conexion);
?>
</body>
</html>
