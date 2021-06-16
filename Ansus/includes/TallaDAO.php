<?php

include_once 'Talla.php';
require_once __DIR__ . '/Aplicacion.php';

	class TallaDAO{
		
		private $app;
		private $db;

		public function __construct(){
			$this->app=Aplicacion::getSingleton();
			$this->db = $this->app->conexionBD();
		}
		
		public function insert($t){
			$query = "INSERT into tallas (id_reserva, talla, unidades) values('" . $t->getId() . "','" .$t->getTalla() . "','" . $t->getNum() ."')";
			$consulta = mysqli_query($this->db, $query);
		}
		
		public function update($t){
			$actual = self::getTalla($t->getId(), $t->getTalla());
			$nuevo_num = $actual->getNum() + $t->getNum();
			$query = "UPDATE tallas SET unidades='".$nuevo_num ."' WHERE id_reserva like '".$t->getId()."' AND talla like'".$t->getTalla()."'";
			$consulta = mysqli_query($this->db, $query);
		}
		
		public function getTalla($id_reserva, $talla){
			$sql = "SELECT * FROM tallas WHERE id_reserva like '".$id_reserva."' AND talla like '".$talla."'";
			$consulta = mysqli_query($this->db, $sql);
			if(mysqli_num_rows($consulta)==0){
				return false;
			}
       		$fila = mysqli_fetch_assoc($consulta);
			$c = new Talla($fila['id_reserva'], $fila['talla'],$fila['unidades']);
			return $c;
		}
		
		public function getTodas($id_reserva){
			$sql = "SELECT * FROM tallas WHERE id_reserva like '".$id_reserva."'";
			$consulta = mysqli_query($this->db, $sql);
			if(mysqli_num_rows($consulta)==0){
				return false;
			}
			$c = array();
       		while ($fila = mysqli_fetch_assoc($consulta)){
				$c[] = new Talla($fila['id_reserva'], $fila['talla'],$fila['unidades']);
			}
			return $c;
		}
		
		public function comprobarTalla($id_reserva, $talla){
			$sql = "SELECT * FROM tallas WHERE id_reserva like '".$id_reserva."' AND talla like '".$talla."'";
			$consulta = mysqli_query($this->db,$sql);
			if(mysqli_num_rows($consulta)!=0){
				return true;
			}else{
				return false;
			}
		}
		
	}


?>