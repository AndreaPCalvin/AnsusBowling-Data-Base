<?php

 class TOBolera {
	 private $idBolera;
	 private $numPistas;
	 private $calle;
	 private $cp;
	 private $telefono;
	 private $nombre;
 
	public function __construct(){
		$idBolera = "";
		$numPistas = "";
		$calle = "";
		$cp = "";
		$telefono = "";
		$nombre = "";
	}
	public function getIdBolera(){
		return $this->idBolera;
	}
	public function setIdBolera($idBolera){
		$this->idBolera = $idBolera;
	}
	public function getNumPistas(){
		return $this->numPistas;
	}
	public function setNumPistas($numPistas){
		$this->numPistas = $numPistas;
	}
	public function getCalle(){
		return $this->calle;
	}
	public function setCalle($calle){
		$this->calle = $calle;
	}
	public function getCP(){
		return $this->cp;
	}
	public function setCP($cp){
		$this->cp = $cp;
	}
	public function getTelefono(){
		return $this->telefono;
	}
	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
 }
?>