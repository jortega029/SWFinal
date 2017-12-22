<?php
    ob_start();
	session_start();
?>
<?php
    $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
    $datos = mysqli_query($link,"select * from preguntas where email='".$_SESSION['email']."'");
    echo '<table border=1 style = "width:auto;background-color:white;" > <tr style="background-color:pink;"> <th> NUMERO_PREGUNTA </th> <th> EMAIL  </th> <th> PREGUNTA </th> <th> COMPLEJIDAD  </th> <th> TEMA  </th> </tr>';
    while ($row = mysqli_fetch_array($datos)){
        echo '<tr><td style="height:200px;">'.$row['numPregunta'].'</td><td>'.$row['email'].'</td><td>'.$row['pregunta'].'</td><td>'.$row['complejidad'].'</td><td>'.$row['tema'].'</td></tr>';
    }
    echo  '</table>';
    $datos -> close();
    mysqli_close($link);
?>
