<?php

class GradServis{

    private $broker;

    public function __construct($b){
        $this->broker=$b;
    }
    public function vratiSve(){
        return $this->broker->izvrsiCitanje("select id,postanski_broj as 'postanskiBroj',naziv from grad");
    }
    public function kreiraj($gradDto){
        $this->broker->izvrsiIzmenu("insert into grad(postanski_broj,naziv) values('".$gradDto['postanskiBroj']."','".$gradDto['naziv']."')");
    }
    public function izmeni($id,$gradDto){
        $this->broker->izvrsiIzmenu("update grad set naziv='".$gradDto['naziv']."', postanski_broj='".$gradDto['postanskiBroj']."' where id=".$id);
    }
    public function obrisi($id){
        $this->broker->izvrsiIzmenu("delete from grad where id=".$id);
    }
}


?>