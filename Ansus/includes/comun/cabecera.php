<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../estiloProyecto.css" />
	<title>Inicio</title>
</head>

<body>
<header class="super-cabecera">
    <nav>
			<a href="index.php">
            <i class="inicio"></i>
            <span class="texto">INICIO</span>
            </a>
	
            <a href="boleras.php">
            <i class="Boleras"></i>
            <span class="texto">BOLERAS</span>
            </a>
            <!--
            --><a href="reservas.php">
            <i class="Reservar_pista"></i>
            
            <span class="texto">RESERVAR PISTA</span>
            </a>
            
			<a href="ListaReservas.php">
            <i class="zapatillas"></i>
            
            <span class="texto">ZAPATILLAS</span>
            </a>
			
			<a href="gestionarReservas.php">
            <i class="texto"></i>
            
            <span class="texto" >MIS RESERVAS</span>
            </a>
            
        
		<?php 
			if(!isset($_SESSION["login"]) || $_SESSION["login"] == false){
				?>
				
			<a href='registro.php'>
            <i class="registrarse"></i>
            
            <span class="texto">REGISTRARSE</span>
            </a>
            <!--
        --><a href='login.php'>
            <i class="login"></i>
            
            <span class="texto">LOGIN</span>
            </a>
            <!--
        -->
			
				<?php
			}
			else if ($_SESSION["login"]== true){
				$nombre_user = $_SESSION["usuario"];
				?>
    				
                              
                <span id="saludo" >BIENVENID@ <?php echo $nombre_user ?></span>
               

            <a href='logout.php'>
            <i class="logout"></i>
            
            <span class="texto">LOGOUT</span>
            </a>
           <!--
        -->
				
				<?php
			}
		?>
		
    </nav>
</header>


</body>
</html>