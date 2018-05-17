<?php	
	session_start();
	if (isset($_SESSION["reparacion"])) {
		Header("Location:../index.php");
	}
	else{
		$reparacion["editarreparacion"]=FALSE;
		
		$reparacion["RM_ID"] = $_REQUEST["RM_ID"];
		$reparacion["TIPOESTADO"] = $_REQUEST["TIPOESTADO"];
		$reparacion["RM"] = $_REQUEST["RM"];
		$reparacion["HORAS"] = $_REQUEST["HORAS"];
		$reparacion["C_ID"] = $_REQUEST["C_ID"];
		$reparacion["V_ID"] = $_REQUEST["V_ID"];
		
		if (isset($_REQUEST["editarreparacion"])){
			$reparacion["editarreparacion"]=TRUE;
			$_SESSION["reparacion"] = $reparacion;
			Header("Location:../reparaciones/reparaciones.php");
		}else if (isset($_REQUEST["quitarreparacion"])){
			$_SESSION["reparacion"]= $reparacion;
			Header("Location:../reparaciones/quitarReparacion.php");
		}else if (isset($_REQUEST["grabarreparacion"])){
			$_SESSION["reparacion"]= $reparacion;
			Header("Location:../reparaciones/tratamientoFormEditarReparacion.php");
		}else {
			Header("Location:../index.php");
		}	
	}	
?>
