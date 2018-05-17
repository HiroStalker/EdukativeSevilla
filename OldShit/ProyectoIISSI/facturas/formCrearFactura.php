<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
		session_start();

		require_once("../compartida/gestionarBD.php");
		require_once("../compartida/gestionarVehiculos.php");
		require_once("../compartida/gestionarFacturas.php");
		require_once("../compartida/gestionarReparaciones.php");

		$conexion = crearConexionBD();

		if (!isset($_SESSION["formulariofactura"]) ) {
			if(isset($_REQUEST["CREAR"])){
				$formulario["V_ID"]=$_REQUEST["CREAR_V_ID"];
				$formulario["C_ID"]=$_REQUEST["CREAR_C_ID"];
			}else if (isset($_SESSION["V_ID"])){
				$vehis=seleccionarVehiculo($conexion,$_SESSION["V_ID"]);
				$formulario["V_ID"]=$_SESSION["V_ID"];
				foreach ($vehis as $vehi) {
					$formulario["C_ID"]=$vehi["C_ID"];
				}
				unset($_SESSION["V_ID"]);
			}else Header("../index.php");
				$formulario["ABONADO"]="0";
				$formulario["FECHAINICIO"]="";
				$formulario["FECHAFIN"]="";
				$_SESSION["formulariofactura"] = $formulario;
		}else{
			$formulario=$_SESSION["formulariofactura"];
		}



		/*$rmi=-1;
		$filas=seleccionarReparacionVid($conexion, $formulario["V_ID"]);
		foreach($filas as $fila){
			if($fila["TIPOESTADO"]!="COMPLETADO"){
				$rmi=$fila["RM_ID"];
			}else if($rmi==-1){
				$rmi=$fila["RM_ID"];
			}
		}*/
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Crear nueva factura</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="formFactura.js"></script>
	</head>
<body>
<?php
	include_once("../compartida/cabecera.php");
?>
	<div id="titulo">
		<h3>Creación de una Factura</h3><!-- TODO PARA CREAR UNA FACTURA DEBO ASOCIARLA A UNA REPARACION PARA ELLO COMPRUEBO LAS REPARACIONES EXISTENTES CON EL MÉTODO EN BUSCA DE ALGUNA QUE NO TENGA FACTURA, SI LA ENCUENTRO ESA ES, SINO LA ENCUENTRO IMPIDO AL USUARIO CREAR UNA FACTURA (Además de lo de completado..) -->
	</div>
	<div id="div_form">
	<form form enctype="multipart/form-data" method="post" action="../facturas/tratamientoFormCrearFactura.php" onsubmit="return procesarFactura()">
		<input id="c_id" name="c_id" type="hidden" value="<?php echo $formulario["C_ID"] ?>"/>
		<input id="v_id" name="v_id" type="hidden" value="<?php echo $formulario["V_ID"] ?>"/>
		<!--<input id="rm_id" name="rm_id" type="hidden" value="<?php echo $rmi ?>"/> -->
		<div id="div_rmid">
			<label for="rm_id" id="label_rmid">Nº Reparación:</label>
			<select name="rm_id" id="rm_id" onchange="procesarFactura()">
				<option selected="selected" value="-1">Seleccione la reparación</option>
				<?php
					  $todosv=seleccionarTodasReparaciones($conexion, $formulario["V_ID"]);
					  foreach ($todosv as $v) {
					  	if($v["TIPOESTADO"]=="COMPLETADO"){
						  ?>
						  <option value="<?php echo $v["RM_ID"] ?>"><?php echo $v["RM_ID"] ?></option>
						  <?php
						  }
					  }
					   ?>
			</select>
			<div id="erroresrmidfactura"></div>
		</div>
		<div id="div_abonado">
			<label for="abonado" id="label_abonado">Abonado:</label>
			<select name="abonado" id="abonado">
				<option selected="selected" value="0">No</option>
				<option value="1">Sí</option>
			</select>
		</div>
	<!--	<div id="div fechainicio">
			<label for="fechainicio" id="label_fechainicio">Fecha Inicio:</label>
			<input id="fechainicio" name="fechainicio" type="text" value="" size="25"></input>
		</div>-->
		<div id="div preciototal">
			<label for="preciototal" id="label_fechainicio">Precio total:</label>
			<input id="preciototal" name="preciototal" type="text" onchange="procesarFactura()" value="" size="25"></input>
			<div id="errorespreciototalfactura"></div>
		</div>
		<input type="submit" value="Crear"></input>
	</form>
	</div>
	<div id="volver">
		<form method="post" action="../facturas/facturas.php">
			<input id="VOLVER_V_ID" name="VOLVER_V_ID" type="hidden" value="<?php echo $formulario["V_ID"] ?>"/>
			<button id='volver' name='volver' type='submit' class='crear'>Volver</button>
		</form>
	</div>
<?php
	cerrarConexionBD($conexion);
	include_once("../compartida/pie.php");
?>
</body>
</html>
