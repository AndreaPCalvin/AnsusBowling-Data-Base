<?php

//Inicio del procesamiento
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioLogin.php';
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>Pestaña de login</title>
	</head>

	<body>
		<div id="contenedor">

			<?php require 'includes/comun/cabecera.php'; ?>

			<div id="contenido_formulario">
		
		  <div id="login_item1"></div>
		  <div id="login_item2"><?php
				$formulario = new FormularioLogin();
				$formulario->gestiona();
			?></div>
		  <div id="login_item3"></div>
	 
	
	</div>
		</div> <!-- Fin del contenedor -->
	</body>
</html>