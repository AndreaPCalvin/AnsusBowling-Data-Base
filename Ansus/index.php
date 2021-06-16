<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>BOLERA</title>
	</head>

	<body>
		<div id="contenedor_Inicio">

			<?php require_once __DIR__.'/includes/config.php'; ?>
			<?php require 'includes/comun/cabecera.php'; ?>

			<div id="contenido">
				<h1 id="Saludo"> ¡BIENVENIDOS A ANSUS BOLERAS! </h1>
				
				<div id="Relleno1"> Bienvenido a la red de boleras más grande de toda España. Desde esta web podrás realizar reservas de pistas y gestionarlas de forma cómoda y sencilla.
						Si buscas organizar un evento a medida, nuestras boleras tienen un amplio abanico de posibilidades. Organizamos cumpleaños infantiles, fiestas para adultos, 
						eventos de empresa y torneos. Llama a la bolera en la que quieres celebrar tu evento y ellos te informarán.</div>
						
				<div id="Relleno2"> <a href = "boleras.php" ><img id ="loc" src="img/localizaciones.jpg" alt= "localizaciones"/> </a> <p id="busca">Pinche aquí para buscar su bolera más cercana</p></div>
			</div>

		</div> <!-- Fin del contenedor -->
	</body>
</html>