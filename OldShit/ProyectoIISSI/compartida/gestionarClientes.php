<?php
function numeroClientes($conexion){
	try {
		$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT * FROM CLIENTES"
		. " ORDER BY NOMBRE, APELLIDOS, DNI)";
		$stmt = $conexion->query( $total_query );
		$result = $stmt->fetch();
		$total = $result['TOTAL'];
		return (int)$total;
	}
	catch ( PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
}

function consultarPaginaClientes($conexion,$pagina,$intervalo,$total){
	try {
		$first = ($pagina - 1) * $intervalo + 1;
		$last = $pagina * $intervalo;
		$paged_query = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM ( SELECT CLIENTES.C_ID, CLIENTES.NOMBRE, CLIENTES.APELLIDOS, CLIENTES.DNI," 
		. "	CLIENTES.DIRECCION, CLIENTES.POBLACION, CLIENTES.CODIGOPOSTAL, CLIENTES.TELEFONO, CLIENTES.CONFLICTIVO, CLIENTES.VISITAS,"
		. " CLIENTES.NUMEROCUENTA, CLIENTES.NUMEROIMPAGOS, CLIENTES.TIPOCLIENTE, CLIENTES.EDAD FROM CLIENTES"
		. " ORDER BY NOMBRE, APELLIDOS, DNI ) AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";
		$stmt = $conexion->prepare( $paged_query );
		$stmt->bindParam( ':first', $first );
		if($last>$total){
			$last=$total;
		}
		$stmt->bindParam( ':last', $last );
		$stmt->execute();
		return $stmt;
	}
	catch ( PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php"); 
	}
}

function meterCliente($con,$nombre,$apellidos,$dni, $direccion, $poblacion, $codigopostal, $telefono, 
	$conflictivo, $visitas, $numerocuenta, $numeroimpagos, $tipocliente, $edad){
	try {
		$stmt = $con->prepare("INSERT INTO CLIENTES(NOMBRE, APELLIDOS, DNI, DIRECCION, POBLACION, CODIGOPOSTAL, TELEFONO, CONFLICTIVO, VISITAS, NUMEROCUENTA, NUMEROIMPAGOS, TIPOCLIENTE, EDAD)"
			. " VALUES (:nombre, :apellidos, :dni, :direccion, :poblacion, :codigopostal, :telefono, :conflictivo, :visitas, :numerocuenta, :numeroimpagos, :tipocliente, :edad)");				
		$stmt->bindParam(':nombre',$nombre);
		$stmt->bindParam(':apellidos',$apellidos);
		$stmt->bindParam(':dni',$dni);
		$stmt->bindParam(':direccion',$direccion);
		$stmt->bindParam(':poblacion',$poblacion);
		$stmt->bindParam(':codigopostal',$codigopostal);
		$stmt->bindParam(':telefono',$telefono);
		$stmt->bindParam(':conflictivo',$conflictivo);
		$stmt->bindParam(':visitas',$visitas);
		$stmt->bindParam(':numerocuenta',$numerocuenta);
		$stmt->bindParam(':numeroimpagos',$numeroimpagos);
		$stmt->bindParam(':tipocliente',$tipocliente);
		$stmt->bindParam(':edad',$edad);
		$stmt->execute();
		return "";
	}catch(PDOException $e ) {
		return $e->GetMessage();
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "clientes/formCrearCliente.php";
		Header("../error.php");
	}
}

function seleccionarCliente($con, $cid){
	try {
		$stmt = $con->prepare("SELECT * FROM CLIENTES WHERE C_ID=:cid");
		$stmt->bindParam(':cid',$cid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
}

	function quitarCliente($conexion,$cid) {  //TODO: MUY IMPORTANTE, LUEGO HAY QUE CAMBIAR ESTO Y HACER QUE SOLAMENTE BORRE SINO TIENE COSAS IMPORTANTES ASIGNADAS
		try {
			$stmt=$conexion->prepare("DELETE FROM CLIENTES WHERE C_ID=:cid");
			$stmt->bindParam(':cid',$cid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
		}
	}

	function modificarCliente($conexion,$cid,$nombre,$apellidos,$dni, $direccion, $poblacion, $codigopostal, $telefono, 
		$conflictivo, $visitas, $numerocuenta, $numeroimpagos, $tipocliente, $edad) {
		try {
			$stmt=$conexion->prepare("UPDATE CLIENTES SET NOMBRE=:nombre, APELLIDOS=:apellidos, DNI=:dni, DIRECCION=:direccion, POBLACION=:poblacion, CODIGOPOSTAL=:codigopostal,"
				. " TELEFONO=:telefono, CONFLICTIVO=:conflictivo, VISITAS=:visitas, NUMEROCUENTA=:numerocuenta, NUMEROIMPAGOS=:numeroimpagos, TIPOCLIENTE=:tipocliente, EDAD=:edad"
				. " WHERE C_ID=:cid");
			$stmt->bindParam(':nombre',$nombre);
			$stmt->bindParam(':apellidos',$apellidos);
			$stmt->bindParam(':dni',$dni);
			$stmt->bindParam(':direccion',$direccion);
			$stmt->bindParam(':poblacion',$poblacion);
			$stmt->bindParam(':codigopostal',$codigopostal);
			$stmt->bindParam(':telefono',$telefono);
			$stmt->bindParam(':conflictivo',$conflictivo);
			$stmt->bindParam(':visitas',$visitas);
			$stmt->bindParam(':numerocuenta',$numerocuenta);
			$stmt->bindParam(':numeroimpagos',$numeroimpagos);
			$stmt->bindParam(':tipocliente',$tipocliente);
			$stmt->bindParam(':edad',$edad);
			$stmt->bindParam(':cid',$cid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
		}
	}
	?>	