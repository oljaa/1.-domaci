<?php
include './controller/Controller.php';
require './servis/FestivalServis.php';
include 'broker.php';
$controller = new Controller();
$controller->dodajDep('festivalServis', new FestivalServis(Broker::getInstance()));

$controller->dodajPutanju('GET', 'vratiSve', function ($deps) {
    $festivalServis = $deps['festivalServis'];
    return $festivalServis->vratiSve();
});

$controller->dodajPutanju('POST', 'kreiraj', function ($deps) {
    $festivalServis = $deps['festivalServis'];
    return $festivalServis->kreiraj($_POST);
});

$controller->dodajPutanju('POST', 'izmeni', function ($deps) {
    $festivalServis = $deps['festivalServis'];
    return $festivalServis->izmeni($_GET['id'], $_POST);
});

$controller->dodajPutanju('POST', 'obrisi', function ($deps) {
    $festivalServis = $deps['festivalServis'];
    return $festivalServis->obrisi($_GET['id']);
});

echo json_encode($controller->izvrsi());
