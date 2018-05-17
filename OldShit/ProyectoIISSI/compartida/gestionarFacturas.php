<?php
	function numeroFacturas($conexion, $cid){
	 	try {
			$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT  RM_ID FROM FACTURAS"
			. " GROUP BY C_ID=:cid ORDER BY F_ID)";
			$stmt = $conexion->prepare( $total_query );
			$stmt -> bindParam(":cid",$cid);
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

	function consultarFacturas($conexion,$pagina,$intervalo,$total,$cid){
		try {
			$first = ($pagina - 1) * $intervalo + 1;
			$last = $pagina * $intervalo;
			$paged_query = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM ( SELECT FACTURAS.F_ID, FACTURAS.PRECIOTOTAL, FACTURAS.ABONADO, FACTURAS.FECHAINICIO,"
				. "	FACTURAS.FECHAFIN, FACTURAS.C_ID FROM FACTURAS GROUP BY FACTURAS.C_ID=:cid"
				. " ORDER BY F_ID ) AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";
			$stmt = $conexion->prepare( $paged_query );
			$stmt->bindParam( ':first', $first );
			if($last>$total){
				$last=$total;
			}
			$stmt->bindParam( ':last', $last );
			$stmt->bindParam( ':cid', $cid );
			$stmt->execute();
			return $stmt;
		}catch ( PDOException $e ) {
			$_SESSION["error"]= $e->GetMessage();
			$_SESSION["destino"] = "index.php";
			Header("../error.php");
		}
  	}
	/*
  	function consultarPrecioTotal($conexion, $rmid){
			try {
				$stmt = $conexion->prepare("SELECT sum(PRECIOPORCANTIDAD) INTO MONEY FROM LINEAREPARACIONES WHERE RM_ID=:rmid");
				$stmt->bindParam(':rmid',$rmid);
				$stmt->execute();
				$result = $stmt->fetch();
				$din = $result['MONEY'];
				return (int)$din;
			}catch(PDOException $e ) {
				$_SESSION["error"]= $e->GetMessage();
				$_SESSION["destino"] = "index.php";
				Header("../error.php");
			}
	}
	*/
	function meterFactura($con,$cid,$rmid,$preciototal, $abonado, $fechainicio, $fechafin){
		try {

				$stmt = $con->prepare("INSERT INTO FACTURAS(PRECIOTOTAL, ABONADO, FECHAINICIO, FECHAFIN, C_ID, RM_ID)"
					. " VALUES (CAST(:precio as NUMBER(12,2)), :abonado, :inicio, :fin, :cid, :rmid)");
				$stmt->bindParam(':precio',$preciototal);
				$stmt->bindParam(':abonado',$abonado);
				$stmt->bindParam(':inicio',$fechainicio);
				$stmt->bindParam(':fin',$fechafin);
				$stmt->bindParam(':cid',$cid);
				$stmt->bindParam(':rmid',$rmid);
				$stmt->execute();
				return "";
		}catch(PDOException $e ) {
			return $e->GetMessage();
			$_SESSION["error"]= $e->GetMessage();
			$_SESSION["destino"] = "facturas/formCrearFactura.php";
			Header("../error.php");
		}
  }

  function seleccionarFactura($con, $fid){
  	try {
		$stmt = $con->prepare("SELECT * FROM FACTURAS WHERE F_ID=:fid");
		$stmt->bindParam(':fid',$fid);
		$stmt->execute();
	}catch(PDOException $e ) {

		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
   }

   function quitarFactura($conexion,$fid) {
		try {
			$stmt=$conexion->prepare("DELETE FROM FACTURAS WHERE F_ID=:fid");
			$stmt->bindParam(':fid',$fid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}

	function modificarFactura($conexion,$fid,$cid,$rmid,$preciototal, $abonado, $fechainicio, $fechafin) {
		try {

			$stmt=$conexion->prepare("UPDATE FACTURAS SET PRECIOTOTAL=CAST(:preciototal as NUMBER(12,2)), ABONADO=:abonado, FECHAINICIO=:fechainicio, FECHAFIN=:fechafin, C_ID=:cid, RM_ID=:rmid "
				  . " WHERE F_ID=:fid");
			$stmt->bindParam(':preciototal',$preciototal);
			$stmt->bindParam(':abonado',$abonado);
			$stmt->bindParam(':fechainicio',$fechainicio);
			$stmt->bindParam(':fechafin',$fechafin);
			$stmt->bindParam(':cid',$cid);
			$stmt->bindParam(':rmid',$rmid);
			$stmt->bindParam(':fid',$fid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }

	}

	function seleccionarFacturaCid($con, $cid){
  	try {
		$stmt = $con->prepare("SELECT * FROM FACTURAS WHERE C_ID=:cid");
		$stmt->bindParam(':cid',$cid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt->fetchAll();
   }

?>
