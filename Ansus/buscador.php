<?php

//Inicio del procesamiento
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioBusqueda.php';


?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>Buscador Boleras</title>
	</head>

	<body>
		<div id="contenedor">
			<?php require 'includes/comun/cabecera.php'; ?>
			<div id="contenido">
				<?php
					$formulario = new FormularioBusqueda();
					$formulario->gestiona();
				?>
				
			</div>
			<?php require 'includes/comun/pie.php'; ?>
		</div> <!-- Fin del contenedor -->
	</body>
</html>