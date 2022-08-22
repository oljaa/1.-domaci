<?php
class Controller
{

    private $putanje;
    private $deps;
    public function __construct()
    {
        $this->deps = [];
        $this->putanje = [
            "GET" => [],
            "POST" => []
        ];
    }

    public function dodajPutanju($metoda, $naziv, $handler)
    {
        $this->putanje[$metoda][$naziv] = $handler;
    }
    public function dodajDep($naziv, $vrednost)
    {
        $this->deps[$naziv] = $vrednost;
    }
    public function izvrsi()
    {
        $akcija = $_GET["akcija"];
        if (!isset($akcija)) {
            return $this->vratiGreska("Metoda nije podrzana");
        }
        $metoda = $_SERVER['REQUEST_METHOD'];
        $handler = $this->putanje[$metoda][$akcija];
        if (!isset($handler)) {
            return $this->vratiGreska("Metoda nije podrzana");
        }
        try {
            return $this->vratiUspesno($handler($this->deps));
        } catch (Exception  $ex) {
            return $this->vratiGreska($ex->getMessage());
        }
    }
    private function vratiUspesno($podaci)
    {
        if (!isset($podaci)) {
            return [
                "status" => true,
            ];
        }
        return [
            "status" => true,
            "data" => $podaci
        ];
    }
    private function vratiGreska($greska)
    {
        return [
            "status" => false,
            "error" => $greska
        ];
    }
}
