<?php

/**
 * Clase que mantiene el estado global de la aplicaciÃ³n.
 */
class Aplicacion
{
	private static $instancia;
	private $datosBD; // array con los datos necesarios para crear una conexion a la BD
	private $existe = false; //para saber si existe una aplicacion inicializada 
	private $conn; //variable de conexion a la BD
	
	private function __construct() { //constructor vacio
	}
	
	// para obtener una instancia de aplicacion
	public static function getSingleton() {
		if (  !self::$instancia instanceof self) {
			self::$instancia = new self;
		}
		return self::$instancia;
	}
	
	private function __clone()
	{
	    parent::__clone();
	}
	
	private function __wakeup()
	{
	    return parent::__wakeup();
	}

	public function init($datosBD) //funcion que inicializa la aplicacion
	{
        if (!$this->existe) {
    	    $this->datosBD = $datosBD;
    		session_start();
    		$this->existe = true;
        }
	}
	
	public function cierre() //funcion que cierra la aplicacion
	{
	    $this->compruebaInstanciaInicializada();
	    if ($this->conn !== null) {
	        $this->conn->close();
	    }
	}

	private function compruebaInstanciaInicializada()
	{
	    if (!$this->existe) {
	        echo "Aplicacion no inicializa";
	        exit();
	    }
	}

	public function conexionBD()
	{
	    $this->compruebaInstanciaInicializada();
		if (! $this->conn ) {
			$host = $this->datosBD['host'];
			$user = $this->datosBD['user'];
			$pass = $this->datosBD['pass'];
			$bd = $this->datosBD['bd'];
			
			$this->conn = new \mysqli($host, $user, $pass, $bd);
			if ( $this->conn->connect_errno ) {
				echo "Error de conexion a la BD: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
				exit();
			}
			if ( ! $this->conn->set_charset("utf8mb4")) {
				echo "Error al configurar la codificacion de la BD: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
				exit();
			}
		}
		return $this->conn;
	}
}