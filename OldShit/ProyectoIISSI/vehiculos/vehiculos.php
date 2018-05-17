<?php
session_start();
	require_once("../compartida/gestionarBD.php");
	require_once("../compartida/gestionarClientes.php");
	require_once("../compartida/gestionarVehiculos.php");

	$conexion = crearConexionBD();

if (isset($_REQUEST["VOLVER_C_ID"])){
	$clis=seleccionarCliente($conexion,$_REQUEST["VOLVER_C_ID"]);
	foreach ($clis as $cli) {
		$_SESSION["cliente"]=$cli;
	}
}
if (isset($_SESSION["C_ID"])){
	$clis=seleccionarCliente($conexion,$_SESSION["C_ID"]);
	foreach ($clis as $cli) {
		$_SESSION["cliente"]=$cli;
	}
	unset($_SESSION["C_ID"]);
}
if(isset($_GET["cid"])){
	$clis=seleccionarCliente($conexion,(int)$_GET["cid"]);
	foreach ($clis as $cli) {
		$_SESSION["cliente"]=$cli;
	}
}
if (isset($_SESSION["cliente"])) {
	$cliente = $_SESSION["cliente"];
unset($_SESSION["cliente"]);
}else Header("Location:../index.php");

if(isset($_SESSION["paginavehiculo"]))
	$pagina = $_SESSION["paginavehiculo"];
unset($_SESSION["paginavehiculo"]);

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

$total = numeroVehiculos($conexion, $cliente["C_ID"]);
$total_pages = ( $total / $page_size );
if ( $total % $page_size > 0 )
	$total_pages++;
if ( $page_num > $total_pages )
	$page_num = 1;

$pagina["PAGINA"]=$page_num;
$pagina["INTERVALO"]=$page_size;
$pagina["TOTAL"]=$total;
$_SESSION["paginavehiculo"]=$pagina;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF8">
		<title>Gestión de Vehículos</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="editCliente.js"></script>
	</head>
<body>
	<?php
		include_once("../compartida/cabecera.php");
	?>
	<div id="crear_vehiculo">
			<form method="post" action="../vehiculos/formCrearVehiculo.php">
				<input id="CREAR_C_ID" name="CREAR_C_ID" type="hidden" value="<?php echo $cliente["C_ID"] ?>"/>
				<button id='CREAR' name='CREAR' type='submit' class='crear'>Crear vehículo</button>
			</form>
	</div>
	<div id="titulo_clientes">
		<h3>CLIENTE</h3>
	</div>
	<div id="erroresedicioncliente"></div>
	<table id="tabla_cliente">
		<tr>
			<th>Nombre</th> <th>Apellidos</th> <th>D.N.I</th> <th>Dirección</th> <th>Población</th> <th>Código Postal</th> <th>Teléfono</th> <th>Conflictivo</th> <th>Visitas</th>
			<th>Número Cuenta</th> <th>Número Impagos</th> <th>Tipo</th> <th>Edad</th>
		</tr>
		<tr class="cliente">
			<form name="a" method="post" action="../clientes/procesarCliente.php" onsubmit="return edicionCliente()">
				<input id="C_ID" name="C_ID" type="hidden" value="<?php echo $cliente["C_ID"] ?>"/>
				<?php if (isset($cliente["editarcliente"]) and $cliente["editarcliente"]) { ?>
						<td class='nombre'>
						<input id="NOMBRE" name="NOMBRE" type="text" size="15" onchange="edicionCliente()" value="<?php echo $cliente["NOMBRE"]; ?>"/>
						</td>
						<td class='apellidos'>
						<input id="APELLIDOS" name="APELLIDOS" type="text" size="15" onchange="edicionCliente()" value="<?php echo $cliente["APELLIDOS"]; ?>"/>
						</td>
						<td class='dni'>
						<input id="DNI" name="DNI" type="text" size="8" maxlength="9" onchange="edicionCliente()" value="<?php echo $cliente["DNI"]; ?>"/>
						</td>
						<td class='direccion'>
						<input id="DIRECCION" name="DIRECCION" type="text" size="13" onchange="edicionCliente()" value="<?php echo $cliente["DIRECCION"]; ?>"/>
						</td>
						<td class='poblacion'>
						<input id="POBLACION" name="POBLACION" type="text" size="10" onchange="edicionCliente()" value="<?php echo $cliente["POBLACION"]; ?>"/>
						</td>
						<td class='codigopostal'>
						<input id="CODIGOPOSTAL" name="CODIGOPOSTAL" type="text" size="5" maxlength="5" onchange="edicionCliente()" value="<?php echo $cliente["CODIGOPOSTAL"]; ?>"/>
						</td>
						<td class='telefono'>
							+34
						<input id="TELEFONO" name="TELEFONO" type="text" size="10" maxlength="9" onchange="edicionCliente()" value="<?php echo $cliente["TELEFONO"]; ?>"/>
						</td>
						<td class='conflictivo'>
							<select name="CONFLICTIVO" id="CONFLICTIVO">
								<option selected="selected" value="0">No</option>
								<option value="1">Sí</option>
							</select>
						</td>
						<td class='visitas'>
						<!--<input id="VISITAS" name="VISITAS" type="text" size="8" value="<?php echo $cliente["VISITAS"]; ?>"/>-->
						<input id="VISITAS" name="VISITAS" type="hidden" value="<?php echo $cliente["VISITAS"]; ?>"/>
						<div id="vis"><?php echo $cliente['VISITAS']?></div>
						<button id="INCVISITAS" name="INCVISITAS" type="submit" onclick="incrementaVisitas()">Incrementar</button>
						</td>
						<td class='numerocuenta'>
							ES
							<input id="NUMEROCUENTA" name="NUMEROCUENTA" type="text" size="25" maxlength="22" onchange="edicionCliente()" value="<?php echo $cliente["NUMEROCUENTA"]; ?>"/>
						</td>
						<td class='numeroimpagos'>
						<!--<input id="NUMEROIMPAGOS" name="NUMEROIMPAGOS" type="text" size="14" value="<?php echo $cliente["NUMEROIMPAGOS"]; ?>"/>-->
						<input id="NUMEROIMPAGOS" name="NUMEROIMPAGOS" type="hidden" value="<?php echo $cliente["NUMEROIMPAGOS"]; ?>"/>
						<div id="imp"><?php echo $cliente['NUMEROIMPAGOS']?></div>
						<button id="INCIMPAGOS" name="INCIMPAGOS" type="submit" onclick="incrementaImpagos()">Incrementar</button>
						</td>
						<td class='tipocliente'>
							<select name="TIPOCLIENTE" id="TIPOCLIENTE">
								<option selected="selected" value="PARTICULAR">Particular</option>
								<option value="EMPRESA">Empresa</option>
							</select>
						<td class='edad'>
						<input id="EDAD" name="EDAD" type="text" size="5" onchange="edicionCliente()" value="<?php echo $cliente["EDAD"]; ?>"/>
						</td>
				<?php } else { ?>
					<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $cliente["NOMBRE"] ?>"/>
					<input id="APELLIDOS" name="APELLIDOS" type="hidden" value="<?php echo $cliente["APELLIDOS"] ?>"/>
					<input id="DNI" name="DNI" type="hidden" value="<?php echo $cliente["DNI"] ?>"/>
					<input id="DIRECCION" name="DIRECCION" type="hidden" value="<?php echo $cliente["DIRECCION"] ?>"/>
					<input id="POBLACION" name="POBLACION" type="hidden" value="<?php echo $cliente["POBLACION"] ?>"/>
					<input id="CODIGOPOSTAL" name="CODIGOPOSTAL" type="hidden" value="<?php echo $cliente["CODIGOPOSTAL"] ?>"/>
					<input id="TELEFONO" name="TELEFONO" type="hidden" value="<?php echo $cliente["TELEFONO"] ?>"/>
					<input id="CONFLICTIVO" name="CONFLICTIVO" type="hidden" value="<?php echo $cliente["CONFLICTIVO"] ?>"/>
					<input id="VISITAS" name="VISITAS" type="hidden" value="<?php echo $cliente["VISITAS"] ?>"/>
					<input id="NUMEROCUENTA" name="NUMEROCUENTA" type="hidden" value="<?php echo $cliente["NUMEROCUENTA"] ?>"/>
					<input id="NUMEROIMPAGOS" name="NUMEROIMPAGOS" type="hidden" value="<?php echo $cliente["NUMEROIMPAGOS"] ?>"/>
					<input id="TIPOCLIENTE" name="TIPOCLIENTE" type="hidden" value="<?php echo $cliente["TIPOCLIENTE"] ?>"/>
					<input id="EDAD" name="EDAD" type="hidden" value="<?php echo $cliente["EDAD"] ?>"/>
						<td class="nombre"> <?php echo $cliente['NOMBRE']?> </td>
						<td class="apellidos"> <?php echo $cliente['APELLIDOS']?> </td>
						<td class="dni"> <?php echo $cliente['DNI']?> </td>
						<td class="direccion"> <?php echo $cliente['DIRECCION']?> </td>
						<td class="poblacion"> <?php echo $cliente['POBLACION']?> </td>
						<td class="codigopostal"> <?php echo $cliente['CODIGOPOSTAL']?> </td>
						<td class="telefono"> +34 <?php echo $cliente['TELEFONO']?> </td>
						<?php if($cliente['CONFLICTIVO']==0){ ?>
							<td class="conflictivo"> No </td>
						<?php }else{ ?>
							<td class="conflictivo"> Sí </td>
						<?php } ?>
						<td class="visitas"> <?php echo $cliente['VISITAS']?> </td>
						<td class="numerocuenta">
							<?php if ($cliente["NUMEROCUENTA"]==""){?>
								Indefinido
							<?php }else{ ?>
								ES<?php echo $cliente['NUMEROCUENTA']?>
							<?php } ?>
						</td>
						<td class="numeroimpagos"> <?php echo $cliente['NUMEROIMPAGOS']?> </td>
						<?php if($cliente['TIPOCLIENTE']=="PARTICULAR"){ ?>
							<td class="tipocliente">Particular</td>
						<?php }else{ ?>
							<td class="tipocliente">Empresa</td>
						<?php } ?>
						<td class="edad"> <?php echo $cliente['EDAD']?> </td>
				<?php } ?>
				<td class="botones_fila">
				<?php
					  if (isset($cliente["editarcliente"]) and $cliente["editarcliente"]) { ?>
							<button id="grabarcliente" name="grabarcliente" type="submit" class="editar_fila"><img src="../images/grabar.bmp" class="editar_fila"></button>
				<?php }else { ?>
							<button id="editarcliente" name="editarcliente" type="submit" class="editar_fila"><img src="../images/editar.bmp" class="editar_fila"></button>
				<?php } ?>
					  <button id="quitarcliente" name="quitarcliente" type="submit" class="editar_fila"><img src="../images/eliminar.bmp" class="editar_fila"></button>
				</td>
				</div>
			</form>
		</tr>
	</table>
	<?php
		  if($total!=0){
	?>
	<div id="titulo_vehiculos">
		<h3>VEHÍCULOS</h3>
	</div>
	<table id="vehiculos">
				<tr>
					<th>Matrícula</th> <th>Marca</th> <th>Modelo</th>
				</tr>
			<?php
			    $filas = consultarPaginaVehiculos($conexion,$page_num,$page_size,$total,$cliente["C_ID"]);
				foreach($filas as $fila) {
			?>
			<tr class="vehiculo">
				<form method="post" action="../vehiculos/procesarVehiculo.php">
					<input id="V_ID" name="V_ID" type="hidden" value="<?php echo $fila["V_ID"] ?>"/>
					<input id="MATRICULA" name="MATRICULA" type="hidden" value="<?php echo $fila["MATRICULA"] ?>"/>
					<input id="MARCA" name="MARCA" type="hidden" value="<?php echo $fila["MARCA"] ?>"/>
					<input id="MODELO" name="MODELO" type="hidden" value="<?php echo $fila["MODELO"] ?>"/>
					<input id="CHASIS" name="CHASIS" type="hidden" value="<?php echo $fila["CHASIS"] ?>"/>
					<input id="COLOR" name="COLOR" type="hidden" value="<?php echo $fila["COLOR"] ?>"/>
					<input id="KMS" name="KMS" type="hidden" value="<?php echo $fila["KMS"] ?>"/>
					<input id="ABANDONADO" name="ABANDONADO" type="hidden" value="<?php echo $fila["ABANDONADO"] ?>"/>
					<input id="C_ID" name="C_ID" type="hidden" value="<?php echo $fila["C_ID"] ?>"/>

					<td class="matricula"><?php echo $fila["MATRICULA"] ?></td>
					<td class="marca"><?php echo $fila["MARCA"] ?></td>
					<td class="modelo"><?php echo $fila["MODELO"] ?></td>

					<td class="botones_fila">
						 <button id="ver_facturas" name="ver_facturas" type="submit" class="editar_fila"><img src="../images/ver_vehiculos.bmp" class="editar_fila"></button>
					</td>
				</form>
			</tr>

		<?php } ?>
	</table>
	<table id="tabla_paginacion">
			<tr>
				<td>
					<form method="get" action="../vehiculos/vehiculos.php">
						<input id="cid" name="cid" type="hidden" value="<?php echo $cliente["C_ID"] ?>"/>
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
				</td>
				<td>
						Mostrando
						<input id="page_size" name="page_size" type="number" min="1" max="<?php echo $total?>" value="<?php echo $page_size?>" autofocus="autofocus" />
						vehículos de <?php echo $total?>
						<input type="submit" value="Cambiar" />
					</form>
				</td>
			</tr>
	</table>
	<?php } ?>
	<div id="volver">
		<form method="post" action="../clientes/clientes.php">
			<button id='volver' name='volver' type='submit' class='crear'>Volver</button>
		</form>
	</div>
<?php
	include_once("../compartida/pie.php");
	cerrarConexionBD($conexion);
?>
</body>
</html>
