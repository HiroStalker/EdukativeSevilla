<?php
	function numeroPiezasUsadas($conexion, $lrid)
  {
	try {
		$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT * FROM LINEAREPARACIONES"
		. " WHERE LR_ID=:lrid ORDER BY LR_ID)";
		$stmt = $conexion->prepare( $total_query );
		$stmt -> bindParam(":lrid",$lrid);
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

  function consultarPaginaPiezasUsadas($conexion,$pagina,$intervalo,$total,$rmid){
	try {
		$first = ($pagina - 1) * $intervalo + 1;
		$last = $pagina * $intervalo;
		$paged_query = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM ( SELECT LINEAREPARACIONES.LR_ID, LINEAREPARACIONES.RM_ID, LINEAREPARACIONES.P_ID, LINEAREPARACIONES.CANTIDADUSADA,"
			. "	LINEAREPARACIONES.PRECIOPORCANTIDAD FROM LINEAREPARACIONES WHERE LINEAREPARACIONES.RM_ID=:rmid ORDER BY LINEAREPARACIONES.LR_ID ) AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";
		$stmt = $conexion->prepare( $paged_query );
		$stmt->bindParam( ':first', $first );
		if($last>$total){
			$last=$total;
		}
		$stmt->bindParam( ':last', $last );
		$stmt->bindParam( ':rmid', $rmid );
		$stmt->execute();
		return $stmt;
	}catch ( PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
  }

  function meterPiezasUsadas($con,$pid,$rmid,$precioporcantidad, $cantidadusada){
		try {

				$stmt = $con->prepare("INSERT INTO LINEAREPARACIONES(CANTIDADUSADA, PRECIOPORCANTIDAD, P_ID, RM_ID)"
					. " VALUES (:cantidadusada, CAST(:precioporcantidad as NUMBER(12,2)), :pid, :rmid)");
				$stmt->bindParam(':cantidadusada',$cantidadusada);
				$stmt->bindParam(':precioporcantidad',$precioporcantidad);
				$stmt->bindParam(':pid',$pid);
				$stmt->bindParam(':rmid',$rmid);
				$stmt->execute();
				return "";
		}catch(PDOException $e ) {
			return $e->GetMessage();
			$_SESSION["error"]= $e->GetMessage();
			$_SESSION["destino"] = "piezasusadas/formCrearPiezasUsadas.php";
			Header("../error.php");
		}
  }

  function quitarPiezasUsadas($conexion,$lrid) {
		try {
			$stmt=$conexion->prepare("DELETE FROM LINEAREPARACIONES WHERE LR_ID=:lrid");
			$stmt->bindParam('lrid',$lrid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}

	function modificarPiezasUsadas($conexion,$lrid,$pid,$rmid,$precioporcantidad, $cantidadusada) {
		try {

			$stmt=$conexion->prepare("UPDATE LINEAREPARACIONES SET PRECIOPORCANTIDAD=CAST(:precioporcantidad as NUMBER(12,2)), CANTIDADUSADA=:cantidadusada, RM_ID=:rmid, P_ID=:pid "
				  . " WHERE LR_ID=:lrid");
			$stmt->bindParam(':precioporcantidad',$precioporcantidad);
			$stmt->bindParam(':cantidadusada',$cantidadusada);
			$stmt->bindParam(':rmid',$rmid);
			$stmt->bindParam(':pid',$pid);
			$stmt->bindParam(':lrid',$lrid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }

	}

?>
