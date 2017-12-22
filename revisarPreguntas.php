<?php
ob_start();
session_start();
 include('seguridad.php');
 if ($_SESSION['rol'] != 'profesor'){
  header('Location: gestionPreguntas.php');
 }
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
  <body onbeforeunload="restarConectados();">
  <div id='page-wrap'>
	<header class='main' id='h1'>
		<span class="right"><a href="registrar.php" >Registrarse</a></span>
      		<span class="right"><a href="login.php" >Login</a></span>
      		<span class="right"><a href="recuperar.php" >Recuperar Contraseña</a></span>
          <span class="logueadoDatos" id="logueadoImagen"></span></br></br>
          <span class="logueadoDatos"><label id = "usuarioMostrar"/></span>
      		<span class="right" style="display:none;" id ="logout" ><a href="logout.php">Logout</a></span>
          
          
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
	    <ul class="vertical-menu">
        <li><a href='layout.php' id="layout">Inicio</a></li>
        <li><a href='revisarPreguntas.php' id="revisar">Revisar preguntas</a></li>
        <li><a href='creditos.php' id="creditos" >Creditos</a></li>
      </ul>
	</nav>
    <section class="main" id="s1">
    

	<div>
		<form enctype="multipart/form-data" id='fpreguntas' name='fpreguntas' action="pregunta.php" method='POST'>
  <select id = "preguntas_select" name = "preguntas_select">
    <option value = 'no'> Selecciona una pregunta </option>
    <?php
      $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
         $sql = "select numPregunta, pregunta from preguntas";
         $resul = mysqli_query($link,$sql);
         while ($preg = mysqli_fetch_array($resul)) {
            echo "<option id = ".$preg['numPregunta']." value = '".$preg['numPregunta']."'>".$preg['numPregunta']. " : ".$preg['pregunta']."</option>";
         }
    ?>
  </select>
  <div id="formProf">
     
  </div>
  <label id = 'modificado'/>
		</form>
	</div>
  <div id="mostrar"></div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
  </div>
  <script type="text/javascript" src='https://code.jquery.com/jquery-3.2.1.js'></script>
  <script type="text/javascript">

	
  function logueado(nombre,imagen){
    $('.right').hide();
    $('#logout').show();
    $('#preguntas').show();
    $('#usuarioMostrar').text("Bienvenido/a " + nombre);
    $('#logueadoImagen').html('<img src="imagenes/'+imagen+'" style="height:60px;width:auto" />');
  }
  
   $('#preguntas_select').change(function() {
       $idPreg = $("#preguntas_select option:selected").val();
       $('#modificado').text('');
       if ($idPreg == 'no') {
        $('#formProf').hide();
       } else {
         $.ajax({
         type: 'POST',
         url : 'preguntasProfesor.php?operacion=mostrar&q='+ new Date().getTime(),
         data: { 'id': $idPreg},
         cache : false,
         success : function(formulario){
          $('#formProf').html(formulario);
          $('#formProf').show();
             }
         });
       }
   });
         
   
   
  
  </script>

</body>
  
</html>

   <?php
  echo (" <script>logueado('".$_SESSION['nombre']."','".$_SESSION['imagen']."'); </script>");
 ?>