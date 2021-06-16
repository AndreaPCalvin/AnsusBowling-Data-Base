<?php
	require_once __DIR__.'/includes/config.php';
	include_once 'includes/DAOReserva.php';
	$idReserva = $_GET['id'];
	if(isset($_POST["borrar"])) {
		DAOReserva::delete($idReserva); 
		header ("Location:gestionarReservas.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>BORRAR RESERVA</title>
	</head>

	<body>
		<div id="contenedor_Inicio">

			<?php 
				require 'includes/comun/cabecera.php'; 
			 ?>

			<div id="contenido">
				<?php
					if(isset($_SESSION['login']) && $_SESSION['login'] ==true){
						
						echo'<h1> Si borras la reserva, no podrás cancelarlo. </h1>';
						echo '<form method="POST" action=borrarReserva.php?id='.$idReserva.'>¿Realmente quieres cancelar la reserva?';
						echo '<input type="submit" name="borrar" value="SÍ">';
						
					}else {
						echo'<h1 id="Saludo"> Error </h1>';
					}
				?>
			</div>

		</div> 
	</body>
</html>