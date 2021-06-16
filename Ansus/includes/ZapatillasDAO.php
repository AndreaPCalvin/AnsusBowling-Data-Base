<?php

//Clase encargada de actualizar la información del objeto producto en la BBDD

include_once("Zapatillas.php");
require_once __DIR__ . '/Aplicacion.php';

	class ZapatillasDAO  {

		private $app;
		private $db;

		public function __construct(){
			$this->app=Aplicacion::getSingleton();
			$this->db = $this->app->conexionBD();
		}
		
		public function insert($z){
			$query = "INSERT into zapatos (id_reserva, num_zapatos, coste) values('" . $z->getId() . "','" . $z->getNum(). "','" . $z->getCoste()*2 ."')";
			$consulta = mysqli_query($this->db, $query);
			
		}
		
		public function update($z){
			$actual = self::getZapato($z->getId());
			$nuevo_num = $actual->getNum() + $z->getNum();
			$nuevo_coste = $actual->getCoste() + $z->getCoste();
			$query = "UPDATE zapatos SET num_zapatos='".$nuevo_num ."', coste='".$nuevo_coste."' WHERE id_reserva like '".$z->getId()."'";
			$consulta = mysqli_query($this->db, $query);
		}
		public static function borrar($id){	
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBD();
		
		$query = sprintf("delete from zapatos where id_reserva='%d'", 
		$conection->real_escape_string($id));

		if(!$conection->query($query)){
			return true;
		}
		else{
			return false;
		}
	}
		
		public function getZapato($id_reserva){
			$sql = "SELECT * FROM zapatos WHERE id_reserva like '".$id_reserva."'";
			$consulta = mysqli_query($this->db, $sql);
			if(mysqli_num_rows($consulta)==0){
				return false;
			}
			$fila = mysqli_fetch_assoc($consulta);
			$c = new Zapatillas($fila['id_reserva'], $fila['num_zapatos'],$fila['coste']);
			return $c;
		}
		
		public function comprobarReservaZ($id_reserva){
			$sql = "SELECT * FROM zapatos WHERE id_reserva like '".$id_reserva."'";
			$consulta = mysqli_query($this->db,$sql);
			if(mysqli_num_rows($consulta)!=0){
				return true;
			}else{
				return false;
			}
		}
		
	}
?>