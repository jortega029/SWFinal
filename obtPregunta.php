<?php
      session_start();
      $ids = $_SESSION['ids'];
      $numPreguntas = [];
      $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
      $sql = "select numPregunta from preguntas";
      $resul = mysqli_query($link,$sql);
      $i = 1;
      while($numPregunta = mysqli_fetch_array($resul)){
            if (!in_array($numPregunta[0], $ids )) {
                $numPreguntas[$i] = $numPregunta[0];  
            }
            $i = $i + 1;
      }
      if (!$numPreguntas) {
            echo "no";
      } else {
            $clave = array_rand($numPreguntas, 1);
            $idPregunta = $numPreguntas[$clave];
            $sql = "select pregunta, correcta, incorrecta1, incorrecta2, incorrecta3, complejidad, tema,imagen, gusta, noGusta from preguntas where numPregunta = '$idPregunta'";
            $resul = mysqli_query($link,$sql);
            $fila = mysqli_fetch_array($resul);
            $pregunta = $fila[0];
            $correcta = $fila[1];
            $incorrecta1 = $fila[2];
            $incorrecta2 = $fila[3];
            $incorrecta3 = $fila[4];
            $complejidad = $fila[5];
            $tema = $fila[6];
            $imagen = $fila[7];
            $like = $fila[8];
            $dislike = $fila[9];
            if ($imagen != null) {
                              echo "<img id = 'imgPregunta' src = 'imagenes/$imagen'/>";
            }
            echo "<form id = 'form_preg' method = 'POST'>
                        <span id = 'temaTest'>TEMA: $tema</span> <br/>
                        <span id = 'complejidad'>Complejidad: $complejidad </span> <br/><br/><br/>
                        <span id = 'preguntaTest'>$pregunta</span> <br/><br/><br/>
                        <div id = 'respuestas_todas'>";
                        $respuestas = array("<input  type = 'radio' name = 'resp' value = 'correcta'/> <label> $correcta </label> <br/>",
                                            "<input  type = 'radio' name = 'resp' value = 'incorrecta'/> <label> $incorrecta1 </label> <br/>",
                                            "<input  type = 'radio' name = 'resp' value = 'incorrecta'/> <label> $incorrecta2 </label> <br/>",
                                            "<input  type = 'radio' name = 'resp' value = 'incorrecta'/> <label> $incorrecta3 </label> <br/>");
                        shuffle($respuestas);
                        echo $respuestas[0];
                        echo $respuestas[1];
                        echo $respuestas[2];
                        echo $respuestas[3];
                        echo "<input type = 'button' class='boton' value = 'COMPROBAR' onclick = 'comprobar()'/> <br/>
                        <input type = 'button' class = 'botonLike' onclick = 'like(true)'/><input type = 'button' class = 'botonDislike' onclick = 'like(false)'/> <br/>";
                       
                       echo "<span id = 'like'>". $like."  /  ".$dislike."</span>";
                       echo " </div>
                        
                  </form>";
                  echo ";";
                  echo $idPregunta;
                  mysqli_close($link);
            
      }
?>