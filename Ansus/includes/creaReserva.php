<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';
require_once __DIR__.'/DAOReserva.php';
require_once __DIR__.'/DAOBolera.php';

	class creaReserva extends Form{
		
		
		protected $formId = 'creaReserva';

		protected $action;
		
	    public function __construct(){
			parent::__construct('creaReserva');
		}

		
		private function formularioEnviado(&$params)
		{
			return isset($params['action']) && $params['action'] == $this->formId;
		}
		
		
		private function generaListaErrores($errores)
		{
			$html='';
			$numErrores = count($errores);
			if (  $numErrores == 1 ) {
				$html .= "<ul><li>".$errores[0]."</li></ul>";
			} else if ( $numErrores > 1 ) {
				$html .= "<ul><li>";
				$html .= implode("</li><li>", $errores);
				$html .= "</li></ul>";
			}
			return $html;
		}
		
		
		protected function generaCamposFormulario($datosIniciales)
		{		$d= date('Y-m-d');	
				$dia = date('Y-m-d', strtotime($d. ' + 1 days'));
				$html = '<fieldset id="formulario">';
				$html.= '<legend> Reserva </legend>';
				$html.= '<p>Número de personas: <input type="number" name="numPersonas" min="1" max="10" required>';
				$html.= '<p>Día: <input type="date" name="dia" min="'.$dia.'" required></p>';
				$html.= '<p>Hora de inicio: <input type="time" name="inicio" min="09:00" max="23:00" required> </p>';
				$html.= '<p>Hora de finalización: <input type="time" name="final" min="09:30" max="23:30" required>';
				$html.= '<p>¿Quieres zapatos? <input type="checkbox" name="zapatos">';
				$html.= '<p><input type="submit" name="aceptar">';
				$html.= '</fieldset>';
			
			return $html;
		}
		
		
		private function generaFormulario($errores = array(), &$datos = array())
		{	$s=1;

			$html= $this->generaListaErrores($errores);

			$html .= '<form method="POST" >';
			$html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

			$html .= $this->generaCamposFormulario($s);
			$html .= '</form>';

			return $html;
		}
		
		
		protected function procesaFormulario($datos)
		{
			$erroresFormulario = array();
			$nPersonas = htmlspecialchars(trim(strip_tags($_POST["numPersonas"])));
			$dia = htmlspecialchars(trim(strip_tags($_POST["dia"])));
			$inicio = htmlspecialchars(trim(strip_tags($_POST["inicio"])));
			$fin = htmlspecialchars(trim(strip_tags($_POST["final"])));
			if($inicio > $fin){
				$erroresFormulario[] = "La hora de inicio debe ser anterior a la de fin";
				return $erroresFormulario;
			}else {
				if(isset($_POST["zapatos"])){
					$zapatos = 1;
				}
				else{
					$zapatos = 0;
				}
				
				$nombre_usuario = $_SESSION["usuario"];
				$miUser = Usuario::buscaUsuario($nombre_usuario);
				$idUser = $miUser->getDNI();
				$idBolera = $_SESSION["idBolera"];
				$idReserva = DAOReserva::getRowCount();
				$miBolera = DAOBolera::read($idBolera);
				
				$numPistas = $miBolera->getNumPistas();
				$pistasOcupadas = DAOBolera::getPistasOcupadasEnXHorario($idBolera, $dia, $inicio,$fin);
				
				$ini =strtotime($inicio);
				$final = strtotime($fin);
				$tiempo=$final - $ini;
				$precio= $tiempo * 0.0125;
				
				
				
				if($numPistas > $pistasOcupadas){
					$reserva = new TOReserva();
					$reserva->setIdReserva($idReserva);
					$reserva->setIdUsuario($idUser);
					$reserva->setZapatos($zapatos);
					$reserva->setIdBolera($idBolera);
					$reserva->setNumPersonas($nPersonas);
					$reserva->setDia($dia);
					$reserva->setInicio($inicio);
					$reserva->setFin($fin);
					$reserva->setPrecio($precio);
					DAOReserva::create($reserva);
					echo '<h2>Su reserva del día '.$dia.' para '.$nPersonas.' personas ha sido realizada con éxito!!!!</h2>';
				}
				else{
					echo '<p>Todas las pistas de nuestra bolera están ocupadas a esa hora</p>';
					echo '<p>Por favor, pruebe con otro horario o en una bolera cercana.</p>';
				}
			}
			
			return $erroresFormulario;
		}
		
		
		/**
		 * Se encarga de orquestar todo el proceso de gestión de un formulario.
		 */
		public function gestiona()
		{   

			if ( ! $this->formularioEnviado($_POST) ) {

				echo $this->generaFormulario();
			} else {
				$result = $this->procesaFormulario($_POST);
				if ( is_array($result) ) {
					echo $this->generaFormulario($result, $_POST);
		
				} else {
					header('Location: reservas.php');
					exit();
				}
			}  
		}
	}
	
?>