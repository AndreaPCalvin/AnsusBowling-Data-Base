<?php 
include_once 'includes/DAOReserva.php';
include_once 'includes/TallaDAO.php';
include_once 'includes/ZapatillasDAO.php';
include_once 'includes/Zapatillas.php';
require_once __DIR__.'/includes/config.php'; 

$id = $_GET['id'];
$reserva = DAOReserva::read($id);
$zapatillas = new ZapatillasDAO();
$Talla = new TallaDAO();
$html = "";

if(isset($_POST["enviar"])){
$asistentes = $_POST["asistentes"];
$talla = htmlspecialchars(trim(strip_tags($_POST["talla"])));

	$z = new Zapatillas($id, $asistentes, $asistentes);
	$t =  new Talla($id, $talla, $asistentes);
	if($zapatillas->comprobarReservaZ($z->getId())){
		$z2 = $zapatillas->getZapato($id);
		$reserva= DAOReserva::read($id);
		if($z->getNum() + $z2->getNum() > $reserva->GetNumPersonas()){
			$html= "No está permitido reservar un número de zapatos superior al de asistentes";
		}else {
			$zapatillas->update($z);
			if($Talla->comprobarTalla($t->getId(), $t->getTalla())){
			$Talla->update($t);
			}else {
				$Talla->insert($t);
			}	
		}

	}else {
		$zapatillas->insert($z);
		if($Talla->comprobarTalla($t->getId(), $t->getTalla())){
			$Talla->update($t);
		}else {
			$Talla->insert($t);
			}
		
		}	
	}

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estiloProyecto.css" />
		<title>ZAPATILLAS</title>
	</head>

	<body>
		<div id="contenedor_Inicio">

			<?php 
			require 'includes/comun/cabecera.php'; 
			
			
			?>

			<div id="contenido">
				<h1 id="SaludoZ"> ¡BIENVENIDO A NUESTRO SERVICIO DE ALQUILER DE ZAPATILLAS! </h1>
				<?php
				echo '
				<h2> La reserva que has seleccionado es el '.$reserva->getDia().', de '.$reserva->getInicio().' a '.$reserva->getFin().', con un total de '.$reserva->getNumPersonas().' asistentes. <h2>';?>
						
				<div id="Relleno1"> ¡Por 2 euros extra el par, puedes alquilar las unidades que necesites! Introduzca la talla deseada y el número de unidades 
				<form method="POST" action="vistaZapatillas.php?id=<?php echo $id ?>" >
				<input type="number" name="talla" min="33" max="50" required>  <select name="asistentes"> 
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				</select>
				
				<input type="submit" name="enviar">
</form>
				</div>
				<?php
				$zr = $zapatillas->getZapato($id);
				echo '<div id="Relleno2">';
				if($zr == false){
					echo 'Vaya, parece que aun no has reservado ningún par de zapatillas';
				}
				else {	
				echo 'Actualmente ha reservado un total de '.$zr->getNum().' pares de zapatillas, cuyas tallas son: ';
				$tallas = $Talla->getTodas($id);
				echo ListarTallas($tallas);
				echo $html;
				'</div>';
				}
				?>
			</div>

		</div>
	</body>
</html>
<?php
function ListarTallas($dataIni)
	{
			
			@$numResults= sizeof($dataIni);	
			$html= "<table id = 'tablaTallas'><tr>
			<th>Talla </th>
			<th>Unidades</th>
			</tr>";	
			for($i=0; $i<$numResults;$i++)
			{
					$html.= "<tr>";
					$html.= "<td>".$dataIni[$i]->getTalla()."</td>";
					$html.= "<td> ".$dataIni[$i]->getNum()."</td>";
					$html.= "<tr>";
			}
			$html.= "</table>";
		
		return $html;
		}

		

?>