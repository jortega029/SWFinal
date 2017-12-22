<?php
    $numPreg = $_GET['id']; 
     $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
     $sql = "select gusta, noGusta from preguntas where numPregunta = $numPreg";
        
        if ($result = mysqli_query($link,$sql)) {
            $fila = mysqli_fetch_array($result);
            $like = $fila[0];
            $dislike = $fila[1];
            echo $like."  /  ".$dislike;
        } else {
            echo "Cargando...";
        }
?>