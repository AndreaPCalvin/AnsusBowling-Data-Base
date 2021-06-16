<?php

//Inicio del procesamiento
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioReserva.php';
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>RESERVAS</title>
	</head>

	<body>
		<div id="contenedor_Inicio_reservas">

			<?php require_once __DIR__.'/includes/config.php'; ?>
			<?php require 'includes/comun/cabecera.php'; ?>

			<div id="contenido_reservas">
				<h1 id="Saludo_reservas"> RESERVAS </h1>
				
				<div id="Relleno1_reservas">Introduce el nombre de la bolera en la que deseas reservar pista.</div>
				<div id="Relleno1_reservas">Si no sabes el nombre de la bolera busca  
				<button><a href='boleras.php'>aquí</a></button></div>
			
				<div id="busc">
			<?php
				$formulario = new FormularioReserva();
				$formulario->gestiona();
			?>
				</div>
			</div>

		</div> <!-- Fin del contenedor -->
	</body>
</html>