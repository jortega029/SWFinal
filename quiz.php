<?php
session_start();
if (isset($_SESSION['rol'])) {
  header("Location:layout.php");
}
if (!isset($_SESSION['ids'])) {
  $_SESSION['ids'] = array();
}
if (!isset($_SESSION['preguntasPorTema'])){
  $_SESSION['preguntasPorTema']=0;
}
if (!isset($_SESSION['idsTema'])){
  $_SESSION['idsTema']=array();
}
if (!isset($_SESSION['complejidades'])){
  $_SESSION['complejidades']=array(0,0);
}
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
  <script type="text/javascript" src='https://code.jquery.com/jquery-3.2.1.js'></script>
  <script type="text/javascript">

    var numPreg;
    var acertadas = 0;
    var falladas = 0;
    $( document ).ready(function() {
     
     setInterval("actualizarLikes()",20000);
      $('select[name=temas]').change(function(){ acertadas = 0; falladas=0; $('#aciertos').html("");
        var tema = $('select[name=temas]').val();
        $.ajax({
            url : 'inicializarValores.php',
            cache : false
        });
        if (tema == 'todos') {
          cargarPregunta();
        } else {
          cargarPreguntaPorTema();      
        }
      });
      
    });
    
    function comprobar() {
    var radio = document.getElementsByName('resp');
    var valor = '';
    for(i=0;i<radio.length;i++) {
        if (radio[i].checked) { 
            valor = radio[i].value;  
        }
    }
    if (valor == 'incorrecta') {
        respondida('no');
      alert ("No has acertado");
      cargarPregunta();
      aciertoFallo('fallo');
    } else if (valor == 'correcta') {
        respondida('no');
      alert ("¡Has acertado!");
      cargarPregunta();
      aciertoFallo('acierto');
    } else {
      alert ("Debes responder la pregunta, elige una de las opciones");
    }
    
    
}


  function cargarPregunta() {
        $.ajax({
        url : 'obtPregunta.php',
        cache : false,
        success : function(data) {
          if (data == "no") {
            alert ("Ya no quedan más preguntas.");
          } else {
            var array = data.split(';');
            $('#respuestas').html(array[0]);
            numPreg = array[1];
          }
        }
        });
    }
    
    function like (lk) {
                         $.ajax({
                              type: 'GET',
                              url : 'anadirLike.php?like='+lk+'&id='+numPreg,
                              cache : false,
                              success : function(data) {
                                if (data == 'bien') {
                                  $('.botonLike').attr('disabled', 'disabled');
                                  $('.botonDislike').attr('disabled', 'disabled');
                                  actualizarLikes();
                                }
                              }
                              });
    }
    
    function actualizarLikes() {
              $.ajax({
                              type: 'GET',
                              url : 'actualizarLikes.php?id='+numPreg,
                              cache : false,
                              success : function(data) {
                                $('#like').text(data);
                              }
                              });
    }
    
    function cargarTema (nick) {
          $.ajax({
              type: 'GET',
              url : 'obtenerTemas.php?nick='+nick,
              cache : false,
              success : function(data) {
                $('#temas').html(data);
                $('#tema').show();
              }
          });
    }
    
    function cargarPreguntaPorTema(){
      var tema = $('select[name=temas]').val();
        $.ajax({
            type: 'GET',
            url : 'obtenerPreguntasPorTema.php?tema='+tema,
            cache : false,
            success : function(data) {
              var array = data.split(';');
              if (array[0] == "no"){
                alert("No quedan mas preguntas");
                $('#respuestas').html("Has acertado "+acertadas+" preguntas y has fallado "+falladas);
                $('#aciertos').html(array[1]);
              } else{
                $('#respuestas').html(array[0]);
                numPreg = array[1];
              }
                
            }
        });
    }
    
    function comprobarPorTema() {
    var radio = document.getElementsByName('resp');
    var valor = '';
    for(i=0;i<radio.length;i++) {
        if (radio[i].checked) { 
            valor = radio[i].value;  
        }
    }
    if (valor == 'incorrecta') {
        respondida('si');
        alert ("No has acertado");
        falladas = falladas + 1;
        cargarPreguntaPorTema();
        aciertoFallo('fallo');
    } else if (valor == 'correcta') {
        respondida('si');
        alert ("¡Has acertado!");
        acertadas = acertadas + 1;
        cargarPreguntaPorTema();
        aciertoFallo('acierto');
    } else {
        alert ("Debes responder la pregunta, elige una de las opciones");
    }
}

  function comprobarNick() {
    var nick = $('#nick').val();
    if (nick == "") {
      if(confirm("Si dejas vacío tu nick no tomarás parte en las clasificaciones ¿Deseas continuar?")) {
        $('#respuestas').html("");
        cargarTema("");
        cargarPregunta();
      }
    } else {
       $.ajax({
            type: 'GET',
            url : 'existeAnonimo.php?nick='+nick,
            cache : false,
            success : function(data) {
              if(data == 'existe') {
                  if(confirm("El nick " + nick + " ya está cogido. ¿Eres tú?")) {
                    cargarTema(nick);
                    $('#respuestas').html("");
                    cargarPregunta();
                  } else {
                    alert("Introduce un nuevo nick");
                    $('#nick').val("");
                  }
              } else{
                crearNick(nick);
                $('#respuestas').html("");
                cargarTema(nick);
                cargarPregunta();
              }
            }
        });
      
      
    }
  }
  
  function crearNick(nick){
    $.ajax({
            type: 'GET',
            url : 'crearNick.php?nick='+nick,
            cache : false
        });
  }
  
  function aciertoFallo(acierto) {
    $.ajax({
            type: 'GET',
            url : 'variarAciertos.php?operacion='+acierto,
            cache : false
        });
  }
  
  function respondida(tema){
      $.ajax({
            type:'GET',
            url : 'anadirRespondida.php?pregunta='+numPreg+'&tema='+tema,
            cache : false
        });
  }


    

    
  </script>
  </head>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
		<span class="right"><a href="registrar.php">Registrarse</a></span>
      		<span class="right"><a href="login.php">Login</a></span>
      		<span class="right"><a href="recuperar.php" >Recuperar Contraseña</a></span>
      		<span class="right" style="display:none;"><a href="logout.php">Logout</a></span>
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
    <div id = 'tema' style="display:none;">
      Selecciona un tema:
      <select id = 'temas' name='temas' ><select/>
    </div>
  
	<div id = "respuestas">
         Introduce tu nick de usuario (si nunca has participado, pon uno nuevo).
        <input type = "text" id = "nick" placeholder = "Nick"/> <br/>
        <input type = "button" class="boton" onclick = "comprobarNick();" value = "CONTINUAR"/>
	</div>
  
  <div id = "aciertos">
    
  </div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
</div>
</body>
</html>