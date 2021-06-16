<?php


class Talla{
	private $id_reserva;
	private $talla;
	private $unidades;
	
	
	function __construct($id_reserva, $talla, $unidades){
        $this->id_reserva = $id_reserva;
        $this->talla = $talla;
        $this->unidades=$unidades;
    }

  	//getters y setters
    public function getId()
    {
        return $this->id_reserva;
    }
     public function setId($id)
    {
        $this->id_reserva=$id_reserva;
    }
    public function getNum()
    {
      return $this->unidades;
    }
    public function setNum($unidades)
    {
      $this->unidades=$unidades;
    }
  	 public function getTalla()
    {
        return $this->talla;
    }
  
    public function setTalla($talla){
		$this->talla = $talla;
	}   
	
	
}

?>