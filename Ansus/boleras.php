<?php 
include_once 'includes/FormBuscadorBoleras.php';
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>BOLERAS</title>
	</head>

	<body>
		<div id="contenedor_Inicio">

			<?php require_once __DIR__.'/includes/config.php'; ?>
			<?php require 'includes/comun/cabecera.php'; ?>

			<div id="contenido">
				<h1 id="Saludo"> ¡BIENVENIDO A NUESTRAS BOLERAS! </h1>
				<h2> Aquí podrás buscar cuál es la bolera más cercana a ti. <h2>
						
				<div id="Relleno1"> Introduce un código postal o el nombre de tu ciudad o provincia y 
				te mostraremos todas las boleras próximas a ti.</div>
				<div id="Relleno2B">
				<?php
					$form = new FormBuscadorBoleras;
					$form->gestiona();
				?>
				</div>
			</div>

		</div>
	</body>
</html>