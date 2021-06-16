<?php


require_once __DIR__.'/Form.php';
require_once __DIR__.'/DAOReserva.php';
require_once __DIR__.'/TOReserva.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/ZapatillasDAO.php';


	class FormularioMod extends Form{
		
		/**
		 * @var string Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al formulario y 
		 * como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
		 */
		protected $formId = 'formularioMod';

		/**
		 * @var string URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el 
		 * envío del formulario.
		 */
		protected $action;
		
	    public function __construct(){
			parent::__construct('formularioMod');
		}

		
		/**
		* Función que verifica si el usuario ha enviado el formulario.
		* Comprueba si existe el parámetro <code>$formId</code> en <code>$params</code>.
		*
		* @param string[] $params Array que contiene los datos recibidos en el envío formulario.
		*
		* @return boolean Devuelve <code>true</code> si <code>$formId</code> existe como clave en <code>$params</code>
		*/
		private function formularioEnviado(&$params)
		{
			return isset($params['action']) && $params['action'] == $this->formId;
		}
		
		/**
		 * Genera la lista de mensajes de error a incluir en el formulario.
		 *
		 * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
		 *
		 * @return string El HTML asociado a los mensajes de error.
		 */
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
		
		/**
		 * Genera el HTML necesario para presentar los campos del formulario.
		 *
		 * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
		 * 
		 * @return string HTML asociado a los campos del formulario.
		 */
		protected function generaCamposFormulario($datosIniciales)
		{
				$check;
				if($datosIniciales->getZapatos()==1){
					$check = "checked";
				}else {
					$check = "";
				}
				$html = '<fieldset>';
				$html.= '<legend> RESERVA </legend>';
				$html.= '<p>Número de asistentes <input type="number" name="num" value="'.$datosIniciales->getNumPersonas().'"></p>';
				$html.= '<p>Zapatos: <input type="checkbox" name="zapatos" '.$check.'></p>';
				$html.= '<p>Hora de inicio: <input type="time" name="hora_inicio" value="'.$datosIniciales->getInicio().'"> ';
				$html.= ' <p> Hora de fin: <input type="time" name="hora_fin" value="'.$datosIniciales->getFin().'">';
				$html.= '<p><input type="submit" name="aceptar" ></p>';
			    $html.= '</fieldset>';
			return $html;
		}
		
		/**
		 * Función que genera el HTML necesario para el formulario.
		 *
		 * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
		 *
		 * @param string[] $datos (opcional) Array con los valores por defecto de los campos del formulario.
		 *
		 * @return string HTML asociado al formulario.
		*/
		private function generaFormulario($errores = array(), &$datos)
		{

			$html= $this->generaListaErrores($errores);

			$html .= '<form method="POST" action="'.$this->action.'" id="'.$this->formId.'" >';
			$html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

			$html .= $this->generaCamposFormulario($datos);
			$html .= '</form>';

			return $html;
		}
		
		/**
		 * Procesa los datos del formulario.
		 *
		 * @param string[] $datos Datos enviado por el usuario (normalmente <code>$_POST</code>).
		 *
		 * @return string|string[] Devuelve el resultado del procesamiento del formulario, normalmente una URL a la que
		 * se desea que se redirija al usuario, o un array con los errores que ha habido durante el procesamiento del formulario.
		 */
		protected function procesaFormulario2($datos, $id)
		{
			$erroresFormulario = array();
			$num_personas = htmlspecialchars(trim(strip_tags($_POST["num"])));
			if(isset($_POST["zapatos"])){
				$zapatos=1;
			}else {
				$zapatos=0;
			}
			$hora_inicio = htmlspecialchars(trim(strip_tags($_POST["hora_inicio"])));
			$hora_fin = htmlspecialchars(trim(strip_tags($_POST["hora_fin"])));
				$ini =strtotime($hora_inicio);
				$final = strtotime($hora_fin);
				$tiempo=$final - $ini;
				$precio= $tiempo * 0.0125;
			if (count($erroresFormulario) === 0) {
				DAOReserva::update( $id, $num_personas, $zapatos, $hora_inicio, $hora_fin, $precio);
				if($zapatos==0){
					ZapatillasDAO::borrar($id);
				}
				$url = "gestionarReservas.php";
				return $url;
			}
			return $erroresFormulario;
		}	
		
		
		/**
		 * Se encarga de orquestar todo el proceso de gestión de un formulario.
		 */
		public function gestiona2($datos, $id)
		{   $errores=array();
			

			if ( ! $this->formularioEnviado($_POST) ) {

				echo $this->generaFormulario($errores, $datos);
			} else {
				$result = $this->procesaFormulario2($_POST, $id);
				if ( is_array($result) ) {
					echo $this->generaFormulario($result, $_POST);
				} else {
					header('Location: '.$result);
					exit();
				}
			}  
		}
	}
	
?>