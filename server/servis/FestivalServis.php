<?php

class FestivalServis
{

    private $broker;

    public function __construct($b)
    {
        $this->broker = $b;
    }
    public function vratiSve()
    {
        $data = $this->broker->izvrsiCitanje("select f.*, t.naziv as 'tipNaziv', g.naziv as 'gradNaziv' from festival f inner join tip_festivala t on (f.tip=t.id) inner join grad g on (f.grad=g.id)");
        $res = [];
        foreach ($data as $element) {
            $res[] = [
                "id" => $element->id,
                "naziv" => $element->naziv,
                "opis" => $element->opis,
                "pocetak" => $element->pocetak,
                "kraj" => $element->kraj,
                "adresa" => $element->adresa,
                "grad" => [
                    "id" => $element->grad,
                    "naziv" => $element->gradNaziv
                ],
                "tip" => [
                    "id" => $element->tip,
                    "naziv" => $element->tipNaziv
                ]

            ];
        }
        return $res;
    }
    public function kreiraj($festivalDto)
    {
        $this->broker->izvrsiIzmenu("insert into festival(naziv,opis,pocetak,kraj,adresa,tip,grad)" .
            " values('" . $festivalDto['naziv'] . "','" . $festivalDto['opis'] . "','" . $festivalDto['pocetak'] .
            "','" . $festivalDto['kraj'] . "','" . $festivalDto['adresa'] . "'," . $festivalDto['tip'] . "," . $festivalDto['grad'] . ")");
    }
    public function izmeni($id, $festivalDto)
    {
        $this->broker->izvrsiIzmenu("update festival set naziv='" . $festivalDto['naziv'] . "', opis='" . $festivalDto['opis'] .
            "', pocetak='" . $festivalDto['pocetak'] . "', tip=" . $festivalDto['tip'] .
            ", kraj='" . $festivalDto['kraj'] . "', adresa='" . $festivalDto['adresa'] .
            "', grad=" . $festivalDto['grad'] . " where id=" . $id);
    }
    public function obrisi($id)
    {
        $this->broker->izvrsiIzmenu("delete from festival where id=" . $id);
    }
}
