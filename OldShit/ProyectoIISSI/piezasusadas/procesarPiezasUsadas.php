<?php
	session_start();
	if (isset($_SESSION["piezasusadas"])) {
		Header("Location:../index.php");
	}
	else{
		$piezasusadas["editarpiezasusadas"]=FALSE;

		$piezasusadas["LR_ID"] = $_REQUEST["LR_ID"];
		$piezasusadas["P_ID"] = $_REQUEST["P_ID"];
		$piezasusadas["RM_ID"] = $_REQUEST["RM_ID"];
		$piezasusadas["F_ID"] = $_REQUEST["F_ID"];
		$piezasusadas["CANTIDADUSADA"] = $_REQUEST["CANTIDADUSADA"];
		$piezasusadas["PRECIOPORCANTIDAD"] = $_REQUEST["PRECIOPORCANTIDAD"];
		
		if (isset($_REQUEST["editarpiezasusadas"])){
			$piezasusadas["editarpiezasusadas"]=TRUE;
			$_SESSION["piezasusadas"] = $piezasusadas;
			Header("Location:../piezasusadas/piezasusadas.php");
		}else if (isset($_REQUEST["quitarpiezasusadas"])){
			$_SESSION["piezasusadas"]= $piezasusadas;
			Header("Location:../piezasusadas/quitarPiezasUsadas.php");
		}else if (isset($_REQUEST["grabarpiezasusadas"])){
			$_SESSION["piezasusadas"]= $piezasusadas;
			Header("Location:../piezasusadas/tratamientoFormEditarPiezasUsadas.php");
		}else {
			Header("Location:../index.php");
		}
	}
?>
