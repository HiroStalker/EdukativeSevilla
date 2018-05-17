<?php
session_start();

require_once ("../compartida/gestionarBD.php");
require_once ("../compartida/gestionarUsuarios.php");

$conexion = crearConexionBD();

if (isset($_SESSION["usuario"]))
	$cliente = $_SESSION["usuario"];
unset($_SESSION["usuario"]);

if (isset($_SESSION["paginausuario"]))
	$pagina = $_SESSION["paginausuario"];
unset($_SESSION["paginacliente"]);

if (isset($_GET["page_num"])) {
	$page_num = (int)$_GET["page_num"];
} else if (isset($pagina["PAGINA"])) {
	$page_num = (int)$pagina["PAGINA"];
} else {
	$page_num = 1;
}

if (isset($_GET["page_size"])) {
	$page_size = (int)$_GET["page_size"];
} else if (isset($pagina["INTERVALO"])) {
	$page_size = (int)$pagina["INTERVALO"];
} else {
	$page_size = 10;
}

if ($page_num < 1)
	$page_num = 1;
if ($page_size < 1)
	$page_size = 10;

$total = numeroUsuario($conexion);
$total_pages = ($total / $page_size);
if ($total % $page_size > 0)
	$total_pages++;
if ($page_num > $total_pages)
	$page_num = 1;

$pagina["PAGINA"] = $page_num;
$pagina["INTERVALO"] = $page_size;
$pagina["TOTAL"] = $total;
$_SESSION["paginausuario"] = $pagina;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
		<title>Gestión de Clientes</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">  
	</head>
<body>
<?php
include_once ("../compartida/cabecera.php");
?>
<div id="contenidos">
   
	<div id="usuarios">
		<div id="crear_usuario">
			<form method="post" action="../Usuarios/formCrearUsuario.php">
				<button id='CREAR' name='CREAR' type='submit' class='crear'>Crear usuario</button>
			</form>	
		</div>
			<div id="titulo_usuario">
				<h3>USUARIOS</h3>
			</div>
		<?php if($total!=0){ ?>
		<table id="tabla_listado">	
			<tr>
				<th>Nombre</th> <th>Apellidos</th> <th>D.N.I.</th> <th></th>
			</tr>
			<?php
			   	$filas = consultarPaginUsuarios($conexion,$page_num,$page_size,$total);
				foreach( $filas as $fila ) {
			?>
			<tr class="cliente">
			<form method="post" action="../clientes/procesarCliente.php">
				<input id="U_ID" name="U_ID" type="hidden" value="<?php echo $fila["U_ID"] ?>"/>
				<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"] ?>"/>
				<input id="APELLIDOS" name="APELLIDOS" type="hidden" value="<?php echo $fila["APELLIDOS"] ?>"/>
				<input id="DNI" name="DNI" type="hidden" value="<?php echo $fila["DNI"] ?>"/>
				<input id="DIRECCION" name="DIRECCION" type="hidden" value="<?php echo $fila["DIRECCION"] ?>"/>
				<input id="POBLACION" name="POBLACION" type="hidden" value="<?php echo $fila["POBLACION"] ?>"/>
				<input id="NUMERODECUENTA" name="NUMERODECUENTA" type="hidden" value="<?php echo $fila ["NUMERODECUENTA"] ?>"/>
				<input id="CODIGOPOSTAL" name="CODIGOPOSTAL" type="hidden" value="<?php echo $fila["CODIGOPOSTAL"] ?>"/>
				<input id="NUMERODEIMPAGOS" name="NUMERODEIMPAGOS" type="hidden" value="<?php echo $fila["NUMERODEIMPAGOS"] ?>"/>	
				<input id="MOROSIDAD" name="MOROSIDAD" type="hidden" value="<?php echo $fila["MOROSIDAD"] ?>"/>
						
				<td class="nombre"> <?php echo $fila['NOMBRE']?> </td>
				<td class="apellidos"> <?php echo $fila['APELLIDOS']?> </td>
				<td class="dni"> <?php echo $fila['DNI']?> </td>
			   <!--
				<td class="botones_fila">
					  <button id="ver_vehiculos" name="ver_vehiculos" type="submit" class="editar_fila"><img src="../images/ver_vehiculos.bmp" class="editar_fila"></button>
				</td>
				*/	
				-->
			</form>
			</tr> 
			<?php } ?>
		</table>
		<table id="tabla_paginacion">
			<tr>
				<td>
					<form method="get" action="../usuarios/usuarios.php">
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
						clientes de <?php echo $total?>
						<input type="submit" value="Cambiar" />
					</form>
				</td>
			</tr>
		</table>
		<?php } ?>
	</div>	
</div>

<?php
include_once ("../compartida/pie.php");
cerrarConexionBD($conexion);
?>		
</body>
</html>
