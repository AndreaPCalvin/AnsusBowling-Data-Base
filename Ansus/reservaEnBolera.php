<?php 
require_once __DIR__.'/includes/config.php';
include_once 'includes/DAOBolera.php';
include_once 'includes/TOBolera.php';
include_once 'includes/creaReserva.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
	<link rel="stylesheet" type="text/css" href="css/calendario.css" />
	<title>Reserva</title>
</head>
<body>
<div id="contenedor_Inicio">
	<div id="contenido">

			<?php require 'includes/comun/cabecera.php'; ?>
		
			<?php
				$miID = $_GET["id"];
				$_SESSION["idBolera"]=$miID;
				$info = new TOBolera();
				$info = DAOBolera::read($miID);

				echo '<p>' . $info->getNombre() . ' tiene '.$info->getNumPistas().' pistas.</p>';
				
				echo '<p >Su dirección es: ' . $info->getCalle() . ', '. $info->getCP() .'</h2>';
				echo '<p>Si tiene cualquier pregunta no dude en llamarnos: ' . $info->getTelefono(). ' </p>';
				echo '<p>Las reservas deben hacerse con al menos un día de antelación</p>';
				
				if(isset($_SESSION['login']) && $_SESSION['login']==true){
					$formulario = new creaReserva();
					$formulario->gestiona();
				}
				else{
					echo 'Debes registrarte para poder hacer una reserva.';
				}
				
			?>
		

	</div>
</div>
</body>
</html>