<?php


require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';
require_once __DIR__.'/config.php';


	class FormularioRegistro extends Form{
		
		/**
		 * @var string Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al formulario y 
		 * como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
		 */
		protected $formId = 'formularioRegistro';

		/**
		 * @var string URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el 
		 * envío del formulario.
		 */
		protected $action;
		
	    public function __construct(){
			parent::__construct('formularioRegistro');
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
			if(empty($datosIniciales)){
				$html = '<fieldset id="formulario">';
				$html.= '<legend> REGISTRO </legend>';
				$html.= '<p>Nombre: <input type="text" name="nombre" required>';
				$html.= '  Apellido: <input type="text" name="apellidos" required></p>';
				$html.= '<p>DNI: <input type="text" name="DNI" required> Nombre de usuario: <input type="text" name="nombre_usuario" required></p>';
				$html.= '<p> Contraseña: <input type="password" name="contraseña" required>';
				$html.= ' Confirmacion de contraseña: <input type="password" name="2contraseña" required></p>';
				$html.= '<p>Teléfono: <input type="text" name="telefono" required> ';
			    $html.= '<p><input type="submit" name="aceptar" ></p>';
				$html.= '</fieldset>';
			}
			else{
				$html = '<fieldset>';
				$html.= '<legend> REGISTRO </legend>';
				$html.= '<p>Nombre: <input type="text" name="nombre" value="'.$datosIniciales['nombre'].'" required>';
				$html.= '  Apellido: <input type="text" name="apellidos" value="'.$datosIniciales['apellido'].'" required></p>';
				$html.= '<p>DNI: <input type="text" name="DNI" value="'.$datosIniciales['dni'].'" required> ';
				$html.= 'Nombre de usuario: <input type="text" name="nombre_usuario" value="'.$datosIniciales['nombre_usuario'].'" required> </p>';
				$html.= ' <p> Contraseña: <input type="password" name="contraseña" required>';
				$html.= ' Confirmacion de contraseña: <input type="password" name="2contraseña" required></p>';
				$html.= '<p>Teléfono: <input type="text" name="telefono" value="'.$datosIniciales['telefono'].'" required></p>';
				$html.= '<p><input type="submit" name="aceptar" ></p>';
			    $html.= '</fieldset>';
			}
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
		
		/**
		 * Procesa los datos del formulario.
		 *
		 * @param string[] $datos Datos enviado por el usuario (normalmente <code>$_POST</code>).
		 *
		 * @return string|string[] Devuelve el resultado del procesamiento del formulario, normalmente una URL a la que
		 * se desea que se redirija al usuario, o un array con los errores que ha habido durante el procesamiento del formulario.
		 */
		protected function procesaFormulario($datos)
		{
			$erroresFormulario = array();
			$nombre = htmlspecialchars(trim(strip_tags($_POST["nombre"])));
			$apellidos = htmlspecialchars(trim(strip_tags($_POST["apellidos"])));
			$DNI = htmlspecialchars(trim(strip_tags($_POST["DNI"])));
			$usuario = htmlspecialchars(trim(strip_tags($_POST["nombre_usuario"])));
			$contrasena = htmlspecialchars(trim(strip_tags($_POST["contraseña"])));
			$rep_con = htmlspecialchars(trim(strip_tags($_POST["2contraseña"])));
			$telefono = htmlspecialchars(trim(strip_tags($_POST["telefono"])));
			$u = Usuario::buscaUsuario($usuario);
			$u2 = Usuario::buscaUsuario($DNI);

			if($u || $u2){ // si existe el usuario
				$erroresFormulario[] = "El usuario ya existe";
			}
			if($contrasena != $rep_con){
				$erroresFormulario[] = "Las contraseñas deben coincidir";
			}
			if (count($erroresFormulario) === 0) {
				$usuarioCreado = Usuario::crea($DNI, $nombre, $apellidos, $telefono, $contrasena, $usuario);
				//cuando se registra un usuario correctamente se logea directamente y se le redirige a la pagina de productos
				$_SESSION["login"]=true;
				$_SESSION["usuario"]=$usuario;
				$url = "index.php";
				return $url;
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
					header('Location: '.$result);
					exit();
				}
			}  
		}
	}
	
?>