<?php
session_start();

require_once("../compartida/gestionarBD.php");
require_once("../compartida/gestionarPiezas.php");

$conexion = crearConexionBD();

if (isset($_SESSION["pieza"]))
	$pieza = $_SESSION["pieza"];
unset($_SESSION["pieza"]);

if(isset($_SESSION["paginapieza"]))
	$pagina = $_SESSION["paginapieza"];
unset($_SESSION["paginapieza"]);

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

$total = numeroPiezas($conexion);
$total_pages = ( $total / $page_size );
if ( $total % $page_size > 0 ) 
	$total_pages++;
if ( $page_num > $total_pages )
	$page_num = 1;

$pagina["PAGINA"]=$page_num;
$pagina["INTERVALO"]=$page_size;
$pagina["TOTAL"]=$total;
$_SESSION["paginapieza"]=$pagina;
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
		<title>Gestión de Piezas</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">  
	</head>
<body>
<?php	
	include_once("../compartida/cabecera.php"); 
?>
<div id="contenidos">
   
	<div id="piezas">
		<div id="crear_pieza">
			<form method="post" action="../piezas/formCrearPieza.php">
				<button id='CREAR' name='CREAR' type='submit' class='crear'>Crear pieza</button>
			</form>	
		</div>
			<div id="titulo_piezas">
				<h3>PIEZAS</h3>
			</div>
		<?php if($total!=0){ ?>
		<table id="tabla_listado">	
			<tr>
				<th>Nombre</th> <th>Precio del Proveedor</th> <th>Stock</th>
			</tr>
			<?php
			   	$filas = consultarPaginaPiezas($conexion,$page_num,$page_size,$total);
				foreach( $filas as $fila ) {
			?>
			<tr class="pieza">
			<form method="post" action="../piezas/procesarPieza.php">
				<input id="P_ID" name="P_ID" type="hidden" value="<?php echo $fila["P_ID"] ?>"/>
				<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"] ?>"/>
				<input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $fila["CANTIDAD"] ?>"/>
				<input id="MARCA" name="MARCA" type="hidden" value="<?php echo $fila["MARCA"] ?>"/>
				<input id="TIPOCATEGORIA" name="TIPOCATEGORIA" type="hidden" value="<?php echo $fila["TIPOCATEGORIA"] ?>"/>
				<input id="PRECIOPROVEEDOR" name="PRECIOPROVEEDOR" type="hidden" value="<?php echo $fila["PRECIOPROVEEDOR"] ?>"/>
				<input id="PVP" name="PVP" type="hidden" value="<?php echo $fila["PVP"] ?>"/>
				<input id="CODIGO" name="CODIGO" type="hidden" value="<?php echo $fila["CODIGO"] ?>"/>	
				<input id="PV_ID" name="PV_ID" type="hidden" value="<?php echo $fila["PV_ID"] ?>"/>	
					
				<td class="nombre"> <?php echo $fila['NOMBRE']?> </td>
				<td class="precioproveedor"> <?php echo $fila['PRECIOPROVEEDOR']?> </td>
				<td class="cantidad"> <?php echo $fila['CANTIDAD']?> </td>

			</form>
			</tr> 
			<?php } ?>
			<td class="botones_fila">
				<?php
					  if ((isset($pieza["editarpieza"]) and $pieza["editarpieza"]) and $fila["P_ID"]==$pieza["P_ID"]) { ?>
							<button id="grabarpieza" name="grabarpieza" type="submit" class="editar_fila"><img src="../images/grabar.bmp" class="editar_fila"></button>
				<?php }else { ?>
							<button id="editarpieza" name="editarpieza" type="submit" class="editar_fila"><img src="../images/editar.bmp" class="editar_fila"></button>
				<?php } ?>
					  <button id="quitarpieza" name="quitarpieza" type="submit" class="editar_fila"><img src="../images/eliminar.bmp" class="editar_fila"></button>
				</td>
		</table>
		<table id="tabla_paginacion">
			<tr>
				<td>
					<form method="get" action="../piezas/piezas.php">
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
						piezas de <?php echo $total?>
						<input type="submit" value="Cambiar" />
					</form>
				</td>
			</tr>
		</table>
		<?php } ?>
	</div>	
</div>

<?php	
	include_once("../compartida/pie.php");
	cerrarConexionBD($conexion);
?>		
</body>
</html>
