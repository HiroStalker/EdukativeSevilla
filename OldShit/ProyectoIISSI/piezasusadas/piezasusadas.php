<?php
session_start();
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarVehiculos.php");
	require_once("../compartida/gestionarFacturas.php");
	require_once("../compartida/gestionarReparaciones.php");
	require_once("../compartida/gestionarPiezasUsadas.php");

	$conexion = crearConexionBD();


if (isset($_REQUEST["VOLVER_F_ID"])){
	//var_dump($_REQUEST["VOLVER_F_ID"]);
	//exit();
	$factus=seleccionarFactura($conexion,$_REQUEST["VOLVER_F_ID"]);
	foreach ($factus as $factu) {
		$_SESSION["factura"]=$factu;
	}
}
if (isset($_SESSION["F_ID"])){
	//var_dump($_SESSION["F_ID"]);
	//exit();
	$factus=seleccionarFactura($conexion,$_SESSION["F_ID"]);
	foreach ($factus as $factu) {
		$_SESSION["factura"]=$factu;
	}
	unset($_SESSION["F_ID"]);
}
if(isset($_GET["fid"])){
	$factus=seleccionarFactura($conexion,(int)$_GET["fid"]);
	foreach ($factus as $factu) {
		$_SESSION["factura"]=$factu;
	}
}

if (isset($_SESSION["factura"])) {
	$factura = $_SESSION["factura"];
unset($_SESSION["factura"]);
}else Header("Location:../index.php");

if (isset($_SESSION["piezasusadas"])) {
	$factura = $_SESSION["piezasusadas"];
unset($_SESSION["piezasusadas"]);
}// else Header("Location:../index.php");

if(isset($_SESSION["paginapiezasusadas"]))
	$pagina = $_SESSION["paginapiezasusadas"];
unset($_SESSION["paginapiezasusadas"]);

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


$total=numeroPiezasUsadas($conexion, $factura["RM_ID"]);;
$total_pages = ( $total / $page_size );
if ( $total % $page_size > 0 )
	$total_pages++;
if ( $page_num > $total_pages )
	$page_num = 1;

$pagina["PAGINA"]=$page_num;
$pagina["INTERVALO"]=$page_size;
$pagina["TOTAL"]=$total;
$_SESSION["paginapiezasusadas"]=$pagina;

$aax=seleccionarVidRmid($conexion,$factura["RM_ID"]);
foreach($aax as $aa){
	$a=$aa;
}
//var_dump($factura["FECHAFIN"]);
//exit();
?>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF8">
		<title>Gestión de Líneas de la Factura</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="editFactura.js"></script>
	</head>
<body>
	<?php
		include_once("../compartida/cabecera.php");
	?>
	<div id="crear_pieza_usada">
			<form method="post" action="../piezasusadas/formCrearPiezasUsadas.php"> <!-- TODO Con C_ID y V_ID podemos saber la reparación y sabiendo la reparació podemos crear la factura-->
				<input id="CREAR_F_ID" name="CREAR_F_ID" type="hidden" value="<?php echo $factura["F_ID"] ?>"/>
				<input id="CREAR_RM_ID" name="CREAR_RM_ID" type="hidden" value="<?php echo $factura["RM_ID"] ?>"/>
				<button id='CREAR' name='CREAR' type='submit' class='crear'>Crear Línea Reparación</button>
			</form>
	</div>
	<div id="titulo_factura">
		<h3>FACTURA</h3>
	</div>
	<div id="erroresedicionfactura"></div>
	<table id="tabla_factura">
		<tr>
				<th>Nº Factura</th> <th>Fecha Emisión</th> <th>Precio Total</th> <th>Abonado</th> <th>Fecha Fin</th> <th></th>
		</tr>
		<tr class="factura">
			<form method="post" action="../facturas/procesarFactura.php" onsubmit="return edicionFactura()">
				<input id="F_ID" name="F_ID" type="hidden" value="<?php echo $factura["F_ID"] ?>"/>
				<input id="FECHAINICIO" name="FECHAINICIO" type="hidden" value="<?php echo $factura["FECHAINICIO"] ?>"/>
				<input id="C_ID" name="C_ID" type="hidden" value="<?php echo $factura["C_ID"] ?>"/>
				<input id="RM_ID" name="RM_ID" type="hidden" value="<?php echo $factura["RM_ID"] ?>"/>
				<input id="V_ID" name="V_ID" type="hidden" value="<?php echo $a["V_ID"] ?>"/>

				<?php if (isset($factura["editarfactura"]) and $factura["editarfactura"]) { ?>
					<td class="fid"><?php echo $factura["F_ID"] ?></td>
					<td class="fechainicio"><?php echo $factura["FECHAINICIO"] ?></td>
					<td class="preciototal">
							<input id="PRECIOTOTAL" name="PRECIOTOTAL" type="text" size="15" onchange="edicionFactura()" value="<?php echo $factura["PRECIOTOTAL"]; ?>"/>
					</td>
					<td class='abonado'>
						<select name="ABONADO" id="ABONADO" onchange="edicionFactura()">
							<option selected="selected" value="0">No</option>
							<option value="1">Sí</option>
						</select>
					</td>
					<td class="fechafin">
							<input id="FECHAFIN" name="FECHAFIN" type="text" size="15" onchange="edicionFactura()" value="<?php echo $factura["FECHAFIN"]; ?>"/>
					</td>
				<?php } else { ?>
					<input id="PRECIOTOTAL" name="PRECIOTOTAL" type="hidden" value="<?php echo $factura["PRECIOTOTAL"] ?>"/>
					<input id="ABONADO" name="ABONADO" type="hidden" value="<?php echo $factura["ABONADO"] ?>"/>
					<input id="FECHAFIN" name="FECHAFIN" type="hidden" value="<?php echo $factura["FECHAFIN"] ?>"/>
					<td class="fid"><?php echo $factura["F_ID"] ?></td>
					<td class="fechainicio"><?php echo $factura["FECHAINICIO"] ?></td>
					<td class="preciototal"><?php echo $factura["PRECIOTOTAL"] ?></td>
					<?php if($factura["ABONADO"]==0){ ?>
						<td class="abonado">No</td>
					<?php }else{ ?>
						<td class="abonado">Sí</td>
					<?php } ?>
					<td class="fechafin"><?php if($factura["FECHAFIN"]==""){
											echo "Indefinida";
										}else{
											echo $factura["FECHAFIN"];
										}  ?></td>
				<?php } ?>
				<td class="botones_fila">
				<?php
					  if (isset($factura["editarfactura"]) and $factura["editarfactura"]) { ?>
							<button id="grabarfactura" name="grabarfactura" type="submit" class="editar_fila"><img src="../images/grabar.bmp" class="editar_fila"></button>
				<?php }else { ?>
							<button id="editarfactura" name="editarfactura" type="submit" class="editar_fila"><img src="../images/editar.bmp" class="editar_fila"></button>
				<?php } ?>
					  <button id="quitarfactura" name="quitarfactura" type="submit" class="editar_fila"><img src="../images/eliminar.bmp" class="editar_fila"></button>
				</td>
			</form>
		</tr>
	</table>
	<?php
		  if($total!=0){
	?>
	<div id="titulo_piezas_usadas">
		<h3>LÍNEAS DE FACTURA</h3>
	</div>
	<table id="piezas_usadas">
				<tr>
					<th>Nº Pieza Usada</th> <th>Cantidad usada</th> <th>Precio por cantidad</th> <th></th>
				</tr>
			<?php
				$filas = consultarPaginaPiezasUsadas($conexion,$page_num,$page_size,$total,$factura["RM_ID"]);
				foreach($filas as $fila) {
			?>
			<tr class="piezas_usadas">
				<form method="post" action="../piezasusadas/procesarPiezasUsadas.php">
					<input id="LR_ID" name="LR_ID" type="hidden" value="<?php echo $fila["LR_ID"] ?>"/>
					<input id="CANTIDADUSADA" name="CANTIDADUSADA" type="hidden" value="<?php echo $fila["CANTIDADUSADA"] ?>"/>
					<input id="PRECIOPORCANTIDAD" name="PRECIOPORCANTIDAD" type="hidden" value="<?php echo $fila["PRECIOPORCANTIDAD"] ?>"/>
					<input id="P_ID" name="P_ID" type="hidden" value="<?php echo $fila["P_ID"] ?>"/>
					<input id="RM_ID" name="RM_ID" type="hidden" value="<?php echo $fila["RM_ID"] ?>"/>
					<input id="F_ID" name="F_ID" type="hidden" value="<?php echo $factura["F_ID"] ?>"/>
					<?php if ((isset($piezasusadas["editarpiezasusadas"]) and $piezasusadas["editarpiezasusadas"]) and $fila["LR_ID"]==$piezasusadas["LR_ID"]) { ?>
						<td class="lrid"><?php echo $fila["LR_ID"] ?></td>
						<input id="CANTIDADUSADA" name="CANTIDADUSADA" type="text" size="14" value="<?php echo $fila["CANTIDADUSADA"] ?>"/>
						<td class="precioporcantidad"><?php echo $fila["PRECIOPORCANTIDAD"] ?></td>
					<?php }else	{ ?>
					<td class="lrid"><?php echo $fila["LR_ID"] ?></td>
					<td class="cantidadusada"><?php echo $fila["CANTIDADUSADA"] ?></td>
					<td class="precioporcantidad"><?php echo $fila["PRECIOPORCANTIDAD"] ?></td>
					<?php } ?>
					<td class="botones_fila">
						<?php
							  if ((isset($piezasusadas["editarpiezasusadas"]) and $piezasusadas["editarpiezasusadas"]) and  $fila["LR_ID"]==$piezasusadas["LR_ID"]) { ?>
									<button id="grabarpiezasusadas" name="grabarpiezasusadas" type="submit" class="editar_fila"><img src="../images/grabar.bmp" class="editar_fila"></button>
						<?php }else { ?>
									<button id="editarpiezasusadas" name="editarpiezasusadas" type="submit" class="editar_fila"><img src="../images/editar.bmp" class="editar_fila"></button>
						<?php } ?>
							  <button id="quitarpiezasusadas" name="quitarpiezasusadas" type="submit" class="editar_fila"><img src="../images/eliminar.bmp" class="editar_fila"></button>
					</td>
				</form>
			</tr>

		<?php //}
		  } ?>
	</table>
	<table id="tabla_paginacion">
			<tr>
				<td>
					<form method="get" action="../piezasusadas/piezasusadas.php">
						<input id="fid" name="fid" type="hidden" value="<?php echo $factura["F_ID"] ?>"/>
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
		<form method="post" action="../facturas/facturas.php">
			<input id="VOLVER_V_ID" name="VOLVER_V_ID" type="hidden" value="<?php echo $a["V_ID"] ?>"/>
			<button id='volver' name='volver' type='submit' class='crear'>Volver</button>
		</form>
	</div>
<?php
	include_once("../compartida/pie.php");
	cerrarConexionBD($conexion);
?>
</body>
</html>
