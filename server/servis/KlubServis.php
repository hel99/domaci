<?php
include '../db/Broker.php';
class KlubServis
{
  private Broker $broker;

  public function __construct($b)
  {
    $this->broker = $b;
  }

  public function vratiSve()
  {
    return $this->broker->ucitajVise("select * from klub");
  }

  public function kreiraj($klub)
  {
    $this->broker->upisi("insert into klub (naziv, adresa, radno_vreme, rating) values ('" .
      $klub['naziv'] . "','" . $klub['adresa'] . "','" . $klub['radno_vreme'] . "'," . $klub['rating'] . ")");
  }

  public function izmeni($id, $klub)
  {
    $this->broker->upisi("update klub set naziv='" . $klub['naziv'] .
      "',adresa='" . $klub['adresa'] . "',radno_vreme='" . $klub['radno_vreme'] .
      "', rating=" . $klub['naziv'] . " where id=" . $id);
  }

  public function obrisi($id)
  {
    $this->broker->upisi("delete from klub where id=" . $id);
  }
}
