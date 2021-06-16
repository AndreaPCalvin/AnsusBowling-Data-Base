<?php
	require_once __DIR__.'/includes/config.php';
	include_once 'includes/Usuario.php';
	include_once 'includes/DAOReserva.php';
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>MIS RESERVAS</title>
	</head>

	<body>
		<div id="contenedor_Inicio">

			<?php 
				require 'includes/comun/cabecera.php'; 
			 ?>

			<div id="contenido">
				<?php
					if(isset($_SESSION['login']) && $_SESSION['login'] ==true){
						echo'<h1 id="Saludo"> ¡ESTAS SON TUS RESERVAS! </h1>';
					echo '<div id="Relleno1"> Solo se muestran las reservas para las que quede más de un día.';						
						$usuario = Usuario::buscaUsuario($_SESSION['usuario']);
						$lista = DAOReserva::listarReservasUsuario($usuario->getDNI());
						echo DAOReserva::listarMisReservas($lista);
						
					}else {
						echo'<h1 id="Saludo"> ¡NECESITAS ESTAR LOGUEADO PARA PODER VER TUS RESERVAS! </h1>';
					}
				?>
			</div>

		</div> 
	</body>
</html>