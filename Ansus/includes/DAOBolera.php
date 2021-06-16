<?php
include_once "TOBolera.php";
class DAOBolera
{
	public static function create($bolera){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$idBolera = $bolera->getIdBolera();
		$numPistas = $bolera->getNumPistas();
		$calle = $bolera->getCalle();
		$cp = $bolera->getCP();
		$telefono = $bolera->getTelefono();
		$nombre = $bolera->getNombre();
		
		$query = sprintf("insert into bolera(id_bolera, num_pistas, calle, cp, telefono, nombre) 
			values('%d', '%d', '%s', '%d', '%d', '%s')",
			$conection->real_escape_string($idBolera),
			$conection->real_escape_string($numPistas),
			$conection->real_escape_string($calle),
			$conection->real_escape_string($cp),
			$conection->real_escape_string($telefono),
			$conection->real_escape_string($nombre)
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
		
		$query = sprintf("SELECT * FROM bolera WHERE id_bolera = '%d'", $conection->real_escape_string($id));
		$result = $conection->query($query);
		
		if ($result->num_rows == 0){
			return NULL;
		}

		$bolera = new TOBolera();
		$fila = $result->fetch_assoc();
		
		 $bolera->setIdBolera($fila['id_bolera']);
		 $bolera->setNumPistas($fila['num_pistas']);
		 $bolera->setCalle($fila['calle']);
		 $bolera->setCP($fila['cp']);
		 $bolera->setTelefono($fila['telefono']);
		 $bolera->setNombre($fila['nombre']);
		
		return $bolera;	
	}

	public static function update($bolera){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$idBolera = $bolera->getIdBolera();
		$numPistas = $bolera->getNumPistas();
		$calle = $bolera->getCalle();
		$cp = $bolera->getCP();
		$telefono = $bolera->getTelefono();
		$nombre = $bolera->getNombre();
		
		$query = sprintf("update bolera set id_bolera='%d', num_pistas='%d', calle='%s', cp='%d', telefono='%d',
			nombre='%s'
			where id_bolera='%d'",
			$conection->real_escape_string($idBolera),
			$conection->real_escape_string($numPistas),
			$conection->real_escape_string($calle),
			$conection->real_escape_string($cp),
			$conection->real_escape_string($telefono),
			$conection->real_escape_string($nombre)
		);
		
		if(!$conection->query($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function delete($id){	
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$query = sprintf("delete from bolera where id_bolera='%d'", 
		$conection->real_escape_string($id));

		if(!$conn->query($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function listarBoleras(){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$query = sprintf("SELECT * FROM bolera ");
		$result = $conection->query($query);

		if ($result->num_rows == 0){
			return NULL;
		}

		while($fila = $result->fetch_assoc()){
			$bolera = new TOBolera();
			$bolera->setIdBolera($fila['id_bolera']);
			$bolera->setNumPistas($fila['num_pistas']);
			$bolera->setCalle($fila['calle']);
			$bolera->setCP($fila['cp']);
			$bolera->setTelefono($fila['telefono']);
			$bolera->setNombre($fila['nombre']);
			
			$listaBoleras[] = $bolera;
		}
		return $listaBoleras;
	}
	
	 public static function getRowCount(){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
      $query = sprintf("SELECT * FROM bolera");
      $result = $conection->query($query);
      $n = 0;
      while($row = $result->fetch_assoc()){
        if ($n <= $row['id_bolera']) {
          $n = $row['id_bolera'] + 1;
        }
      }
      return $n;
    }
	
	public static function buscarBoleraCP($codpost){	
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();

		$sql = sprintf("SELECT * FROM bolera WHERE cp=$codpost"
			, $conection->real_escape_string($codpost));
		
       $result = $conection->query($sql);
	
	   $listaBoleras = NULL;
		while($fila = $result->fetch_assoc()){
			$bolera = new TOBolera();
			$bolera->setIdBolera($fila['id_bolera']);
			$bolera->setNumPistas($fila['num_pistas']);
			$bolera->setCalle($fila['calle']);
			$bolera->setCP($fila['cp']);
			$bolera->setTelefono($fila['telefono']);
			$bolera->setNombre($fila['nombre']);
			
			$listaBoleras[] = $bolera;
		}
		return $listaBoleras;
		
	}
	
	public static function buscarBoleraUbi($lugar){	
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();

		$sql = sprintf("SELECT * FROM bolera as b JOIN ubicacion as u ON b.cp = u.CP
			WHERE ciudad LIKE '%%%s%%' OR provincia LIKE '%%%s%%' OR calle LIKE '%%%s%%'"
			, $conection->real_escape_string($lugar),
			$conection->real_escape_string($lugar)
			, $conection->real_escape_string($lugar));
		
		
       $result = $conection->query($sql);

      $listaBoleras = NULL;

		while($fila = $result->fetch_assoc()){
			$bolera = new TOBolera();
			$bolera->setIdBolera($fila['id_bolera']);
			$bolera->setNumPistas($fila['num_pistas']);
			$bolera->setCalle($fila['calle']);
			$bolera->setCP($fila['cp']);
			$bolera->setTelefono($fila['telefono']);
			$bolera->setNombre($fila['nombre']);
			
			$listaBoleras[] = $bolera;
		}
		return $listaBoleras;
		
	}
	
	public static function buscarBoleraProvincia($codpost){	
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$miCP=intdiv($codpost, 1000);
		$sql = sprintf("SELECT * FROM bolera WHERE cp LIKE '%s%%'"
			, $conection->real_escape_string($miCP));
		
       $result = $conection->query($sql);
	
	   $listaBoleras = NULL;
		while($fila = $result->fetch_assoc()){
			$bolera = new TOBolera();
			$bolera->setIdBolera($fila['id_bolera']);
			$bolera->setNumPistas($fila['num_pistas']);
			$bolera->setCalle($fila['calle']);
			$bolera->setCP($fila['cp']);
			$bolera->setTelefono($fila['telefono']);
			$bolera->setNombre($fila['nombre']);
			
			$listaBoleras[] = $bolera;
		}
		return $listaBoleras;
		
	}
	
	public static function buscaBoleraNombre($nombre){	
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();

		$sql = sprintf("SELECT * FROM bolera 
			WHERE nombre LIKE '%%%s%%' "
			, $conection->real_escape_string($nombre));
		
		
       $result = $conection->query($sql);

      $listaBoleras = NULL;

		while($fila = $result->fetch_assoc()){
			$bolera = new TOBolera();
			$bolera->setIdBolera($fila['id_bolera']);
			$bolera->setNumPistas($fila['num_pistas']);
			$bolera->setCalle($fila['calle']);
			$bolera->setCP($fila['cp']);
			$bolera->setTelefono($fila['telefono']);
			$bolera->setNombre($fila['nombre']);
			
			$listaBoleras[] = $bolera;
		}
		return $listaBoleras;
		
	}
	
	public static function getPistasOcupadasEnXHorario($idbolera, $dia, $ini, $fin){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		$query = sprintf("SELECT * FROM reservas WHERE id_bolera=$idbolera AND dia=$dia AND
			 ($ini < hora_fin) AND ($fin > hora_inicio)");
		
		$result = $conection->query($query);
		
		@$n = $result->num_rows;
		return $n;
		
	}
}

?>