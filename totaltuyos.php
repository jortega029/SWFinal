<?php
      $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
            if (!$link) {
                        die("error al conectar");
            }
            $mail = $_GET['usuario'];
            $sqltotal = "select numPregunta from preguntas";
            if(!$querytotal=mysqli_query($link,$sqltotal)){
                die("Ha ocurrido un error");
            }
            $numTotal= (mysqli_num_rows($querytotal));
            $sqltuyas = "select count(numPregunta) from preguntas where email = '$mail'";
            if(!$querytuyas=mysqli_query($link,$sqltuyas)) {
                 die("Ha ocurrido un error");
            }
            $numTuyas= (mysqli_fetch_array($querytuyas)[0]);
            echo $numTotal."/".$numTuyas;
?>