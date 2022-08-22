<?php
include './controller/Controller.php';
require './servis/GradServis.php';
include 'broker.php';
$controller =new Controller();
$controller->dodajDep('gradServis',new GradServis(Broker::getInstance()));

$controller->dodajPutanju('GET','vratiSve',function($deps){
     $gradServis=$deps['gradServis'];
     return $gradServis->vratiSve();
});

$controller->dodajPutanju('POST','kreiraj',function($deps){
    $gradServis=$deps['gradServis'];
    return $gradServis->kreiraj($_POST);
});

$controller->dodajPutanju('POST','izmeni',function($deps){
    $gradServis=$deps['gradServis'];
    return $gradServis->izmeni($_GET['id'],$_POST);
});

$controller->dodajPutanju('POST','obrisi',function($deps){
    $gradServis=$deps['gradServis'];
    return $gradServis->obrisi($_GET['id']);
});

echo json_encode($controller->izvrsi());
