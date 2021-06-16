<?php

require_once __DIR__ . '/Aplicacion.php';


class Usuario{

	private $DNI;
	private $password;
	private $nombre;
	private $apellidos;
	private $telefono;
	private $nombre_usuario;
	
	private function __construct ($DNI, $nombre, $apellidos, $telefono, $contrasena, $nombre_usuario){
		$this->DNI = $DNI;
        $this->password = $contrasena;
        $this->nombre = $nombre;
		$this->apellidos = $apellidos;
		$this->telefono = $telefono;
		$this->nombre_usuario = $nombre_usuario;
	}
	
	//getters y setters
  	public function getNombreUsuario()
    {
        return $this->nombre;
    }
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombre = $nombreUsuario;
    }
	
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
	public function getDNI()
    {
        return $this->DNI;
    }
	
	//Devuelve un objeto Usuario con la información del usuario $nombreUsuario, o false si no lo encuentra.
	public static function buscaUsuarioDNI($DNI){
		//acceso a la base de datos
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBD();
		$query = sprintf("SELECT * FROM usuarios WHERE DNI = '%s'", $conn->real_escape_string($DNI));
		$rs = $conn->query($query);
		$result = false;
		//comprobamos la consulta
		if($rs){ 
			if ( $rs->num_rows == 1) {// si hay una unica fila es que hemos encontrado el usuario
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['DNI'], $fila['nombre'], $fila['apellidos'], $fila['telefono'], $fila['idsocio'], $fila['contrasena'], $fila['nombre_usuario']);
                $result = $user;
			}
			$rs->free();
		}else{ 
			echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
		}
		return $result;
	}
	public static function buscaUsuario($usuario){
		//acceso a la base de datos
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBD();
		$query = sprintf("SELECT * FROM usuarios WHERE nombre_usuario = '%s'", $conn->real_escape_string($usuario));
		$rs = $conn->query($query);
		$result = false;
		//comprobamos la consulta
		if($rs){ 
			if ( $rs->num_rows == 1) {// si hay una unica fila es que hemos encontrado el usuario
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['DNI'], $fila['nombre'], $fila['apellidos'], $fila['telefono'], $fila['contrasena'], $fila['nombre_usuario']);
                $result = $user;
			}
			$rs->free();
		}else{ 
			echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
		}
		return $result;
	}
	
	// Usando las funciones anteriores, devuelve un objeto Usuario si el usuario existe y coincide su contraseña. En caso contrario, devuelve false.
	public static function login($nombre_usuario, $password){
		$usuario = self::buscaUsuario($nombre_usuario);
		if( $usuario && $usuario->compruebaPassword($password)){
			return $usuario;
		}
		return false;
	}
	
	//Crea un nuevo usuario con los datos introducidos por parámetro.
	public static function crea($DNI, $nombre, $apellidos, $telefono, $contrasena, $nombre_usuario){
		$usuario = self::buscaUsuarioDNI($DNI);
		$usuario2 = self::buscaUsuario($nombre_usuario);
		if($usuario){
			return false; // si el usuario existe no podemos crear otro igual
		}else if($usuario2){
			return false;
		}
		$usuario = new Usuario($DNI, $nombre, $apellidos, $telefono, password_hash($contrasena, PASSWORD_DEFAULT), $nombre_usuario);
		return self::inserta($usuario);
	}
	
	//inserta el nuevo usuario en la base de datos
	private static function inserta($usuario){
		//acceso a la base de datos
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBD();
		$query=sprintf("INSERT INTO usuarios(DNI, nombre_usuario, nombre, apellidos, telefono, contrasena) VALUES('%s','%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->DNI)
			, $conn->real_escape_string($usuario->nombre_usuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellidos)
			, $conn->real_escape_string($usuario->telefono)
			, $conn->real_escape_string($usuario->password));
		$rs = $conn->query($query);
		if($rs){
			// todo bien
		}
		else{
			echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
		}
		return $usuario;
	}

	
	public function actualiza($u)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$query =sprintf("UPDATE usuario set user='".$u->getNombreUsuario()."',password='".$u->getPassword()."',permisos='".$u->getRol()."' WHERE user like '".$u->getNombreUsuario()."'");
        if ( $conn->query($query) ) {

        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $u;
    }
	
	// Comprueba si la contraseña introducida coincide con la del Usuario
	public function compruebaPassword($password){
		return password_verify($password, $this->password); //usamos la funcion que verifica que las contraseñas son iguales
	}
}

?>