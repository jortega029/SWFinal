<?php
echo($_GET['q']);
if(isset($_GET['q'])){
    $xml = simplexml_load_file("contador.xml");
    $noAct = $xml -> usuarios;
    if($_GET['q']=='restar'){
         $conectados = $noAct - 1; 
    }
    else if ($_GET['q']=='sumar'){
        $conectados = $noAct + 1;   
    }
    $xml -> usuarios = $conectados;
    $xml -> asXML('contador.xml');
}

?>