<?php
session_start();
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarVehiculos.php");
	require_once("../compartida/gestionarFacturas.php");
	require_once("../compartida/gestionarReparaciones.php");

	$conexion = crearConexionBD();


if (isset($_REQUEST["VOLVER_V_ID"])){
	$vehis=seleccionarVehiculo($conexion,$_REQUEST["VOLVER_V_ID"]);
	foreach ($vehis as $vehi) {
		$_SESSION["vehiculo"]=$vehi;
	}
}
if (isset($_SESSION["V_ID"])){
	$vehis=seleccionarVehiculo($conexion,$_SESSION["V_ID"]);
	foreach ($vehis as $vehi) {
		$_SESSION["vehiculo"]=$vehi;
	}
	unset($_SESSION["V_ID"]);
}
if(isset($_GET["vid"])){
	$vehis=seleccionarVehiculo($conexion,(int)$_GET["vid"]);
	foreach ($vehis as $vehi) {
		$_SESSION["vehiculo"]=$vehi;
	}
}
if (isset($_SESSION["vehiculo"])) {
	$vehiculo = $_SESSION["vehiculo"];
unset($_SESSION["vehiculo"]);
}else Header("Location:../index.php");

if(isset($_SESSION["paginafactura"]))
	$pagina = $_SESSION["paginafactura"];
unset($_SESSION["paginafactura"]);

if(isset($_GET["page_num"])){
	$page_num=(int)$_GET[ "page_num" ];
}else if(isset($pagina["PAGINA"])){
	$page_num=(int)$pagina["PAGINA"];
}else{
	$page_num=1;
}

if(isset($_GET["page_size"])){
	$page_size=(int)$_GET[ "page_size" ];
}else if(isset($pagina["INTERVALO"])){
	$page_size=(int)$pagina["INTERVALO"];
}else{
	$page_size=10;
}

if ( $page_num < 1 ) $page_num = 1;
if ( $page_size < 1 ) $page_size = 10;

/*$reparaciones=seleccionarReparacionVid($conexion, $vehiculo["V_ID"]);
$total=0;
foreach ($reparaciones as $reparacion) {
	$total = $total+numeroFacturas($conexion, $reparacion["RM_ID"]);
}*/

//$rmi="-1"; //TODO podría ahorrarme el calculo en el formulario enviando este dato por el boton de crear
//$total=0;
$ws=array();
/*$ti=numeroReparacionesVid($conexion, $vehiculo["V_ID"]);
$to=numeroFacturas($conexion, $vehiculo["C_ID"]);
$filasv=consultarReparacionesVid($conexion, 1, $ti, $ti, $vehiculo["V_ID"]);
$filasc=consultarFacturas($conexion, 1, $to, $to, $vehiculo["C_ID"]);
*/
$filasv=seleccionarReparacionVid($conexion, $vehiculo["V_ID"]);
$filasc=seleccionarFacturaCid($conexion, $vehiculo["C_ID"]);
//var_dump($filasv);
//exit();
foreach($filasv as $filav){
	foreach($filasc as $filac){
		if($filav["RM_ID"]==$filac["RM_ID"]){
			array_push($ws,$filac);
		}

		//var_dump($filav);
	//$rmi=$fila["RM_ID"];
	//array_push($ws,$filac["RM_ID"]);
	//var_dump($ws);
	}
}
$total=sizeof($ws);
//var_dump($total);
//exit();

//exit();
/*$i=0;
$fas=array();
$filasv=seleccionarReparacionVid($conexion, $vehiculo["V_ID"]);
foreach($filasv as $filav){
	if(in_array($filav["RM_ID"], $ws)){

	}
}
*/
/*if($rmi=="-1"){
	$total=0;
}else{
	$total = numeroFacturas($conexion, $rmi);*/
	//var_dump($total);
	//exit();
//}

$total_pages = ( $total / $page_size );
if ( $total % $page_size > 0 )
	$total_pages++;
if ( $page_num > $total_pages )
	$page_num = 1;

$pagina["PAGINA"]=$page_num;
$pagina["INTERVALO"]=$page_size;
$pagina["TOTAL"]=$total;
$_SESSION["paginafactura"]=$pagina;


?>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF8">
		<title>Gestión de Facturas</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="editVehiculo.js"></script>
	</head>
<body>
	<?php
		include_once("../compartida/cabecera.php");
	?>
	<div id="crear_factura">
			<form method="post" action="../facturas/formCrearFactura.php"> <!-- TODO Con C_ID y V_ID podemos saber la reparación y sabiendo la reparació podemos crear la factura-->
				<input id="CREAR_C_ID" name="CREAR_C_ID" type="hidden" value="<?php echo $vehiculo["C_ID"] ?>"/>
				<input id="CREAR_V_ID" name="CREAR_V_ID" type="hidden" value="<?php echo $vehiculo["V_ID"] ?>"/>
				<button id='CREAR' name='CREAR' type='submit' class='crear'>Crear factura</button>
			</form>
	</div>
	<div id="titulo_vehiculo">
		<h3>VEHÍCULO</h3>
	</div>
	<div id="erroresedicionvehiculo"></div>
	<table id="tabla_vehiculo">
		<tr>
			<th>Matrícula</th> <th>Marca</th> <th>Modelo</th> <th>Chasis</th> <th>Color</th> <th>Kilometraje</th> <th>Abandonado</th> <!-- TODO: hay que tener en cuenta el abandonado, ¿otro boton en menú principal? -->
		</tr>
		<tr class="vehiculo">
			<form method="post" action="../vehiculos/procesarVehiculo.php" onsubmit="return edicionVehiculo()">
				<input id="C_ID" name="C_ID" type="hidden" value="<?php echo $vehiculo["C_ID"] ?>"/>
				<input id="V_ID" name="V_ID" type="hidden" value="<?php echo $vehiculo["V_ID"] ?>"/>

				<?php if (isset($vehiculo["editarvehiculo"]) and $vehiculo["editarvehiculo"]) { ?>
						<td class='matricula'>
						<input id="MATRICULA" name="MATRICULA" type="text" size="15" onchange="edicionVehiculo()" value="<?php echo $vehiculo["MATRICULA"]; ?>"/>
						</td>
						<td class='marca'>
						<input id="MARCA" name="MARCA" type="text" size="15" onchange="edicionVehiculo()" value="<?php echo $vehiculo["MARCA"]; ?>"/>
						</td>
						<td class='modelo'>
						<input id="MODELO" name="MODELO" type="text" size="15" onchange="edicionVehiculo()" value="<?php echo $vehiculo["MODELO"]; ?>"/>
						</td>
						<td class='chasis'>
						<input id="CHASIS" name="CHASIS" type="text" size="10" onchange="edicionVehiculo()" value="<?php echo $vehiculo["CHASIS"]; ?>"/>
						</td>
						<td class='color'>
						<input id="COLOR" name="COLOR" type="text" size="10" onchange="edicionVehiculo()" value="<?php echo $vehiculo["COLOR"]; ?>"/>
						</td>
						<td class='kms'>
						<input id="KMS" name="KMS" type="text" size="10" onchange="edicionVehiculo()" value="<?php echo $vehiculo["KMS"]; ?>"/>
						</td>
						<td class='abandonado'>
							<select name="ABANDONADO" id="ABANDONADO">
								<option selected="selected" value="0">No</option>
								<option value="1">Sí</option>
							</select>
						</td>
				<?php } else { ?>
					<input id="MATRICULA" name="MATRICULA" type="hidden" value="<?php echo $vehiculo["MATRICULA"] ?>"/>
					<input id="MARCA" name="MARCA" type="hidden" value="<?php echo $vehiculo["MARCA"] ?>"/>
					<input id="MODELO" name="MODELO" type="hidden" value="<?php echo $vehiculo["MODELO"] ?>"/>
					<input id="CHASIS" name="CHASIS" type="hidden" value="<?php echo $vehiculo["CHASIS"] ?>"/>
					<input id="COLOR" name="COLOR" type="hidden" value="<?php echo $vehiculo["COLOR"] ?>"/>
					<input id="KMS" name="KMS" type="hidden" value="<?php echo $vehiculo["KMS"] ?>"/>
					<input id="ABANDONADO" name="ABANDONADO" type="hidden" value="<?php echo $vehiculo["ABANDONADO"] ?>"/>
						<td class="matricula"> <?php echo $vehiculo['MATRICULA']?> </td>
						<td class="marca"> <?php echo $vehiculo['MARCA']?> </td>
						<td class="modelo"> <?php echo $vehiculo['MODELO']?> </td>
						<td class="chasis"> <?php echo $vehiculo['CHASIS']?> </td>
						<td class="color"> <?php echo $vehiculo['COLOR']?> </td>
						<td class="kms"> <?php echo $vehiculo['KMS']?> </td>
						<?php if($vehiculo['ABANDONADO']==0){ ?>
							<td class="abandonado"> No </td>
						<?php }else{ ?>
							<td class="abandonado"> Sí </td>
						<?php } ?>
				<?php } ?>
				<td class="botones_fila">
				<?php
					  if (isset($vehiculo["editarvehiculo"]) and $vehiculo["editarvehiculo"]) { ?>
							<button id="grabarvehiculo" name="grabarvehiculo" type="submit" class="editar_fila"><img src="../images/grabar.bmp" class="editar_fila"></button>
				<?php }else { ?>
							<button id="editarvehiculo" name="editarvehiculo" type="submit" class="editar_fila"><img src="../images/editar.bmp" class="editar_fila"></button>
				<?php } ?>
					  <button id="quitarvehiculo" name="quitarvehiculo" type="submit" class="editar_fila"><img src="../images/eliminar.bmp" class="editar_fila"></button>
				</td>
			</form>
		</tr>
	</table>
	<?php
		  if($total!=0){
	?>
	<div id="titulo_facturas">
		<h3>FACTURAS</h3>
	</div>
	<table id="facturas">
				<tr>
					<th>Nº Factura</th> <th>Fecha Emisión</th> <th>Precio Total</th> <th>Abonado</th> <th></th>
				</tr>
			<?php
				//foreach($filas as $fila){ //TODO: Habría que ver si funciona
			   // $facs = consultarPaginaFacturas($conexion,$page_num,$page_size,$total,$fila["RM_ID"]);
				foreach($ws as $fac) {
			?>
			<tr class="factura">
				<form method="post" action="../facturas/procesarFactura.php"> <!-- TODO IMPORTANTE, NO PERMITIR QUE MODIFICE EL ID_FACTURA-->
					<input id="F_ID" name="F_ID" type="hidden" value="<?php echo $fac["F_ID"] ?>"/>
					<input id="PRECIOTOTAL" name="PRECIOTOTAL" type="hidden" value="<?php echo $fac["PRECIOTOTAL"] ?>"/> <!--TODO HACERLO COMO UN STRING YA QUE DA IGUAL LA RELACION DE PRECIOS -->
					<input id="ABONADO" name="ABONADO" type="hidden" value="<?php echo $fac["ABONADO"] ?>"/>
					<input id="FECHAINICIO" name="FECHAINICIO" type="hidden" value="<?php echo $fac["FECHAINICIO"] ?>"/>
					<input id="FECHAFIN" name="FECHAFIN" type="hidden" value="<?php echo $fac["FECHAFIN"] ?>"/>
					<input id="C_ID" name="C_ID" type="hidden" value="<?php echo $fac["C_ID"] ?>"/>
					<input id="RM_ID" name="RM_ID" type="hidden" value="<?php echo $fac["RM_ID"] ?>"/>

					<td class="fid"><?php echo $fac["F_ID"] ?></td>
					<td class="fechainicio"><?php echo $fac["FECHAINICIO"] ?></td>
					<td class="preciototal"><?php echo $fac["PRECIOTOTAL"] ?></td>
					<?php if($fac["ABONADO"]==0){ ?>
						<td class="abonado">No</td>
					<?php }else{ ?>
						<td class="abonado">Sí</td>
					<?php } ?>

					<td class="botones_fila">
						 <button id="ver_lineareparacion" name="ver_lineareparacion" type="submit" class="editar_fila"><img src="../images/ver_vehiculos.bmp" class="editar_fila"></button>
					</td>
				</form>
			</tr>

		<?php //}
		  } ?>
	</table>
	<table id="tabla_paginacion">
			<tr>
				<td>
					<form method="get" action="../facturas/facturas.php">
						<input id="vid" name="vid" type="hidden" value="<?php echo $vehiculo["V_ID"] ?>"/>
					<?php
						for( $page = 1; $page <= $total_pages; $page++ ) {
							if ( $page == $page_num ) {
					?>
								<button id='paginacion' name='paginacion' type='submit' class='seleccionada' value='' disabled='disabled'><?php echo $page?></button>
					<?php
							} else {
					?>
								<button id='page_num' name='page_num' type='submit' class='pagina' value='<?php echo $page?>'><?php echo $page?></button>
					<?php
							}
						}
					?>
						Mostrando
						<input id="page_size" name="page_size" type="number" min="1" max="<?php echo $total?>" value="<?php echo $page_size?>" autofocus="autofocus" />
						facturas de <?php echo $total?>
						<input type="submit" value="Cambiar" />
					</form>
				</td>
			</tr>
	</table>
	<?php } ?>
	<div id="volver">
		<form method="post" action="../vehiculos/vehiculos.php">
			<input id="VOLVER_C_ID" name="VOLVER_C_ID" type="hidden" value="<?php echo $vehiculo["C_ID"] ?>"/>
			<button id='volver' name='volver' type='submit' class='crear'>Volver</button>
		</form>
	</div>
<?php
	include_once("../compartida/pie.php");
	cerrarConexionBD($conexion);
?>
</body>
</html>
