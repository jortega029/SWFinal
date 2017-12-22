<?php
session_start();
    $nick = $_GET['nick'];
    if ($nick != ""){
        $_SESSION['nick'] = $nick;
    } else {
        $_SESSION['nick'] = "";
    }
    $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
    $sql = "select distinct tema from preguntas";
    $opciones = "<option value = 'todos'> Todos los temas </option>";    
        if ($result = mysqli_query($link,$sql)) {
            while($fila = mysqli_fetch_array($result)) {
                $tema = $fila[0];
                $opciones = $opciones. "<option value = $tema> $tema </option>";
            }
            echo $opciones;
        }
?>