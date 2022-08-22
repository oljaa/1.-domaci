<?php
include './controller/Controller.php';
require './servis/TipFestivalaServis.php';
include 'broker.php';
$controller =new Controller();
$controller->dodajDep('tipServis',new TipFestivalaServis(Broker::getInstance()));
$controller->dodajPutanju('GET','vratiSve',function($deps){
     $tipServis=$deps['tipServis'];
     return $tipServis->vratiSve();
});

echo json_encode($controller->izvrsi());
