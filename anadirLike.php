<?php
    $numPreg = $_GET['id'];
    $like = $_GET['like'];
    $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");

    if ($like == 'true') {
        $sql = "update preguntas set gusta = gusta + 1 where numPregunta = $numPreg";
    } else {
        $sql = "update preguntas set noGusta = noGusta + 1 where numPregunta = $numPreg";
    }
    
    if (mysqli_query($link,$sql)) {
        echo "bien";
    } else {
        echo "mal";
    }
    
    mysqli_close($link);

?>