<?php
    session_start();
    $idPregunta = $_GET['pregunta'];
    $tema=$_GET['tema'];
    if ($tema == 'no'){
        array_push($_SESSION['ids'],$idPregunta);
    } else{
        array_push($_SESSION['idsTema'],$idPregunta);
    }
    
?>