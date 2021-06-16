<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';
require_once __DIR__.'/DAOBolera.php';
require_once __DIR__.'/config.php';


	class FormularioReserva extends Form{
		
		/**
		 * @var string Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al formulario y 
		 * como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
		 */
		protected $formId = 'FormularioReserva';

		/**
		 * @var string URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el 
		 * envío del formulario.
		 */
		protected $action;
		
	    public function __construct(){
			parent::__construct('FormularioReserva');
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
			$html = '<fieldset>';
			$html.= '<legend>Buscador de boleras</legend>';
			$html.= '<p>Buscar:<input type="text" name="busq" required> </p>';
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
		private function generaFormulario($errores = array(), &$datos = array())
		{

			$html= $this->generaListaErrores($errores);

			$html .= '<form method="POST" action="'.$this->action.'" id="'.$this->formId.'" >';
			$html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

			$html .= $this->generaCamposFormulario($datos);
			$html .= '</form>';

			return $html;
		}
		
		
		protected function procesaFormulario($datos)
		{
			$erroresFormulario = array();
			
			$result = array();
			if(isset($_POST["busq"])){
			
				$boleraDAO = new DAOBolera();
				
				$busq = $_POST["busq"];
								
				$result=$boleraDAO->buscaBoleraNombre($busq);

				echo $this->generaTablaResultados($result);
			}
			return $erroresFormulario;
		}	

private function generaTablaResultados($datosIniciales)
{

		@$numResults= sizeof($datosIniciales);	
		$html="";
		if($numResults==1){
			header("Location: reservaEnBolera.php?id=".$datosIniciales[0]->getIdBolera());
			
		}else if ($numResults==0){
			$html.= "No hay boleras con ese nombre. Pruebe a buscar <button><a href='boleras.php'>aquí</a></button>";
		}
		else{
			$html.= "<table id = 'tablaBoleras'><tr>
			<th>Nombre </th>
			<th>Dirección</th>
			<th>Teléfono</th>
			<th>Hacer una reserva</th>
			</tr>";	
			for($i=0; $i<$numResults;$i++)
			{		$html.= "<tr>";
					$html.= "<td>".$datosIniciales[$i]->getNombre()."</td>";
					$html.= "<td> ".$datosIniciales[$i]->getCalle().", código postal ".$datosIniciales[$i]->getCP()."</td>";
					$html.= "<td> ".$datosIniciales[$i]->getTelefono()."</td>";
					$html.= "<td><a href='reservaEnBolera.php?id=".$datosIniciales[$i]->getIdBolera()."'>Ver</a></td>";
					$html.= "<tr>";
			}
			$html.= "</table>";
		}

		return $html;
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
					header('Location: '.$result);
					exit();
				}
			}  
		}
	}
	?>