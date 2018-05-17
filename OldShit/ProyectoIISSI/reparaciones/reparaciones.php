<?php
session_start();

require_once("../compartida/gestionarBD.php");
require_once("../compartida/gestionarReparaciones.php");

$conexion = crearConexionBD();

if (isset($_SESSION["reparacion"]))
	$reparacion = $_SESSION["reparacion"];
unset($_SESSION["reparacion"]);

if (isset($_REQUEST["completado"])){
	$completados=TRUE;
}else if(isset($_GET["completado"])){
	$completados=TRUE;
}else if(isset($_SESSION["completado"])){
	$completados=TRUE;
	unset($_SESSION["completado"]);
}else{	
	$completados=FALSE;
}

if(isset($_REQUEST["nocompletado"])){
	$completados=FALSE;
}	
if(isset($_SESSION["paginareparacion"]))
	$pagina = $_SESSION["paginareparacion"];
unset($_SESSION["paginareparacion"]);

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

$total = numeroReparacionesNoCompletadas($conexion);
$total_pages = ( $total / $page_size );
if ( $total % $page_size > 0 )
	$total_pages++;
if ( $page_num > $total_pages )
	$page_num = 1;

$pagina["PAGINA"]=$page_num;
$pagina["INTERVALO"]=$page_size;
$pagina["TOTAL"]=$total;
$_SESSION["paginareparacion"]=$pagina;

if(isset($_SESSION["paginareparacioncom"]))
	$paginacom = $_SESSION["paginareparacioncom"];
unset($_SESSION["paginareparacioncom"]);

if(isset($_GET["page_num_com"])){
	$page_num_com=(int)$_GET[ "page_num_com" ];
}else if(isset($pagina["PAGINACOM"])){
	$page_num_com=(int)$paginacom["PAGINACOM"];
}else{
	$page_num_com=1;
}

if(isset($_GET["page_size_com"])){
	$page_size_com=(int)$_GET[ "page_size_com" ];
}else if(isset($pagina["INTERVALOCOM"])){
	$page_size_com=(int)$paginacom["INTERVALOCOM"];
}else{
	$page_size_com=10;
}

if ( $page_num_com < 1 ) $page_num_com = 1;
if ( $page_size_com < 1 ) $page_size_com = 10;

$total_com = numeroReparacionesCompletadas($conexion);
$total_pages_com = ( $total_com / $page_size_com );
if ( $total_com % $page_size_com > 0 )
	$total_pages_com++;
if ( $page_num_com > $total_pages_com )
	$page_num_com = 1;

$pagina_com["PAGINACOM"]=$page_num_com;
$pagina_com["INTERVALOCOM"]=$page_size_com;
$pagina_com["TOTALCOM"]=$total_com;
$_SESSION["paginareparacioncom"]=$pagina_com;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
		<title>Gestión de Reparaciones/Mantenimientos</title>
		<link type="text/css" rel="stylesheet" href="../style/biblio.css">
		<script type="text/javascript" src="editReparacion.js"></script>
	</head>
<body>
<?php
	include_once("../compartida/cabecera.php");
?>
<div id="contenidos">

	<div id="reparaciones">
		<div id="crear_reparacion">
			<form method="post" action="../reparaciones/formCrearReparacion.php"> <!-- TODO NO DEBO DEJAR QUE EL USUARIO CREE MÁS DE 1 REPARACION (QUE NO ESTE COMPLETADA) POR VEHICULO -->
				<button id='CREAR' name='CREAR' type='submit' class='crear'>Crear reparación</button>
			</form>
		</div>
			<div id="titulo_reparaciones">
				<h3>REPARACIONES/MANTENIMIENTOS</h3>
			</div>
			<div id="erroresedicionreparacion"></div>
		<?php if($total!=0){ ?>
		<table id="tabla_listado">
			<tr>
				<th>Nº Reparación</th> <th>Estado</th> <th>Reparación/Mantenimiento</th> <th>Horas</th>  <th></th>
			</tr>
			<?php
			   	$filas = consultarPaginaReparacionesNoCompletadas($conexion,$page_num,$page_size,$total);
				foreach( $filas as $fila ) {
					//if($fila["TIPOESTADO"]!="COMPLETADO"){
						
			?>
			<tr class="reparacion">
			<form method="post" action="../reparaciones/procesarReparacion.php" onsubmit="return edicionReparacion()">
				<input id="RM_ID" name="RM_ID" type="hidden" value="<?php echo $fila["RM_ID"] ?>"/>
				<input id="C_ID" name="C_ID" type="hidden" value="<?php echo $fila["C_ID"] ?>"/>
				<input id="V_ID" name="V_ID" type="hidden" value="<?php echo $fila["V_ID"] ?>"/>
				<?php if ((isset($reparacion["editarreparacion"]) and $reparacion["editarreparacion"]) and $fila["RM_ID"]==$reparacion["RM_ID"]) { ?>
				<td class="rm_id"> <?php echo $fila['RM_ID']?> </td>
				<td class='tipoestado'>  <!-- TODO PUEDE HABER UN PROBLEMA CON EL TIPO ESTADO Y EL RESTO DE SELECT YA QUE NO TENGO EN CUENTA EL VALOR QUE VIENE -->
					<select name="TIPOESTADO" id="TIPOESTADO">
						<option value="EN_PROGRESO">En progreso</option>
						<option value="EN_ESPERA">En espera</option>
						<option value="COMPLETADO">Completado</option>
					</select>
				</td>
				
				<td class='rm'>  <!-- TODO PUEDE HABER UN PROBLEMA CON EL TIPO ESTADO Y EL RESTO DE SELECT YA QUE NO TENGO EN CUENTA EL VALOR QUE VIENE -->
					<select name="RM" id="RM">
						<option value="0">Reparación</option>
						<option value="1">Mantenimiento</option>
					</select>
				</td>
				<td class='horas'>
				<input id="HORAS" name="HORAS" type="text" size="14" onchange="edicionReparacion()" value="<?php echo $reparacion["HORAS"] ?>"/>
				</td>
				<?php }else{ ?>	
				<input id="TIPOESTADO" name="TIPOESTADO" type="hidden" value="<?php echo $fila["TIPOESTADO"] ?>"/>
				<input id="RM" name="RM" type="hidden" value="<?php echo $fila["RM"] ?>"/>
				<input id="HORAS" name="HORAS" type="hidden" value="<?php echo $fila["HORAS"] ?>"/>
				<td class="rm_id"> <?php echo $fila['RM_ID']?> </td>
				
				<?php if($fila["TIPOESTADO"]=="EN_PROGRESO"){ ?>
					<td class="tipoestado"> En progreso </td>
				<?php }else{ ?>
					<td class="tipoestado"> En espera </td>
				<?php } ?>
				
				<?php if($fila["RM"]=="0"){ ?>
					<td class="rm"> Reparación </td>
				<?php }else{ ?>
					<td class="rm"> Mantenimiento </td>
				<?php } ?>
				
				<td class="horas"> <?php echo $fila['HORAS']?> </td>
				
				<?php } ?>
				
				<td class="botones_fila">
				<?php
					  if ((isset($reparacion["editarreparacion"]) and $reparacion["editarreparacion"]) and $fila["RM_ID"]==$reparacion["RM_ID"]) { ?>
							<button id="grabarreparacion" name="grabarreparacion" type="submit" class="editar_fila"><img src="../images/grabar.bmp" class="editar_fila"></button>
				<?php }else { ?>
							<button id="editarreparacion" name="editarreparacion" type="submit" class="editar_fila"><img src="../images/editar.bmp" class="editar_fila"></button>
				<?php } ?>
					  <button id="quitarreparacion" name="quitarreparacion" type="submit" class="editar_fila"><img src="../images/eliminar.bmp" class="editar_fila"></button>
				</td>
			</form>
			</tr>
			<?php //} 
				}
			?>
		</table>
		<table id="tabla_paginacion">
			<tr>
				<td>
					<form method="get" action="../reparaciones/reparaciones.php">
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
						reparaciones/mantenimientos de <?php echo $total?>
						<input type="submit" value="Cambiar" />
					</form>
				</td>
			</tr>
		</table>
		<?php } ?>
		<table id="tabla_completados">
			<?php if(!$completados){ ?>
			<form method="post" action="../reparaciones/reparaciones.php">
				<button id='completado' name='completado' type="submit">Ver Reparaciones Completadas</button>
			</form>	
			<?php  }else{ ?>
			<form method="post" action="../reparaciones/reparaciones.php">
				<button id='nocompletado' name='nocompletado' type="submit">Dejar de ver Reparaciones Completadas</button>
			</form>	
			<div id="titulo_reparaciones">
				<h3>REPARACIONES/MANTENIMIENTOS COMPLETADOS</h3>
			</div>
			<?php if($total_com!=0){ ?>
			<table id="tabla_listado_com">
			<tr>
				<th>Nº Reparación</th> <th>Estado</th> <th>Reparación/Mantenimiento</th> <th>Horas</th>  <th></th>
			</tr>
			<?php
			   	$filascom = consultarPaginaReparacionesCompletadas($conexion,$page_num_com,$page_size_com,$total_com);
				foreach( $filascom as $filacom ) {
					//if($fila["TIPOESTADO"]!="COMPLETADO"){
						
			?>
			<tr class="reparacion">
			<form method="post" action="../reparaciones/procesarReparacionCompletada.php"> <!-- TODO DEBO HACERLO EN DIFERENTES YA QUE PUEDEN HABER CONFUSIONES (PERO basicamente son los mismos)--->
				<input id="RM_ID" name="RM_ID" type="hidden" value="<?php echo $filacom["RM_ID"] ?>"/>
				<!--<input id="TIPOESTADO" name="TIPOESTADO" type="hidden" value="<?php echo $filacom["TIPOESTADO"] ?>"/>
				<input id="RM" name="RM" type="hidden" value="<?php echo $filacom["RM"] ?>"/>
				<input id="HORAS" name="HORAS" type="hidden" value="<?php echo $filacom["HORAS"] ?>"/>
				<input id="C_ID" name="C_ID" type="hidden" value="<?php echo $filacom["C_ID"] ?>"/>
				<input id="V_ID" name="V_ID" type="hidden" value="<?php echo $filacom["V_ID"] ?>"/>-->
				
				<td class="rm_id"> <?php echo $filacom['RM_ID']?> </td>
				
				<?php if($filacom["TIPOESTADO"]=="COMPLETADO"){ ?>
					<td class="tipoestado"> Completado </td>
				<?php }else{ ?>
					<td class="tipoestado"> Desconocido </td> <!-- TODO PROVISIONAL -->
				<?php } ?>
				
				<?php if($filacom["RM"]=="0"){ ?>
					<td class="rm"> Reparación </td>
				<?php }else{ ?>
					<td class="rm"> Mantenimiento </td>
				<?php } ?>
				
				<td class="horas"> <?php echo $filacom['HORAS']?> </td>
				
				<td class="botones_fila"> <!-- TODO solamente hay un botón ya que solo se podrán borrar -->
					  <button id="quitarreparacioncom" name="quitarreparacioncom" type="submit" class="editar_fila"><img src="../images/eliminar.bmp" class="editar_fila"></button>
				</td>
			</form>
			</tr>
			<?php //} 
				}
			?>
		</table>
		<table id="tabla_paginacion_com">
			<tr>
				<td>
					<form method="get" action="../reparaciones/reparaciones.php">
						<input id="completado" name="completado" type="hidden" value="TRUE"/>
					<?php
						for( $page_com = 1; $page_com <= $total_pages_com; $page_com++ ) {
							if ( $page_com == $page_num_com ) {
					?>
								<button id='paginacion_com' name='paginacion_com' type='submit' class='seleccionada' value='' disabled='disabled'><?php echo $page_com?></button>
					<?php
							} else {
					?>
								<button id='page_num_com' name='page_num_com' type='submit' class='pagina' value='<?php echo $page_com?>'><?php echo $page_com?></button>
					<?php
							}
						}
					?>
						Mostrando
						<input id="page_size_com" name="page_size_com" type="number" min="1" max="<?php echo $total_com?>" value="<?php echo $page_size_com?>" autofocus="autofocus" />
						reparaciones/mantenimientos completados de <?php echo $total_com?>
						<input type="submit" value="Cambiar" />
					</form>
				</td>
			</tr>
		</table>
		<?php }
		 } ?>
		</table>
	</div>
</div>

<?php
	include_once("../compartida/pie.php");
	cerrarConexionBD($conexion);
?>
</body>
</html>
