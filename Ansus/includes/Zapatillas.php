<?php
  class Zapatillas {

  	//Atributos 

  	private $id_reserva="";
  	private $num_zapatos="";
    private $coste="";
  	

  	//constructor
  	function __construct($id_reserva, $num_zapatos,$coste){
        $this->id_reserva = $id_reserva;
        $this->num_zapatos = $num_zapatos;
        $this->coste=$coste;
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
      return $this->num_zapatos;
    }
    public function setNum($num_zapatos)
    {
      $this->num_zapatos=$num_zapatos;
    }
  	 public function getCoste()
    {
        return $this->coste;
    }
  
    public function setCoste($coste){
		$this->coste = $coste;
	}   
}

?>