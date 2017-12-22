<?php
ob_start();
session_start();
if (isset($_SESSION['rol'])){
    if ($_SESSION['rol'] == 'alumno'){
        header("Location: gestionPreguntas.php");
    }
    else if ($_SESSION['rol'] == 'profesor'){
        header("Location: revisarPreguntas.php");
    }
}
?>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Recuperar</title>
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
      		<span class="right"><a href="recuperar.php" >Recuperar Contraseña</a></span>
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
      </ul>
		
	</nav>
    <section class="main" id="s1">
    
	<div>
	    <div id ="compr">
	    <label id="mensaje" style="color:black;"></label><br/><br/>
	    <input type="text" id="numero" style="display:none;"/><br/><br/>
	    <input type="button" id="comprobarNumero" value="Confirmar" style="display:none;"/>
	    </div>
        <div id="fregistrar">
			<p>Introduce tu correo electr&oacute;nico:   
			<input type='text' id = 'textoEmail' name = 'textoEmail'> </br>
			<input type ='button' id="botonenviar" value='Recuperar contraseña' class = "boton">
			</div>
		<div id="cambiar">
		    <label id ="cambio1"class="cambio" style="color:black;"></label><br/><br/>
    	    <input type="password" id="pass1" class="cambio" style="display:none;"/><br/><br/>
    	    <label id="cambio2" class="cambio" style="color:black;"></label><br/><br/>
    	    <input type="password" id="pass2" class="cambio" style="display:none;"/><br/><br/>
    	    <input type="button" id="confirmar"class="cambio" value="Confirmar" style="display:none;"/><br/><br/>
    	    <label id="mensajePass"></label>
		</div>
      </br></br>
      <div class="error">
        <label id="mensaje" style="color:black;"></label>
      </div>


</body>

	</div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
  </div>
  </html>
 <script type="text/javascript" src='https://code.jquery.com/jquery-3.2.1.js'></script>
 <script>
    var num = 123456789;
     $('#botonenviar').click(function(){
         var email = $('#textoEmail').val();
         $.ajax({
             type:"post",
            url : 'enviarMail.php',
            cache : false,
            data:{'email': email},
            success : function(data) {
                if (data == 'NO'){
                    $('#mensaje').text("Ha ocurrido un problema, vuelve a intentarlo");
                }
                else{
                    num = data;
                     $('#mensaje').text("Se ha enviado el correo de recuperacion, inserta aquí el número que te hemos mandado:("+num+")");
                     $('#fregistrar').hide();
                    $('#numero').show();
                    $('#comprobarNumero').show();
                }
             
            }       
        });
     });
     
     $('#comprobarNumero').click(function(){
         $('#mensaje').hide();
         var numero = $('#numero').val();
         if (num == numero){
            $('#cambio1').text("Introduce aqui la nueva contraseña:");
            $('#cambio2').text("Repite aqui la nueva contraseña:");
            $('.cambio').show();
            $('#numero').hide();
            $('#comprobarNumero').hide();
         }
         else{
             alert("Ese no es el número, vuelve a inentarlo");
             window.location.href = "recuperar.php";
         }
     });
     
     $('#confirmar').click(function(){
         var pass1 = $('#pass1').val();
         var pass2 = $('#pass2').val();
         var email = $('#textoEmail').val();
         if(pass1 == pass2){
             $.ajax({
                 type:"post",
                url : 'cambiarPass.php',
                cache : false,
                data:{'pass': pass1, 'email': email},
                success : function(data) {
                    if (data == 'si'){
                        alert("La contraseña se ha cambiado correctamente");
                        window.location.href = "login.php";
                    }
                    else if (data == 'no'){
                        alert("Ha ocurrido algun error, vuelve a intentarlo");
                        window.location.href = "recuperar.php";
                    }
                }       
            });
         }
         else{
             $('#mensajePass').show();
             $('#mensajePass').text("Las contraseñas no coinciden");
         }
         
     });
     
     $('#pass1').focus(function(){
         $('#mensajePass').hide();
     });
     $('#pass2').focus(function(){
         $('#mensajePass').hide();
     });
 </script>