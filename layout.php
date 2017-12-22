<?php
session_start();
?>
<!DOCTYPE html>
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
		<span class="right"><a href="registrar.php">Registrarse</a></span>
      		<span class="right"><a href="login.php">Login</a></span>
      		<span class="right"><a href="recuperar.php" >Recuperar Contraseña</a></span>
      		<span class="logueadoDatos" id="logueadoImagen"></span></br></br>
          <span class="logueadoDatos"><label id = "usuarioMostrar"/></span>
      		<span class="right" style="display:none;" id ="logout"><a href="logout.php">Logout</a></span>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
	    <ul class="vertical-menu">
        <li><a href='layout.php' id="layout">Inicio</a></li>
        <li><a href='revisarPreguntas.php' id="revisar" style="display:none">Revisar preguntas</a></li>
        <li><a href='quiz.php' id="quiz">¿Cuánto sabes?. Pruébame</a></li>
        <li><a href='creditos.php' id="creditos" >Creditos</a></li>
        <li><a href='gestionPreguntas.php' id="gestionar" style="display:none">Gestionar Preguntas</a></li>
      </ul>

	</nav>
	
	
    <section class="main" id="s1">
    
	<div>
    <h1>TOP 10 QUIZERS</h1><br/><br/>
    <table id = 'ranking'>
      <tr>
        <th>
          Nick
        </th>
        <th>
          Aciertos
        </th>
        <th>
          Fallos
        </th>
        <th>
          Puntuación
        </th>
      </tr>
	<?php
    $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
    $sql = "select nick,aciertos,fallos,diferencia from anonimos order by diferencia desc";
    $resul = mysqli_query($link,$sql);
    $i = 0;
    while($fila = mysqli_fetch_array($resul)){
          if ($i < 10){
            echo "<tr>
                    <td>
                      ".$fila[0]."
                    </td>
                    <td>
                      ".$fila[1]."
                    </td>
                    <td>
                      ".$fila[2]."
                    </td>
                    <td>
                      ".$fila[3]."
                    </td>
                  </tr>";
          }
          $i = $i + 1;
    }
  ?>
    </table>
	</div>
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
          function logueado(nombre,imagen,rol){
            $('.right').hide();
            $('#logout').show();
            $('#quiz').hide();
            $('#usuarioMostrar').text("Bienvenido/a " + nombre);
            $('#logueadoImagen').html('<img src="imagenes/'+imagen+'" style="height:60px;width:auto" />');
            if (rol == 'profesor'){
              $('#revisar').show();
              $('#gestionar').hide();
            }
            else if (rol == 'alumno'){
              $('#revisar').hide();
              $('#gestionar').show();
            }
          }
</script>

<?php


if (isset($_SESSION['email'])){
    echo " <script> logueado('".$_SESSION['nombre']."','".$_SESSION['imagen']."','".$_SESSION['rol']."'); </script>";
  }

?>