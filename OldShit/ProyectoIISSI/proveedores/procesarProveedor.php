<?php
	session_start();
	if (isset($_SESSION["proveedor"])) {
		Header("Location:../index.php");
	}
	else{
		$proveedor["editarproveedor"]=FALSE;

		$proveedor["PV_ID"] = $_REQUEST["PV_ID"];
		$proveedor["EMPRESA"] = $_REQUEST["EMPRESA"];
		$proveedor["DIRECCION"] = $_REQUEST["DIRECCION"];
		$proveedor["CORREO"] = $_REQUEST["CORREO"];
		$proveedor["TELEFONO"] = $_REQUEST["TELEFONO"];
		$proveedor["CUENTABANCARIA"] = $_REQUEST["CUENTABANCARIA"];
		$proveedor["EFICIENCIA"] = (int)$_REQUEST["EFICIENCIA"];

		if (isset($_REQUEST["editarproveedor"])){
			$proveedor["editarproveedor"]=TRUE;
			$_SESSION["proveedor"] = $proveedor;
			Header("Location:../piezas/piezas.php");
		}else if (isset($_REQUEST["quitarProveedor"])){
			$_SESSION["proveedor"]= $proveedor;
			Header("Location:../proveedores/quitarProveedor.php");
		}else if (isset($_REQUEST["grabarproveedor"])){
			$_SESSION["proveedor"]= $proveedor;
			Header("Location:../proveedores/tratamientoFormEditarProveedor.php");
		}else if (isset($_REQUEST["ver_piezas"])){
			$_SESSION["proveedor"] = $proveedor;
			Header("Location:../piezas/piezas.php");
		}else {
			Header("Location:../index.php");
		}
	}
?>