<?php
require_once 'Form.php';
include_once 'DAOBolera.php';
class FormBuscadorBoleras extends Form
{
    public function __construct()
    {
        parent::__construct('FormBuscadorBoleras');
    }
	
	private function generaFormulario($errores = array(), &$datos = array())
		{
			$html = '<form method="POST" action="'.$this->action.'" id="'.$this->formId.'" >';
			$html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

			$html .= $this->generaCamposFormulario($datos);
			$html .= '</form>';

			return $html;
		}

	protected function generaCamposFormulario($datosIniciales)
    {
        
        $result = '<h1 class="content"> Buscar boleras </h1>
							<label>Código postal: <input type="text" name="cp"></label>
							<label>Lugar: <input type="text" name="place"></label>
							<button type= "submit"> Buscar </button>
		';
		return $result;
				
		
    return $resultado;
    }

    protected function procesaFormulario($datos)
    {
		@$mycp = $_POST["cp"];
		@$myplace = $_POST["place"];
		$erroresFormulario = array();
		if($myplace != ""){
			$lugar = htmlspecialchars(trim(strip_tags($_POST["place"])));
		
			$misBoleras2 = DAOBolera::buscarBoleraUbi($lugar);
			
			echo $this->generaTabla($misBoleras2);
		}	
		
		else if($mycp != ""){
			$codpost = htmlspecialchars(trim(strip_tags($_POST["cp"])));
		
			$misBoleras = DAOBolera::buscarBoleraCP($codpost);
			
			if(@sizeof($misBoleras) == 0){
				$sugerencias = DAOBolera::buscarBoleraProvincia($codpost);
				echo 'No hay boleras con código postal '.$codpost. '.';
				echo 'Aquí tiene otras boleras en su provincia: ';
				echo $this->generaTabla($sugerencias);
			}
			else{
				echo $this->generaTabla($misBoleras);
			}
		}	
		
		
		
		return $erroresFormulario;
    }
	
	private function generaTabla($dataIni)
	{
		@$numResults= sizeof($dataIni);	
		$html="";
		
		if($numResults>1){
			$html.="<p>Hay ".$numResults." boleras que contienen los elementos de su búsqueda</p>";
		}
		else if ($numResults == 1){
			$html.="<p>Hay 1 bolera que contiene los elementos de su búsqueda</p>";
		}
		else if($numResults==0){
			echo'<p>Lo sentimos, no hay boleras en el lugar que busca. Pruebe a introducir el nombre de una ciudad cercana o de su comunidad autónoma</p>';
		}
		
		if($numResults>0){
			
			$html.= "<table id = 'tablaBoleras'><tr>
			<th>Nombre </th>
			<th>Dirección</th>
			<th>Teléfono</th>
			<th>Hacer una reserva</th>
			</tr>";	
			for($i=0; $i<$numResults;$i++)
			{		$html.= "<tr>";
					$html.= "<td>".$dataIni[$i]->getNombre()."</td>";
					$html.= "<td> ".$dataIni[$i]->getCalle().", código postal ".$dataIni[$i]->getCP()."</td>";
					$html.= "<td> ".$dataIni[$i]->getTelefono()."</td>";
					$html.= "<td><a id ='enlace' href='reservaEnBolera.php?id=".$dataIni[$i]->getIdBolera()."'>Ver</a></td>";
					$html.= "<tr>";
			}
			$html.= "</table>";
		}

		return $html;
	}

	public function gestiona()
		{   
			$result = array();

			echo $this->generaFormulario($result, $_POST);
			$result = $this->procesaFormulario($_POST);

        	if (!is_array($result) ) {
        		header('Location:'.$result);
				exit();
			} 
	}
}
?>