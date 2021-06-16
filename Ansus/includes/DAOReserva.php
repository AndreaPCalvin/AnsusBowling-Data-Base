<?php
include_once "TOReserva.php";
include_once "ZapatillasDAO.php";
include_once "Zapatillas.php";
class DAOReserva{
	public static function create($reserva){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$idReserva = $reserva->getIdReserva();
		$idUser = $reserva->getIdUsuario();
		$zapatos = $reserva->getZapatos();
		$idBolera = $reserva->getIdBolera();
		$numPersonas = $reserva->getNumPersonas();
		$precio= $reserva->getPrecio();
		$dia= $reserva->getDia();
		$inicio= $reserva->getInicio();
		$fin= $reserva->getFin();
		
		$query = sprintf("insert into reservas(id_reserva, id_usuario, zapatos, id_bolera, num_personas, precio, dia, hora_inicio, hora_fin) 
			values('%d', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s')",
			$conection->real_escape_string($idReserva),
			$conection->real_escape_string($idUser),
			$conection->real_escape_string($zapatos),
			$conection->real_escape_string($idBolera),
			$conection->real_escape_string($numPersonas),
			$conection->real_escape_string($precio),
			$conection->real_escape_string($dia),
			$conection->real_escape_string($inicio),
			$conection->real_escape_string($fin)
		);

		if(! $conection->query($query)){
			return false;
		}
		else{
			return true;
		}
	}
	
	

	public static function read($id){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$query = sprintf("SELECT * FROM reservas WHERE id_reserva = '%d'", $conection->real_escape_string($id));
		$result = $conection->query($query);
		
		if ($result->num_rows == 0){
			return NULL;
		}

		$reserva = new TOReserva();
		$fila = $result->fetch_assoc();
		
		 $reserva->setIdReserva($fila['id_reserva']);
		 $reserva->setIdUsuario($fila['id_usuario']);
		 $reserva->setZapatos($fila['zapatos']);
		 $reserva->setIdBolera($fila['id_bolera']);
		 $reserva->setNumPersonas($fila['num_personas']);
		 $reserva->setPrecio($fila['precio']);
		 $reserva->setDia($fila['dia']);
		 $reserva->setInicio($fila['hora_inicio']);
		 $reserva->setFin($fila['hora_fin']);
		
		return $reserva;	
	}

	public static function delete($id){	
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$query = sprintf("delete from reservas where id_reserva='%d'", 
		$conection->real_escape_string($id));

		if(!$conection->query($query)){
			return true;
		}
		else{
			return false;
		}
	}
	public static function update($id_reserva, $numPersonas, $zapatos, $ini, $fin, $precio){
		$aplication = Aplicacion::getSingleton();
        $conn = $aplication->conexionBD();
		$sql = sprintf("UPDATE reservas set num_personas = '%d', zapatos='%d', hora_inicio='%s', hora_fin='%s', precio='%d' 
			WHERE id_reserva='%d'"
		, $conn->real_escape_string($numPersonas)
		, $conn->real_escape_string($zapatos)
		, $conn->real_escape_string($ini)
		, $conn->real_escape_string($fin)
		, $conn->real_escape_string($precio)
		, $conn->real_escape_string($id_reserva)		
		);
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
		
	}

	public static function listarReservas(){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$query = sprintf("SELECT * FROM reservas ");
		$result = $conection->query($query);

		if ($result->num_rows == 0){
			return NULL;
		}
		
		
		while($fila = $result->fetch_assoc()){
			$reserva = new TOReserva();
			 $reserva->setIdReserva($fila['id_reserva']);
			 $reserva->setIdUsuario($fila['id_usuario']);
			 $reserva->setZapatos($fila['zapatos']);
			 $reserva->setIdBolera($fila['id_bolera']);
			 $reserva->setNumPersonas($fila['num_personas']);
			 $reserva->setPrecio($fila['precio']);
			 $reserva->setDia($fila['dia']);
			 $reserva->setInicio($fila['hora_inicio']);
			 $reserva->setFin($fila['hora_fin']);
			$listaRservas[] = $reserva;
		}
		return $listaRservas;
	}
	
	 public static function getRowCount(){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
      $query = sprintf("SELECT * FROM reservas");
      $result = $conection->query($query);
      $n = 0;
      while($row = $result->fetch_assoc()){
        if ($n <= $row['id_reserva']) {
          $n = $row['id_reserva'] + 1;
        }
      }
      return $n;
    }
	
	public static function listarReservasUsuarioZapatos($id_usuario){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		$query = sprintf("SELECT * FROM reservas WHERE id_usuario='$id_usuario' AND dia > CURRENT_DATE AND zapatos = 1");
		$result = $conection->query($query);

		if (@$result->num_rows == 0){
			return NULL;
		}
		
		$listaRservas = array();
		while($fila = $result->fetch_assoc()){
			$reserva = new TOReserva();
			 $reserva->setIdReserva($fila['id_reserva']);
			 $reserva->setIdUsuario($fila['id_usuario']);
			 $reserva->setZapatos($fila['zapatos']);
			 $reserva->setIdBolera($fila['id_bolera']);
			 $reserva->setNumPersonas($fila['num_personas']);
			 $reserva->setPrecio($fila['precio']);
			 $reserva->setDia($fila['dia']);
			 $reserva->setInicio($fila['hora_inicio']);
			 $reserva->setFin($fila['hora_fin']);
			$listaRservas[] = $reserva;
		}
		return $listaRservas;
	}
	
	public static function listar($dataIni)
	{
		@$numResults= sizeof($dataIni);	
		$html="";
		
		if($numResults==0){
			echo'<p> Parece que no tienes reservas próximas</p>';
		}	
		else if($numResults>0){
			
			$html.= "<table id = 'tablaBoleras'><tr>
			<th>Número de asistentes </th>
			<th>Día</th>
			<th>Hora de inicio</th>
			<th>Hora de fin</th>
			<th>Precio</th>
			<th>Alquilar</th>
			</tr>";	
			for($i=0; $i<$numResults;$i++)
			{
					$html.= "<tr>";
					$html.= "<td>".$dataIni[$i]->getNumPersonas()."</td>";
					$html.= "<td> ".$dataIni[$i]->getDia()."</td>";
					$html.= "<td> ".$dataIni[$i]->getInicio()."</td>";
					$html.= "<td> ".$dataIni[$i]->getFin()."</td>";
					$html.= "<td> ".$dataIni[$i]->getPrecio()."</td>";
					$html.= "<td><a id ='enlace' href='vistaZapatillas.php?id=".$dataIni[$i]->getIdReserva()."'>Zapatillas</a></td>";
					$html.= "<tr>";
			}
			$html.= "</table>";
		}

		return $html;
	}
	
	public static function listarMisReservas($dataIni)
	{
		@$numResults= sizeof($dataIni);	
		$html="";
		
		if($numResults==0){
			echo'<p> Parece que no tienes reservas</p>';
		}	
		else if($numResults>0){
			
			$html.= "<table id = 'tablaBoleras'><tr>
			<th>Número de asistentes </th>
			<th>Día</th>
			<th>Hora de inicio</th>
			<th>Hora de fin</th>
			<th>Precio de reserva</th>
			<th>Precio de alquiler</th>
			<th>Precio Total</th>
			<th>Modificar reserva</th>
			<th>Borrar reserva</th>
			</tr>";	
			$DAOZapatillas = new ZapatillasDAO();
			for($i=0; $i<$numResults;$i++)
			{
					$precio = $dataIni[$i]->getPrecio();
					$precio_alq = 0;
					if($dataIni[$i]->getZapatos() == 1){
						$z = $DAOZapatillas->getZapato($dataIni[$i]->getIdReserva());
						if($z){
							$precio_alq = $z->getCoste();
						}
					}
					$total = $precio + $precio_alq;
					$html.= "<tr>";
					$html.= "<td>".$dataIni[$i]->getNumPersonas()."</td>";
					$html.= "<td> ".$dataIni[$i]->getDia()."</td>";
					$html.= "<td> ".$dataIni[$i]->getInicio()."</td>";
					$html.= "<td> ".$dataIni[$i]->getFin()."</td>";
					$html.= "<td> ".$precio."</td>";
					$html.="<td> ".$precio_alq."</td>";
					$html.="<td> ".$total."</td>";
					$html.= "<td><a id='enlace' href='modificarReserva.php?id=".$dataIni[$i]->getIdReserva()."'>Modificar</a></td>";
					$html.= "<td><a id='enlace' href='borrarReserva.php?id=".$dataIni[$i]->getIdReserva()."'>Borrar</a></td>";
					$html.= "<tr>";
			}
			$html.= "</table>";
		}

		return $html;
	}
	
	public static function listarReservasUsuario($id_usuario){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		$query = sprintf("SELECT * FROM reservas WHERE id_usuario='$id_usuario' AND dia >= CURRENT_DATE");
		$result = $conection->query($query);

		if (@$result->num_rows == 0){
			return NULL;
		}
		
		$listaRservas = array();
		while($fila = $result->fetch_assoc()){
			$reserva = new TOReserva();
			 $reserva->setIdReserva($fila['id_reserva']);
			 $reserva->setIdUsuario($fila['id_usuario']);
			 $reserva->setZapatos($fila['zapatos']);
			 $reserva->setIdBolera($fila['id_bolera']);
			 $reserva->setNumPersonas($fila['num_personas']);
			 $reserva->setPrecio($fila['precio']);
			 $reserva->setDia($fila['dia']);
			 $reserva->setInicio($fila['hora_inicio']);
			 $reserva->setFin($fila['hora_fin']);
			$listaRservas[] = $reserva;
		}
		return $listaRservas;
	}
}

?>