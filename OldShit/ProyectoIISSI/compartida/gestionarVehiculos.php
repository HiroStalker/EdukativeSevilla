<?php
  
  function numeroVehiculos($conexion, $cid)
  {
	try {
		$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT * FROM VEHICULOS"
		. " WHERE C_ID=:cid ORDER BY MATRICULA, MARCA, MODELO)";
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
  
  function consultarPaginaVehiculos($conexion,$pagina,$intervalo,$total,$cid){
	try {
		$first = ($pagina - 1) * $intervalo + 1;
		$last = $pagina * $intervalo;
		$paged_query = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM ( SELECT VEHICULOS.V_ID, VEHICULOS.C_ID, VEHICULOS.MATRICULA, VEHICULOS.MARCA," 
			. "	VEHICULOS.MODELO, VEHICULOS.CHASIS, VEHICULOS.COLOR, VEHICULOS.KMS, VEHICULOS.ABANDONADO FROM VEHICULOS WHERE VEHICULOS.C_ID=:cid"
			. " ORDER BY MATRICULA, MARCA, MODELO ) AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";
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
  
  function meterVehiculo($con,$cid,$matricula,$marca, $modelo, $chasis, $color, $kms, $abandonado){
		try {
				$stmt = $con->prepare("INSERT INTO VEHICULOS(MATRICULA, MARCA, MODELO, CHASIS, COLOR, KMS, ABANDONADO, C_ID)"
					. " VALUES (:matricula, :marca, :modelo, :chasis, :color, :kms, :abandonado, :cid)");				
				$stmt->bindParam(':matricula',$matricula);
				$stmt->bindParam(':marca',$marca);
				$stmt->bindParam(':modelo',$modelo);
				$stmt->bindParam(':chasis',$chasis);
				$stmt->bindParam(':color',$color);
				$stmt->bindParam(':kms',$kms);
				$stmt->bindParam(':abandonado',$abandonado);
				$stmt->bindParam(':cid',$cid);
				$stmt->execute();
				return "";
		}catch(PDOException $e ) {
			return $e->GetMessage();
			$_SESSION["error"]= $e->GetMessage();
			$_SESSION["destino"] = "vehiculos/formCrearVehiculo.php";
			Header("../error.php");
		}
  }
  
  function seleccionarVehiculo($con, $vid){
  	try {
		$stmt = $con->prepare("SELECT * FROM VEHICULOS WHERE V_ID=:vid");
		$stmt->bindParam(':vid',$vid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
   }
   
   function quitarVehiculo($conexion,$vid) {  //TODO: MUY IMPORTANTE, LUEGO HAY QUE CAMBIAR ESTO Y HACER QUE SOLAMENTE BORRE SINO TIENE COSAS IMPORTANTES ASIGNADAS
		try {
			$stmt=$conexion->prepare("DELETE FROM VEHICULOS WHERE V_ID=:vid");
			$stmt->bindParam(':vid',$vid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}

	function modificarVehiculo($conexion,$vid,$matricula,$marca, $modelo, $chasis, $color, $kms, $abandonado, $cid) {
		try {
			$stmt=$conexion->prepare("UPDATE VEHICULOS SET MATRICULA=:matricula, MARCA=:marca, MODELO=:modelo, CHASIS=:chasis, COLOR=:color, KMS=:kms,"
				  . " ABANDONADO=:abandonado, C_ID=:cid WHERE V_ID=:vid");
			$stmt->bindParam(':matricula',$matricula);
			$stmt->bindParam(':marca',$marca);
			$stmt->bindParam(':modelo',$modelo);
			$stmt->bindParam(':chasis',$chasis);
			$stmt->bindParam(':color',$color);
			$stmt->bindParam(':kms',$kms);
			$stmt->bindParam(':abandonado',$abandonado);
			$stmt->bindParam(':cid',$cid);
			$stmt->bindParam(':vid',$vid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}
	
	function seleccionarTodosVehiculos($conexion){
		try {
		$stmt = $conexion->prepare("SELECT VEHICULOS.V_ID, VEHICULOS.C_ID, VEHICULOS.MATRICULA, VEHICULOS.MARCA," 
			. "	VEHICULOS.MODELO, VEHICULOS.CHASIS, VEHICULOS.COLOR, VEHICULOS.KMS, VEHICULOS.ABANDONADO FROM VEHICULOS");
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
	}
?>