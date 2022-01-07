<?php
include "../db/Broker.php";
class ZanrServis
{
  private Broker $broker;

  public function __construct($b)
  {
    $this->broker = $b;
  }

  public function vratiSve()
  {
    return $this->broker->ucitajVise("select * from zanr");
  }

  public function kreiraj($naziv)
  {
    $this->broker->upisi("insert into zanr(naziv) values ('" . $naziv . "')");
  }

  public function izmeni($id, $naziv)
  {
    $this->broker->upisi("update zanr set naziv='" . $naziv . "' where id=" . $id);
  }
  public function obrisi($id)
  {
    $this->broker->upisi("delete from zanr where id=" . $id);
  }
}
