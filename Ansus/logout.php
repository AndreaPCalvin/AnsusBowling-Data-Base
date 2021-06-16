

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>Procesar Logout</title>
	</head>

	<body>
		<div id="contenedor">

			<?php
				require_once __DIR__.'/includes/config.php';
				unset($_SESSION);
				session_destroy();
			?>
			
			<?php require 'includes/comun/cabecera.php'; ?>
			
			<div id="contenidoOut">
				<p> ¡Hasta luego!</p>
			</div>
		</div> <!-- Fin del contenedor -->
	</body>
</html>
