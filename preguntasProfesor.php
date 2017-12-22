<?php
    $id = $_POST['id'];
      $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
    $sql = "select * from preguntas where numPregunta = $id";
    $resul = mysqli_query($link,$sql);
    $pregunta = mysqli_fetch_array($resul);
    if($_GET['operacion'] == 'mostrar') {
        echo "
        ID pregunta:
         <input type = 'text' id ='id' value='".$id."' readonly='readonly'/></br>
         Autor:
         <input type = 'text' id ='email' value = '".$pregunta['email']."' readonly='readonly'/> </br>
         Pregunta:
         <input type = 'text' id ='pregunta'  placeholder ='".$pregunta['pregunta']."' /></br>
         Correcta:
         <input type = 'text' id ='correcta' placeholder ='".$pregunta['correcta']."'/></br>
         Incorrecta 1:
         <input type = 'text' id ='incorrecta1' placeholder ='".$pregunta['incorrecta1']."'/></br>
         Incorrecta 2:
         <input type = 'text' id ='incorrecta2' placeholder ='".$pregunta['incorrecta2']."'/></br>
         Incorrecta 3:
         <input type = 'text' id ='incorrecta3' placeholder ='".$pregunta['incorrecta3']."'/></br>
         Complejidad:
         <input type = 'text' id ='complejidad' placeholder ='".$pregunta['complejidad']."'/></br>
         Tema:
         <input type = 'text' id='tema' placeholder ='".$pregunta['tema']."'/> </br> </br>
         <input type = 'button' id ='modificar' value = 'Modificar'/>
         <input type = 'button' id ='eliminar' value = 'Eliminar pregunta'/>
         
         <script>
                $('#modificar').click(function() {
                      $.ajax({
                         type: 'POST',
                         url : 'preguntasProfesor.php?operacion=modificar&q='+ new Date().getTime(),
                         data: { 'id': ".$id.", 'pregunta' : $('#pregunta').val(),
                                 'correcta' : $('#correcta').val(), 'incorrecta1' : $('#incorrecta1').val(),
                                 'incorrecta2' : $('#incorrecta2').val(),'incorrecta3' : $('#incorrecta3').val(),
                                 'complejidad' : $('#complejidad').val(),'tema' : $('#tema').val()},
                         cache : false,
                         success : function(datos){
                         var array = datos.split(',');;
                          $('#modificado').text('Has modificado correctamente la pregunta');
                            if(array[0]!=''){
                             $('#".$id."').text('".$id." : ' + array[0]);
                             $('#pregunta').attr('placeholder',array[0]);
                             }
                             if(array[1]!=''){
                             $('#correcta').attr('placeholder',array[1]);
                             }
                             if(array[2]!=''){
                             $('#incorrecta1').attr('placeholder',array[2]);
                             }
                             if(array[3]!=''){
                             $('#incorrecta2').attr('placeholder',array[3]);
                             }
                             if(array[4]!=''){
                             $('#incorrecta3').attr('placeholder',array[4]);
                             }
                             if(array[5]!=''){
                             $('#complejidad').attr('placeholder',array[5]);
                             }
                             if(array[6]!=''){
                             $('#tema').attr('placeholder',array[6]);
                             }
                           }
                         });
                   });
                   
                   $('#eliminar').click(function() {
                      $.ajax({
                         type: 'POST',
                         url : 'preguntasProfesor.php?operacion=eliminar&q='+ new Date().getTime(),
                         data: { 'id': ".$id."},
                         cache : false,
                         success : function(datos){
                            if (datos == 'bien') {
                                $('#preguntas_select option:selected').remove();
                                $('#formProf').hide();
                            } else {
                                $('#modificado').text('No se ha podido eliminar la pregunta. Vuele a intentarlo.');
                            }
                         }
                      });
                   });
         </script>
         ";
      
    } else if ($_GET['operacion'] == 'modificar') {
        $pregunta = $_POST['pregunta'];
        if ($pregunta!='') {
            $sql = "update preguntas set pregunta = '$pregunta' where numPregunta = '$id'";
            mysqli_query($link,$sql);
        }
        $correcta = $_POST['correcta'];
         if ($correcta!='') {
            $sql = "update preguntas set correcta = '$correcta' where numPregunta = '$id'";
            mysqli_query($link,$sql);
        }
        $incorrecta1 = $_POST['incorrecta1'];
         if ($incorrecta1!='') {
            $sql = "update preguntas set incorrecta1 = '$incorrecta1' where numPregunta = '$id'";
            mysqli_query($link,$sql);
        }
        $incorrecta2 = $_POST['incorrecta2'];
        if ($incorrecta2!='') {
            $sql = "update preguntas set incorrecta2 = '$incorrecta2' where numPregunta = '$id'";
            mysqli_query($link,$sql);
        }
        $incorrecta3 = $_POST['incorrecta3'];
        if ($incorrecta3!='') {
            $sql = "update preguntas set incorrecta3 = '$incorrecta3' where numPregunta = '$id'";
            mysqli_query($link,$sql);
        }
        $complejidad = $_POST['complejidad'];
        if ($complejidad!='') {
            $sql = "update preguntas set complejidad = '$complejidad' where numPregunta = '$id'";
            mysqli_query($link,$sql);
        }
        $tema = $_POST['tema'];
        if ($tema!='') {
            $sql = "update preguntas set tema = '$tema' where numPregunta = '$id'";
            mysqli_query($link,$sql);
        }
        
        $devolver = "$pregunta,$correcta,$incorrecta1,$incorrecta2,$incorrecta3,$complejidad,$tema";
        echo $devolver;
    } else if ($_GET['operacion'] == 'eliminar') {
        $id = $_POST['id'];
        $sql = "delete from preguntas where numPregunta = '$id'";
        mysqli_query($link,$sql);
        if ($sql) {
            echo 'bien';
        } else {
            echo 'mal';
        }
    }
?>