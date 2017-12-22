<?php
    ob_start();
    session_start();
?>
<?php
    include('seguridad.php');
    if ($_SESSION['rol'] != 'profesor'){
        $xml = simplexml_load_file("contador.xml");
        $noAct = $xml -> usuarios;
        $conectados = ($noAct - 1); 
        $xml -> usuarios = $conectados;
        $xml -> asXML('contador.xml');
    }
    session_destroy();
    header("Location: layout.php");
?>