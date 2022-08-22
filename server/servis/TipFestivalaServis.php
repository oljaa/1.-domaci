
<?php
class TipFestivalaServis
{
    private $broker;
    public function __construct($b)
    {
        $this->broker = $b;
    }

    public function vratiSve()
    {
        return  $this->broker->izvrsiCitanje('select * from tip_festivala');
    }
}


?>