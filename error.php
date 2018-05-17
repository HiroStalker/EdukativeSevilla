<?php 
	session_start();
	
	$error = $_SESSION["error"];
	unset($_SESSION["error"]);
	
	if (isset ($_SESSION["destino"])) {
		$destino = $_SESSION["destino"];
		unset($_SESSION["destino"]);	
	} else 
		$destino = "";
		
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Error</title>
		<link type="text/css" rel="stylesheet" href="style/biblio.css">  
	</head>
	<body>	
	
	<h2>¡Ups!</h2>
	<?php if ($destino<>"") { ?>
	<p>Ocurrió un problema durante el procesado de los datos. Pulse <a href="<?php echo $destino ?>">aquí</a> para volver a la página principal.</p>
	<?php } else { ?>
	<p>Ocurrió un problema para acceder a la base de datos.</p>
	<?php } ?>
	
	<div class="error">
	<?php 
	// Aquí deberíamos almacenar la información del error en un archivo de logs
		echo $error;
	?>
	</div>
	
	</body>
</html>