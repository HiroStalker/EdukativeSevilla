<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
		session_start();

		require_once("../compartida/gestionarBD.php");
		require_once("../compartida/gestionarVehiculos.php");
		require_once("../compartida/gestionarFacturas.php");
		require_once("../compartida/gestionarReparaciones.php");
		require_once("../compartida/gestionarPiezas.php");

		$conexion = crearConexionBD();

		if (!isset($_SESSION["formulariopiezasusadas"]) ) {
			//var_dump($_REQUEST);
			//var_dump($_SESSION);
			//exit();
			if(isset($_REQUEST["CREAR"])){
				$formulario["F_ID"]=$_REQUEST["CREAR_F_ID"];
				$formulario["RM_ID"]=$_REQUEST["CREAR_RM_ID"];
			}else if (isset($_SESSION["F_ID"])){
				$facs=seleccionarFactura($conexion, $_SESSION["F_ID"]);
				$formulario["F_ID"]=$_SESSION["F_ID"];
				foreach($facs as $fac){
					$formulario["RM_ID"]=$fac["RM_ID"];
				}
				unset($_SESSION["F_ID"]);
			}else Header("../index.php");
				$formulario["CANTIDADUSADA"]="0";
				$formulario["PRECIOPORCANTIDAD"]="0.0";
				$_SESSION["formulariopiezasusadas"] = $formulario;
		}else{
			//var_dump($_REQUEST);
			//var_dump($_SESSION);
			//exit();
			$formulario=$_SESSION["formulariopiezasusadas"];
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
		<title>Crear nueva línea de factura</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
	</head>
<body>
<?php
	include_once("../compartida/cabecera.php");
?>
	<div id="titulo">
		<h3>Creación de una Línea de Factura</h3>
	</div>
	<div id="div_form">
	<form form enctype="multipart/form-data" method="post" action="../piezasusadas/tratamientoFormCrearPiezasUsadas.php">
		<input id="f_id" name="f_id" type="hidden" value="<?php echo $formulario["F_ID"] ?>"/>
		<input id="rm_id" name="rm_id" type="hidden" value="<?php echo $formulario["RM_ID"] ?>"/>
		<!--<input id="rm_id" name="rm_id" type="hidden" value="<?php echo $rmi ?>"/> -->
		<div id="div_pid">
			<label for="p_id" id="label_rmid">Pieza:</label>
			<select name="p_id" id="p_id">
				<option selected="selected" value="-1">Seleccione la pieza</option>
				<?php
					  $todosv=seleccionarTodasPiezas($conexion);
					  foreach ($todosv as $v) {
						  ?>
						  <option value="<?php echo $v["P_ID"] ?>"><?php echo $v["NOMBRE"] ?></option>
						  <?php
					  }
					   ?>
			</select>
		</div>
		<div id="div_cantidad">
			<label for="cantidad" id="label_cantidad">Cantidad:</label>
			<input id="cantidadusada" name="cantidadusada" type="text" value="" size="25"></input>
		</div>
		<input type="submit" value="Crear"></input>
	</form>
	</div>
	<div id="volver">
		<form method="post" action="../piezasusadas/piezasusadas.php">
			<input id="VOLVER_F_ID" name="VOLVER_F_ID" type="hidden" value="<?php echo $formulario["F_ID"] ?>"/>
			<button id='volver' name='volver' type='submit' class='crear'>Volver</button>
		</form>
	</div>
<?php
	cerrarConexionBD($conexion);
	include_once("../compartida/pie.php");
?>
</body>
</html>
