<?php
	function seleccionarReparacionVid($con, $vid){
  	try {
		$stmt = $con->prepare("SELECT * FROM REPARACIONES WHERE REPARACIONES.V_ID=:vid");
		$stmt->bindParam(':vid',$vid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt ->fetchAll();
   }
   /*
	function numeroReparacionesVid($conexion,$vid){
		try {
			$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT DISTINCT RM_ID FROM REPARACIONES GROUP BY V_ID=:vid ORDER BY RM_ID)";
			$stmt = $conexion->prepare( $total_query );
			$stmt->bindParam(':vid',$vid);
			$stmt->execute();
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

	function consultarReparacionesVid($conexion,$pagina,$intervalo,$total,$vid){
		try {
			$first = ($pagina - 1) * $intervalo + 1;
			$last = $pagina * $intervalo;
			$paged_query = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM ( SELECT DISTINCT REPARACIONES.RM_ID, REPARACIONES.TIPOESTADO, REPARACIONES.RM, REPARACIONES.HORAS,"
				. "	REPARACIONES.C_ID, REPARACIONES.V_ID FROM REPARACIONES GROUP BY REPARACIONES.V_ID=:vid ORDER BY RM_ID) AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";
			$stmt = $conexion->prepare( $paged_query );
			$stmt->bindParam(':vid',$vid);
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
	*/
	function numeroReparacionesNoCompletadas($conexion){
		try {
			$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT * FROM REPARACIONES WHERE TIPOESTADO IN ('EN_PROGRESO', 'EN_ESPERA')"
				. " ORDER BY RM_ID)";
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

	function consultarPaginaReparacionesNoCompletadas($conexion,$pagina,$intervalo,$total){
		try {
			$first = ($pagina - 1) * $intervalo + 1;
			$last = $pagina * $intervalo;
			$paged_query = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM ( SELECT REPARACIONES.RM_ID, REPARACIONES.TIPOESTADO, REPARACIONES.RM, REPARACIONES.HORAS,"
				. "	REPARACIONES.C_ID, REPARACIONES.V_ID FROM REPARACIONES WHERE REPARACIONES.TIPOESTADO IN ('EN_PROGRESO', 'EN_ESPERA') ORDER BY RM_ID) AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";
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

	function numeroReparacionesCompletadas($conexion){
		try {
			$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT * FROM REPARACIONES WHERE TIPOESTADO='COMPLETADO'"
				. " ORDER BY RM_ID)";
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

	function consultarPaginaReparacionesCompletadas($conexion,$pagina,$intervalo,$total){
		try {
			$first = ($pagina - 1) * $intervalo + 1;
			$last = $pagina * $intervalo;
			$paged_query = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM ( SELECT REPARACIONES.RM_ID, REPARACIONES.TIPOESTADO, REPARACIONES.RM, REPARACIONES.HORAS,"
				. "	REPARACIONES.C_ID, REPARACIONES.V_ID FROM REPARACIONES WHERE REPARACIONES.TIPOESTADO='COMPLETADO' ORDER BY RM_ID) AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";
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

	function meterReparacion($con,$tipoestado,$rm,$horas, $cid, $vid){
		try {
				$stmt = $con->prepare("INSERT INTO REPARACIONES(TIPOESTADO, RM, HORAS, C_ID, V_ID)"
					. " VALUES (:tipoestado, :rm, :horas, :cid, :vid)");
				$stmt->bindParam(':tipoestado',$tipoestado);
				$stmt->bindParam(':rm',$rm);
				$stmt->bindParam(':horas',$horas);
				$stmt->bindParam(':cid',$cid);
				$stmt->bindParam(':vid',$vid);
				$stmt->execute();
				return "";
		}catch(PDOException $e ) {
			return $e->GetMessage();
		}
	 }

	function seleccionarReparacion($con, $rmid){
  	try {
		$stmt = $con->prepare("SELECT * FROM REPARACIONES WHERE RM_ID=:rmid");
		$stmt->bindParam(':rmid',$rmid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
    }

	function quitarReparacion($conexion,$rmid) {
		try {
			$stmt=$conexion->prepare("DELETE FROM REPARACIONES WHERE RM_ID=:rmid");
			$stmt->bindParam(':rmid',$rmid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}

	function modificarReparacion($conexion,$rmid,$tipoestado,$rm,$horas, $cid, $vid) {
		try {
			$stmt=$conexion->prepare("UPDATE REPARACIONES SET TIPOESTADO=:tipoestado, RM=:rm, HORAS=:horas, C_ID=:cid, V_ID=:vid WHERE RM_ID=:rmid");
			$stmt->bindParam(':tipoestado',$tipoestado);
			$stmt->bindParam(':rm',$rm);
			$stmt->bindParam(':horas',$horas);
			$stmt->bindParam(':cid',$cid);
			$stmt->bindParam(':vid',$vid);
			$stmt->bindParam(':rmid',$rmid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}

	function seleccionarTodasReparaciones($conexion, $vid){
		try {
		$stmt = $conexion->prepare("SELECT REPARACIONES.RM_ID, REPARACIONES.C_ID, REPARACIONES.V_ID, REPARACIONES.HORAS,"
			. "	REPARACIONES.RM, REPARACIONES.TIPOESTADO FROM REPARACIONES WHERE REPARACIONES.V_ID=:vid");
		$stmt->bindParam(':vid',$vid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
	}

	function seleccionarVidRmid($conexion, $rmid){
		try {
		$stmt = $conexion->prepare("SELECT REPARACIONES.V_ID FROM REPARACIONES WHERE REPARACIONES.RM_ID=:rmid");
		$stmt->bindParam(':rmid',$rmid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
	}
?>
