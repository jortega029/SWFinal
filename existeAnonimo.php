<?php
        $existe = 'no existe';
        $usuario = $_GET['nick'];
        $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
          $sql = "select nick from anonimos";
          $resul = mysqli_query($link,$sql);
          while($nick = mysqli_fetch_array($resul)){
                if ($nick[0] == $usuario) {
                    $existe = 'existe';
                }
          }
          echo $existe;
?>