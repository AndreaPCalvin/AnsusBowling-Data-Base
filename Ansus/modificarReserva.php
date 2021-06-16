<?php
	require_once __DIR__.'/includes/config.php';
	include_once 'includes/DAOReserva.php';
	include_once 'includes/FormularioMod.php';
	if (isset($_GET["id"])){
		$_SESSION["idReserva_modificar"] = $_GET["id"];
		$id = $_GET["id"];
	}else {
		$id = $_SESSION["idReserva_modificar"];
	}
	$datos = DAOReserva::read($id);
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>MODIFICAR RESERVA</title>
	</head>

	<body>
		<div id="contenedor_Inicio">

			<?php 
				require 'includes/comun/cabecera.php'; 
			 ?>

			<div id="contenido">
				<?php
					if(isset($_SESSION['login']) && $_SESSION['login'] ==true){
						
						$formulario = new FormularioMod();
						$formulario->gestiona2($datos, $id);
						
					}else {
						echo'<h1 id="Saludo"> Error </h1>';
					}
				?>
			</div>

		</div> 
	</body>
</html>