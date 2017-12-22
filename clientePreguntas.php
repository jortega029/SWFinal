<?php
    require_once('lib/nusoap.php');
    require_once('lib/class.wsdlcache.php');

  $soapclient = new nusoap_client('http://localhost/LabSW6/servicioPreguntas/obtenerPregunta.php?wsdl',true);
  
  if (isset($_POST['idPregunta'])){
    $respuesta = $soapclient->call('obtenerPregunta',array( 'x'=>$_POST['idPregunta']));
    echo ("Pregunta: ".$respuesta['enunciado']." <br/> Respuesta correcta: ".$respuesta['correcta']." <br/> Complejidad: ".$respuesta['complejidad']);
  }
?>