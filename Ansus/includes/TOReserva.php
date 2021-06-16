<?php

 class TOReserva {
	 private $id_reserva;
	 private $idUser;
	 private $zapatos;
	 private $pista;
	 private $idBolera;
	 private $numPersonas;
	 private $precio;
	 private $dia;
	 private $inicio;
	 private $fin;

	 
	public function __construct(){
		$id_reserva = "";
	  $idUser= "";
	  $zapatos= "";
	  $pista= "";
	  $idBolera= "";
	  $numPersonas= "";
	  $precio= "";
	  $dia= "";
	  $inicio= "";
	  $fin= "";
	}
	
	public function getIdReserva(){
		return $this->id_reserva;
	}
	public function getIdUsuario(){
		return $this->idUser;
	}
	public function getZapatos(){
		return $this->zapatos;
	}
	public function getIdPista(){
		return $this->pista;
	}
	public function getIdBolera(){
		return $this->idBolera;
	}
	public function getNumPersonas(){
		return $this->numPersonas;
	}
	public function getPrecio(){
		return $this->precio;
	}
	public function getDia(){
		return $this->dia;
	}
	public function getInicio(){
		return $this->inicio;
	}
	public function getFin(){
		return $this->fin;
	}
		
	
	public function setIdReserva($data){
		$this->id_reserva = $data;
	}
	public function setIdUsuario($data){
		$this->idUser = $data;
	}
	public function setZapatos($data){
		$this->zapatos = $data;
	}
	public function setIdPista($data){
		$this->pista = $data;
	}
	public function setIdBolera($data){
		$this->idBolera = $data;
	}
	public function setNumPersonas($data){
		$this->numPersonas = $data;
	}
	public function setPrecio($data){
		$this->precio = $data;
	}
	public function setDia($data){
		$this->dia = $data;
	}
	public function setInicio($data){
		$this->inicio = $data;
	}
	public function setFin($data){
		$this->fin = $data;
	}
	
 }
?>