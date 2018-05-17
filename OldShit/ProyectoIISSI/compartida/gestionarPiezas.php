<?php
	function seleccionarTodasPiezas($conexion){
		try {
		$stmt = $conexion->prepare("SELECT PIEZAS.P_ID, PIEZAS.PV_ID, PIEZAS.NOMBRE, PIEZAS.CANTIDAD,"
			. "	PIEZAS.MARCA, PIEZAS.TIPOCATEGORIA, PIEZAS.PRECIOPROVEEDOR, PIEZAS.PVP, PIEZAS.CODIGO FROM PIEZAS");
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
	}

	function seleccionarPieza($con, $pid){
  	try {
		$stmt = $con->prepare("SELECT * FROM PIEZAS WHERE P_ID=:pid");
		$stmt->bindParam(':pid',$pid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
   }

	function numeroPiezas($conexion, $pvid)
  {
	try {
		$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT * FROM PIEZAS"
		. " WHERE PV_ID=:pvid ORDER BY P_ID, NOMBRE)";
		$stmt = $conexion->prepare( $total_query );
		$stmt -> bindParam(":pvid",$pvid);
		$stmt -> execute();
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

  function consultarPaginaPiezas($conexion,$pagina,$intervalo,$total,$pvid){
	try {
		$first = ($pagina - 1) * $intervalo + 1;
		$last = $pagina * $intervalo;
		$paged_query = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM ( SELECT PIEZAS.P_ID, PIEZAS.PV_ID, PIEZAS.NOMBRE, PIEZAS.CANTIDAD, PIEZAS.MARCA,"
			. "	PIEZAS.TIPOCATEGORIA, PIEZAS.PRECIOPROVEEDOR, PIEZAS.PVP, PIEZAS.CODIGO FROM PIEZAS WHERE PIEZAS.PV_ID=:pvid"
			. " ORDER BY P_ID, NOMBRE ) AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";
		$stmt = $conexion->prepare( $paged_query );
		$stmt->bindParam( ':first', $first );
		if($last>$total){
			$last=$total;
		}
		$stmt->bindParam( ':last', $last );
		$stmt->bindParam( ':pvid', $pvid );
		$stmt->execute();
		return $stmt;
	}catch ( PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
  }

  function meterPieza($con,$pvid,$nombre,$cantidad, $marca, $tipocategoria, $precioproveedor, $pvp, $codigo){
		try {
				$stmt = $con->prepare("INSERT INTO PIEZAS(NOMBRE, CANTIDAD, MARCA, TIPOCATEGORIA, PRECIOPROVEEDOR, PVP, CODIGO, PV_ID)"
					. " VALUES (:nombre, :cantidad, :marca, :tipocategoria, CAST(:precioproveedor as NUMBER(12,2)), CAST(:pvp as NUMBER(12,2)), :codigo, :pvid)");
				$stmt->bindParam(':nombre',$nombre);
				$stmt->bindParam(':cantidad',$cantidad);
				$stmt->bindParam(':marca',$marca);
				$stmt->bindParam(':tipocategoria',$tipocategoria);
				$stmt->bindParam(':precioproveedor',$precioproveedor);
				$stmt->bindParam(':pvp',$pvp);
				$stmt->bindParam(':codigo',$codigo);
				$stmt->bindParam(':pvid',$pvid);
				$stmt->execute();
				return "";
		}catch(PDOException $e ) {
			return $e->GetMessage();
			$_SESSION["error"]= $e->GetMessage();
			$_SESSION["destino"] = "piezasusadas/formCrearPiezasUsadas.php";
			Header("../error.php");
		}
  }

  /*function seleccionarPieza($con, $pid){
  	try {
		$stmt = $con->prepare("SELECT * FROM PIEZAS WHERE P_ID=:pid");
		$stmt->bindParam(':pid',pid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
}*/

   function quitarPieza($conexion,$pid) {
		try {
			$stmt=$conexion->prepare("DELETE FROM PIEZAS WHERE P_ID=:pid");
			$stmt->bindParam(':pid',$pid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}

	function modificarPieza($conexion,$pid,$nombre,$cantidad, $marca, $tipocategoria, $precioproveedor, $pvp, $codigo, $pvid) {
		try {
			$stmt=$conexion->prepare("UPDATE PIEZAS SET NOMBRE=:nombre, CANTIDAD=:cantidad, MARCA=:marca, TIPOCATEGORIA=:tipocategoria, "
					. "PRECIOPROVEEDOR=CAST(:precioproveedor as NUMBER(12,2)), PVP=CAST(:pvp as NUMBER(12,2)), CODIGO=:CODIGO, PV_ID=:pvid WHERE P_ID=:pid");
			$stmt->bindParam(':nombre',$nombre);
			$stmt->bindParam(':cantidad',$cantidad);
			$stmt->bindParam(':marca',$marca);
			$stmt->bindParam(':tipocategoria',$tipocategoria);
			$stmt->bindParam(':precioproveedor',$precioproveedor);
			$stmt->bindParam(':pvp',$pvp);
			$stmt->bindParam(':codigo',$codigo);
			$stmt->bindParam(':pvid',$pvid);
			$stmt->bindParam(':pid',$pid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}

	/*function seleccionarTodasPiezas($conexion){
		try {
		$stmt = $conexion->prepare("SELECT PIEZAS.P_ID, PIEZAS.PV_ID, PIEZAS.NOMBRE, PIEZAS.CANTIDAD,"
			. "	PIEZAS.MARCA, PIEZAS.TIPOCATEGORIA, PIEZAS.PRECIOPROVEEDOR, PIEZAS.PVP, PIEZAS.CODIGO FROM PIEZAS");
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
}*/

?>
