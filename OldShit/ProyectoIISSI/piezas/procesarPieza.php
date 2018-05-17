<?php	
	session_start();
	if (isset($_SESSION["piezas"])) {
		Header("Location:../index.php");
	}
	else{
		$pieza["editarpieza"]=FALSE;
		
		$pieza["P_ID"] = $_REQUEST["P_ID"];
		$pieza["NOMBRE"] = $_REQUEST["NOMBRE"];
		$pieza["cantidad"] = $_REQUEST["cantidad"];
		$pieza["marca"] = $_REQUEST["marca"];
		$pieza["tipocategoria"] = $_REQUEST["tipocategoria"];
		$pieza["precioproveedor"] = $_REQUEST["precioproveedor"];
		$pieza["pvp"] = $_REQUEST["pvp"];
		$pieza["codigo"] = $_REQUEST["codigo"];
		$pieza["pv_id"] = $_REQUEST["pv_id"];

		if (isset($_REQUEST["editarpieza"])){
			$pieza["editarpieza"]=TRUE;
			$_SESSION["pieza"] = $pieza;
			Header("Location:../piezas/piezas.php");
		}else if (isset($_REQUEST["quitarPieza"])){
			$_SESSION["piezas"]= $pieza;
			Header("Location:../piezas/quitarPiezas.php");
		}else if (isset($_REQUEST["grabarPiezas"])){
			$_SESSION["piezas"]= $pieza;
			Header("Location:../piezas/tratamientoFormEditarPiezas.php");
		}else {
			Header("Location:../index.php");
		}	
	}	
?>