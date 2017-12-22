<?php
    require_once('lib/nusoap.php');
    require_once('lib/class.wsdlcache.php');

  $soapclient = new nusoap_client('http://swjo35c.000webhostapp.com/servicios/servicioContrasenas/servicioContrasena.php?wsdl',true);
  
  if (isset($_POST['textoContrasena'])){
    $respuesta = $soapclient->call('compr',array( 'x'=>$_POST['textoContrasena']));
    //echo '<h1>La contraseña introducida es ';
    echo $respuesta;
    //echo '<h2>Request</h2><pre>' . htmlspecialchars($soapclient->request, ENT_QUOTES) . '</pre>';
    //echo '<h2>Response</h2><pre>' . htmlspecialchars($soapclient->response, ENT_QUOTES) . '</pre>';
    //echo '<h2>Debug</h2>';
    //echo '<pre>' . htmlspecialchars($soapclient->debug_str, ENT_QUOTES) . '</pre>';
  }
?>