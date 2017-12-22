<?php

    require_once('lib/nusoap.php');
    require_once('lib/class.wsdlcache.php');
    //creamos el objeto de tipo soap_server
    $ns="http://localhost/LabSW6/servicioPreguntas";
    $server = new soap_server();
    $server->configureWSDL('obtenerPregunta',$ns);
    $server->wsdl->schemaTargetNamespace=$ns;
    $server->wsdl->addComplexType(
    'Pregunta',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'enunciado' => array('name' => 'enunciado', 'type' => 'xsd:string'),
        'correcta' => array('name' => 'correcta', 'type' => 'xsd:string'),
        'complejidad' => array('name' => 'complejidad', 'type' => 'xsd:int')
    )
);
    //registramos la función que vamos a implementar
    $server->register('obtenerPregunta',array('x'=>'xsd:int'),array('z'=>'tns:Pregunta'),$ns);
    //implementamos la función
    function obtenerPregunta($idPregunta){
      $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
        $sql = "select pregunta,correcta,complejidad from preguntas where numPregunta = '".$idPregunta."'";
        $query = mysqli_query($link,$sql);
        if (mysqli_num_rows($query) == 0){
            return array(
                'enunciado'=>'',
                'correcta'=>'',
                'complejidad'=>0
            );
        }
        else{
           $row = mysqli_fetch_array($query);
           return array(
                'enunciado'=>$row['pregunta'],
                'correcta'=>$row['correcta'],
                'complejidad'=>$row['complejidad']
            );
        }
        
    }
    //llamamos al método service de la clase nusoap
    if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( "php://input" );
    $server->service($HTTP_RAW_POST_DATA);

?>