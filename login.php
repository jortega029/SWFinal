<?php
ob_start();
session_start();
?>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='estilos/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='estilos/smartphone.css' />
  </head>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
		<span class="right"><a href="registrar.php" >Registrarse</a></span>
      		<span class="right"><a href="login.php" >Login</a></span>
      		<span class="right"><a href="recuperar.php" id ="recuperar">Recuperar Contraseña</a></span>
          <span class="logueadoDatos" id="logueadoImagen"></span></br></br>
          <span class="logueadoDatos"><label id = "usuarioMostrar"/></span>
      		<span class="right" style="display:none;" id ="logout" ><a href="logout.php">Logout</a></span>
          
          
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
	    <ul class="vertical-menu">
        <li><a href='layout.php' id="layout">Inicio</a></li>
        <li><a href='quiz.php' id="quiz">¿Cuánto sabes?. Pruébame</a></li>
        <li><a href='creditos.php' id="creditos" >Creditos</a></li>
        <li><a href='gestionPreguntas.php' id="gestionar" style="display:none">Gestionar Preguntas</a></li>
      </ul>
	</nav>
    <section class="main" id="s1">
    
	<div id="formLogin">
        <h1>Iniciar sesion</h1> </br></br>
		<form id='flogin' name='flogin' action="login.php" method='POST'>
		<p>   
			<input type='text' class="Login" id = 'loginEmail' name = 'loginEmail' value="Correo electronico" > </br> </br>  
			<input type='password' class="Login" id = 'loginPassword' name = 'loginPassword' value="Contraseña" > </br>
        </p>
      </br>
			<input type ='submit' class="Login" id="botonlogin" value='Iniciar sesion' class = "boton">
      </br>
      
		</form>
	</div>
        <label id="mensaje" style="font-size: 30px;"></label>
        <label id="error" style="color:red;font-size: 20px;"></label>
        <label id="textoBloquear" style="color:blue;font-size: 20px;"></label>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
  </div>
</body>
</html>
<script type="text/javascript" src='https://code.jquery.com/jquery-3.2.1.js'></script>
<script>
  
  function logueado(nombre,imagen){
    $('.right').hide();
    $('#layout').hide();
    $('#logout').show();
    $('#recuperar').hide();
    $('#verPreguntas').show();
    $('#verPreguntasXML').show();
    $('#gestionar').show();
    $('#preguntas').show();
    $('#usuarioMostrar').text("Bienvenido/a " + nombre);
    $('#logueadoImagen').html('<img src="imagenes/'+imagen+'" style="height:60px;width:auto" />');
  }
  
  
</script>
<?php
$mensaje="";
if (isset($_SESSION['email'])){
  if ($_SESSION['email'] == 'web000@ehu.es'){
            $_SESSION['rol']='profesor';
            header("Location: revisarPreguntas.php");
       }else{
         $_SESSION['rol']='alumno';
          header("Location: gestionPreguntas.php");
       }
}
else{
  if (isset ($_POST['loginEmail'])){
    $usuario =  $_POST['loginEmail'];
    $pass =  $_POST['loginPassword'];   
      $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
    $sql = "select * from usuarios where email = '$usuario' and contrasena = '".crypt($pass,'st')."'";
    
    $usuarios = mysqli_query($link,$sql);
    $cont = mysqli_num_rows($usuarios);
    $sqlIntentos = "select intentosLogin from usuarios where email = '$usuario'";
    $resul = mysqli_query($link,$sqlIntentos);
    $intentos = mysqli_fetch_array($resul);
    if ($intentos['intentosLogin'] >= 3) {
      echo "<script> $('#textoBloquear').text('Tu cuenta ha sido bloqueada. Para desbloquearla tienes que recuperar tu contraseña'); </script>";
    } else {
            if ($cont == 1){
                $sql= "update usuarios set intentosLogin = 0 where email = '$usuario'";
                mysqli_query($link,$sql);
                $_SESSION['email']=$usuario;
                $nombre = mysqli_fetch_array($usuarios);
                $_SESSION['nombre']=$nombre['nombre'];
                $_SESSION['imagen']=$nombre['foto'];
                
               if ($usuario == 'web000@ehu.es'){
                    $_SESSION['rol']='profesor';
                    header("Location: revisarPreguntas.php");
               }else{
                    $_SESSION['rol']='alumno';
                    $xml = simplexml_load_file("contador.xml");
                    $noAct = $xml -> usuarios;
                    $conectados = ($noAct + 1); 
                    $xml -> usuarios = $conectados;
                    $xml -> asXML('contador.xml');
                    header("Location: gestionPreguntas.php");
                }         
            }
            else{
              $mensaje = "Usuario o contraseña incorrectos, intentalo de nuevo";
            $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
              $sql1= "update usuarios set intentosLogin = intentosLogin + 1 where email = '$usuario'";
              mysqli_query($link,$sql1);
              $sql2 = "select intentosLogin from usuarios where email = '$usuario'";
              $resul = mysqli_query($link,$sql2);
              $intentos = mysqli_fetch_array($resul);
              if ($intentos['intentosLogin'] >= 3) {
                echo "<script> $('#textoBloquear').text('Tu cuenta ha sido bloqueada. Para desbloquearla tienes que recuperar tu contraseña'); </script>";
              } else  {
                echo "<script> $('#textoBloquear').text('Usuario o contraseña incorrectos, inténtalo de nuevo... '); </script>";
              }
              
            }
            
            
    }
  }
}
?>