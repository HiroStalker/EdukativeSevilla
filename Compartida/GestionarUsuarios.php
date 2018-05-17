<?php
function numerousuarios($conexion) {
	try {
		$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT * FROM usuarios" . " ORDER BY NOMBRE, APELLIDOS, DNI)";
		$stmt = $conexion -> query($total_query);
		$result = $stmt -> fetch();
		$total = $result['TOTAL'];
		return (int)$total;
	} catch ( PDOException $e ) {
		$_SESSION["error"] = $e -> GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
}

function consultarPaginaUsuarios($conexion, $pagina, $intervalo, $total) {
	try {
		$first = ($pagina - 1) * $intervalo + 1;
		$last = $pagina * $intervalo;
		$paged_query = "SELECT * FROM (
		SELECT ROWNUM RNUM, AUX.* FROM ( SELECT USUARIO.U_ID,
		USUARIOS.NOMBRE, USUARIOS.APELLIDOS, USUARIOS.DNI,
		" . "	USUARIOS.DIRECCION, USUARIOS.POBLACION,
		USUARIO.NUMERODECUENTA, 
		USUARIO.CODIGOPOSTAL,
		USUARIO.TELEFONO, 
		USUARIO.NUMERODEIMPAGOS, 
		USUARIO.TIPOusuario,
		USUARIO.MOROSIDAD," . " 
		USUARIO.TIPOusuario FROM usuarios" . " 
		ORDER BY NOMBRE, APELLIDOS, DNI ) 
		AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";

		$stmt = $conexion -> prepare($paged_query);
		$stmt -> bindParam(':first', $first);
		if ($last > $total) {
			$last = $total;
		}
		$stmt -> bindParam(':last', $last);
		$stmt -> execute();
		return $stmt;
	} catch ( PDOException $e ) {
		$_SESSION["error"] = $e -> GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
}

function meterUsuario($con, $nombre, $apellidos, $dni, $direccion, $poblacion, $numerodecuenta, $codigopostal,$telefono, $numerodeimpagos,$tipousuario, $morosidad) {
	try {
		$stmt = $con -> prepare("INSERT INTO usuarios(NOMBRE, APELLIDOS, DNI, DIRECCION, POBLACION, NUMERODECUENTA, CODIGOPOSTAL,TELEFONO, NUMEROIMPAGOS,TIPOusuario, MOROSIDAD)
			" . " VALUES (:nombre, :apellidos, :dni, :direccion, :poblacion,:numerodecuenta, :codigopostal,:telefono, :numerodecuenta,:tipousuario ,:morosidad)");
		$stmt -> bindParam(':nombre', $nombre);
		$stmt -> bindParam(':apellidos', $apellidos);
		$stmt -> bindParam(':dni', $dni);
		$stmt -> bindParam(':direccion', $direccion);
		$stmt -> bindParam(':poblacion', $poblacion);
		$stmt -> bindParam(':numerodecuenta', $numerodecuenta);
		$stmt -> bindParam(':codigopostal', $codigopostal);
		$stmt -> bindParam(':telefono', $telefono);
		$stmt -> bindParam(':numerodeimpagos', $numerodeimpagos);
		$stmt -> bindParam(':tipousuario', $tipousuario);
		$stmt -> bindParam(':morosidad', $morosidad);
		$stmt -> execute();
		return "";
	} catch(PDOException $e ) {
		return $e -> GetMessage();
		$_SESSION["error"] = $e -> GetMessage();
		$_SESSION["destino"] = "usuarios/formCrearUsuarios.php";
		Header("../error.php");
	}
}

function seleccionarUsuario($con, $cid) {
	try {
		$stmt = $con -> prepare("SELECT * FROM USUARIOS WHERE U_ID=:u_id");
		$stmt -> bindParam(':u_id', $u_id);
		$stmt -> execute();
	} catch(PDOException $e ) {
		$_SESSION["error"] = $e -> GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
}

function quitarUsuario($conexion, $u_id) {//TODO: MUY IMPORTANTE, LUEGO HAY QUE CAMBIAR ESTO Y HACER QUE SOLAMENTE BORRE SINO TIENE COSAS IMPORTANTES ASIGNADAS
	try {
		$stmt = $conexion -> prepare("DELETE FROM usuarios WHERE C_ID=:cid");
		$stmt -> bindParam(':u_id', $u_id);
		$stmt -> execute();
		return "";
	} catch(PDOException $e) {
		return $e -> GetMessage();
	}
}

function modificarUsuario($conexion, $cid, $nombre, $apellidos, $dni, $direccion, $poblacion,$numerodecuenta, $codigopostal, $telefono, $numerodeimpagos,$tipousuario,$morosidad) {
	try {
		$stmt = $conexion -> prepare("UPDATE usuarios SET NOMBRE=:nombre, APELLIDOS=:apellidos, DNI=:dni, DIRECCION=:direccion, POBLACION=:poblacion,NUMERODECUENTA=:numerodecuenta, CODIGOPOSTAL=:codigopostal," . " TELEFONO=:telefono,NUMERODEIMPAGOS=:numerodeimpagos, TIPOusuario=:tipousuario, MOROSIDAD=:morosidad" . " WHERE U_ID=:u_id");
		$stmt -> bindParam(':nombre', $nombre);
		$stmt -> bindParam(':apellidos', $apellidos);
		$stmt -> bindParam(':dni', $dni);
		$stmt -> bindParam(':direccion', $direccion);
		$stmt -> bindParam(':poblacion', $poblacion);
		$stmt -> bindParam(':numerodecuenta', $numerodecuenta);
		$stmt -> bindParam(':codigopostal', $codigopostal);
		$stmt -> bindParam(':telefono', $TELEFONO);
		$stmt -> bindParam(':numerodeimpagos', $numerodeimpagos);
		$stmt -> bindParam(':morosidad', $morosidad);
		$stmt -> bindParam(':u_id', $u_id);
		$stmt -> execute();
		return "";
	} catch(PDOException $e) {
		return $e -> GetMessage();
	}
}
?>
