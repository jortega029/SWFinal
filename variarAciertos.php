<?php
session_start();
if ($_SESSION['nick'] != "") {
    $nick = $_SESSION['nick'];
    $operacion = $_GET['operacion'];
    $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
          
    if ($operacion == 'acierto') {
        $sql = "update anonimos set aciertos = aciertos + 1 where nick = '$nick'";
        $sql2 = "update anonimos set diferencia = diferencia + 1 where nick = '$nick'";
    } else if ($operacion == 'fallo') {
        $sql = "update anonimos set fallos = fallos + 1 where nick = '$nick'";
        $sql2 = "update anonimos set diferencia = diferencia - 1 where nick = '$nick'";
    }
    mysqli_query($link,$sql);
    mysqli_query($link,$sql2);
    mysqli_close($link);
}

?>