<?php
      session_start();
      $ids = $_SESSION['idsTema'];
      $num = $_SESSION['preguntasPorTema'];
      $tema = $_GET['tema'];
      if ($num >= 3){
        echo "no";
        echo ";";
        $sumCompl = $_SESSION['complejidades'][0];
        $numCompl = $_SESSION['complejidades'][1];
        $mediaComplejidades = $sumCompl / $numCompl;
        echo "<p>La complejidad media de las preguntas ha sido de ".$mediaComplejidades."</p>";
      }
      else{
          $numPreguntas = [];
          $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
          $sql = "select numPregunta from preguntas where tema='".$tema."'";
          $resul = mysqli_query($link,$sql);
          $i = 1;
          while($numPregunta = mysqli_fetch_array($resul)){
                if (!in_array($numPregunta[0], $ids )) {
                    $numPreguntas[$i] = $numPregunta[0];
                }
                $i = $i + 1;
          }
          if (!$numPreguntas) {
              if ($num != 0) {
                echo "no";
                echo ";";
                $sumCompl = $_SESSION['complejidades'][0];
                $numCompl = $_SESSION['complejidades'][1];
                $mediaComplejidades = $sumCompl / $numCompl;
                echo "<p>La complejidad media de las preguntas ha sido de ".$mediaComplejidades."</p>";
              } else {
                echo "no";
                echo ";";
              }
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
                $_SESSION['complejidades'][0] += $complejidad;
                $_SESSION['complejidades'][1] += 1;
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
                            $si='si';
                            echo "<input type = 'button' class='boton' value = 'COMPROBAR' onclick = 'comprobarPorTema()'/> <br/>
                            <input type = 'button' class = 'botonLike' onclick = 'like(true)'/><input type = 'button' class = 'botonDislike' onclick = 'like(false)'/> <br/>";
                           
                           echo "<span id = 'like'>". $like."  /  ".$dislike."</span>";
                           echo " </div>
                            
                      </form>";
                      echo ";";
                      echo $idPregunta;
                    
                $_SESSION['preguntasPorTema'] = $_SESSION['preguntasPorTema'] + 1;
          }
      }
      
?>