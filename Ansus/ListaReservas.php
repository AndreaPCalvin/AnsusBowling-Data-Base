<?php include_once 'includes/DAOReserva.php';
	  include_once 'includes/Usuario.php';
	 
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>TUS RESERVAS</title>
	</head>

	<body>
		<div id="contenedor_Inicio">

			<?php require_once __DIR__.'/includes/config.php';
			require 'includes/comun/cabecera.php'; 
			
			if(isset($_SESSION['login']) && $_SESSION['login'] ==true){
				echo '<div id="contenido">
				<h1 id="Saludo"> ¡ESTAS SON TUS RESERVAS! </h1>
						
				<div id="Relleno1"> Selecciona la reserva para la cual vas a realizar el alquiler de zapatos. <br>
					Ten en cuenta que solo se podran realizar cambios hasta un día antes de la fecha de reserva. <br>
					Solo se mostrarán las reservas en las que se haya seleccionado alquiler de zapatillas. ';
				$usuario = Usuario::buscaUsuario($_SESSION['usuario']);
				$lista = DAOReserva::listarReservasUsuarioZapatos($usuario->getDNI());
				echo DAOReserva::listar($lista);
				echo '</div>
			</div>';
			}else {
				echo'<h1 id="Saludo"> ¡NECESITAS ESTAR LOGUEADO PARA PODER VER TUS RESERVAS! </h1>';
			}
			
?>
		</div>
	</body>
</html>
