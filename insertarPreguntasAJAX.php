<?php
    if(isset($_GET['textoEmail']))
    {
     $email = ($_GET['textoEmail']);
     $pregunta = $_GET['textoPregunta'];
     $correcta = $_GET['textoCorrecto'];
     $incorrecta1 = $_GET['textoIncorrecto1'];
     $incorrecta2 = $_GET['textoIncorrecto2'];
     $incorrecta3 = $_GET['textoIncorrecto3'];
     $complejidad = $_GET['textoComplejidad'];
     $tema = $_GET['textoTema'];
     
     if(empty($email))
     {
      $error = "Email no puede estar vacio";
      $code = 1;
     }
     else if(!preg_match("/^([a-z])+(\d{3})+\@((ikasle.ehu)+\.)+(es|eus)+$/", $email)){
        $error = "El email no cumple el formato especificado";
        $code = 1;
     } else if(strlen($pregunta)<10) {
        $error = "La pregunta tiene que tener como mínimo 10 caracteres";
        $code = 2;
     } else if ($complejidad <1 or $complejidad > 5) {
        $error = "La complejidad tiene que ser un número entero entre 1 y 5";
        $code = 3;
     } else if (empty($correcta) or empty($incorrecta1) or empty($incorrecta2) or empty($incorrecta3) or empty($tema)) {
        $error = "Alguno de los campos obligatorios está vacío";
        $code = 4;      

     }
    
    if (!isset($error)) {

      $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
        $sql = "INSERT INTO preguntas VALUES ('','$email','$pregunta','$correcta','$incorrecta1','$incorrecta2','$incorrecta3','$complejidad','$tema','',0,0)";
        if (!mysqli_query($link,$sql)){
            die ("Ha ocurrido un error");
         }
         
        $mens="Añadida una nueva pregunta a SQL";
        echo "$mens";
        echo "</br>";
        mysqli_close($link);
        
    } else {
          echo "$error";
    }
    
    
  
    }
    
  ?>