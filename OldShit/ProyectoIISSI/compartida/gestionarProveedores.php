<?php 
	function numeroProveedores($conexion){
		try {
			$total_query = "SELECT COUNT(*) AS TOTAL FROM (SELECT * FROM PROVEEDORES"
				. " ORDER BY EMPRESA, EFICIENCIA)";
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

	function consultarPaginaProveedores($conexion,$pagina,$intervalo,$total){
		try {
			$first = ($pagina - 1) * $intervalo + 1;
			$last = $pagina * $intervalo;
			$paged_query = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM ( SELECT PROVEEDORES.PV_ID, PROVEEDORES.EMPRESA, PROVEEDORES.DIRECCION," 
				. "	PROVEEDORES.DIRECCION, PROVEEDORES.CORREO, PROVEEDORES.TELEFONO, PROVEEDORES.CUENTABANCARIA, PROVEEDORES.EFICIENCIA FROM PROVEEDORES"
				. " ORDER BY EMPRESA, EFICIENCIA) AUX WHERE ROWNUM <= :last) WHERE RNUM >= :first";
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
  	
	function meterProveedor($con,$empresa,$direccion,$correo, $telefono, $cuentabancaria, $eficiencia){
		try {
				$stmt = $con->prepare("INSERT INTO PROVEEDORES(EMPRESA, DIRECCION, CORREO, TELEFONO, CUENTABANCARIA, EFICIENCIA)"
					. " VALUES (:empresa, :direccion, :correo, :telefono, :cuentabancaria, :eficiencia)");				
				$stmt->bindParam(':empresa',$empresa);
				$stmt->bindParam(':direccion',$direccion);
				$stmt->bindParam(':correo',$correo);
				$stmt->bindParam(':telefono',$telefono);
				$stmt->bindParam(':cuentabancaria',$cuentabancaria);
				$stmt->bindParam(':eficiencia',$eficiencia);
				$stmt->execute();
				return "";
		}catch(PDOException $e ) {
			return $e->GetMessage();
			$_SESSION["error"]= $e->GetMessage();
			$_SESSION["destino"] = "proveedores/formCrearProveedor.php";
			Header("../error.php");
		}
	 }

	function seleccionarProveedor($con, $pvid){
  	try {
		$stmt = $con->prepare("SELECT * FROM PROVEEDORES WHERE PV_ID=:pvid");
		$stmt->bindParam(':pvid',$pvid);
		$stmt->execute();
	}catch(PDOException $e ) {
		$_SESSION["error"]= $e->GetMessage();
		$_SESSION["destino"] = "index.php";
		Header("../error.php");
	}
	return $stmt;
    }
  	
	function quitarProveedor($conexion,$pvid) {  //TODO: MUY IMPORTANTE, LUEGO HAY QUE CAMBIAR ESTO Y HACER QUE SOLAMENTE BORRE SINO TIENE COSAS IMPORTANTES ASIGNADAS
		try {
			$stmt=$conexion->prepare("DELETE FROM PROVEEDORES WHERE PV_ID=:pvid");
			$stmt->bindParam(':pvid',$pvid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}

	function modificarProveedor($conexion,$pvid,$empresa,$direccion,$correo, $telefono, $cuentabancaria, $eficiencia) {
		try {
			$stmt=$conexion->prepare("UPDATE PROVEEDORES SET EMPRESA=:empresa, DIRECCION=:direccion, CORREO=:correo, TELEFONO=:telefono, CUENTABANCARIA=:cuentabancaria,"
				  . " EFICIENCIA=:eficiencia WHERE PV_ID=:pvid");
			$stmt->bindParam(':empresa',$empresa);
			$stmt->bindParam(':direccion',$direccion);
			$stmt->bindParam(':correo',$correo);
			$stmt->bindParam(':telefono',$telefono);
			$stmt->bindParam(':cuentabancaria',$cuentabancaria);
			$stmt->bindParam(':eficiencia',$eficiencia);
			$stmt->bindParam(':pvid',$pvid);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return $e->GetMessage();
	    }
	}
?>