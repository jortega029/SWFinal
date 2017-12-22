<?php
    require_once('lib/nusoap.php');
    require_once('lib/class.wsdlcache.php');

  $soapclient = new nusoap_client( 'http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl',
  true);
  
  if (isset($_POST['textoEmail'])){
    $respuesta = $soapclient->call('comprobar',array( 'x'=>$_POST['textoEmail']));
    echo $respuesta;
 //echo '<h2>Request</h2><pre>' . htmlspecialchars($soapclient->request, ENT_QUOTES) . '</pre>';
 // echo '<h2>Response</h2><pre>' . htmlspecialchars($soapclient->response, ENT_QUOTES) . '</pre>';
  //echo '<h2>Debug</h2>';
  //echo '<pre>' . htmlspecialchars($soapclient->debug_str, ENT_QUOTES) . '</pre>';
  }
?>