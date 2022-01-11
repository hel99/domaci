<?php
require '../db/Broker.php';
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

  public function vratiJedan($id)
  {
    $klub = $this->broker->ucitajJedan("select * from klub where id=" . $id);
    if (!isset($klub)) {
      throw new Exception("Klub ne postoji");
    }
    $klub["zanrovi"] = $this->broker->ucitajVise("select z.* from klub_zanr kz inner join zanr z on (z.id = kz.zanr_id) where kz.klub_id=" . $id);
    return $klub;
  }

  public function kreiraj($klub)
  {
    $this->broker->upisi("insert into klub (naziv, adresa, radno_vreme, rating) values ('" .
      $klub['naziv'] . "','" . $klub['adresa'] . "','" . $klub['radno_vreme'] . "'," . $klub['rating'] . ")");
  }

  public function izmeni($id, $klub)
  {
    $this->broker->upisi("update klub set naziv='" . $klub['naziv'] . "',adresa='" . $klub['adresa'] . "',radno_vreme='" . $klub['radno_vreme'] .
      "', rating=" . $klub['rating'] . " where id=" . $id);
  }

  public function obrisi($id)
  {
    $this->broker->upisi("delete from klub where id=" . $id);
  }

  public function dodajZanr($klub, $zanr)
  {
    $this->broker->upisi("insert into klub_zanr(klub_id,zanr_id) values(" . $klub . "," . $zanr . ")");
  }
  public function izbaciZanr($klub, $zanr)
  {
    $this->broker->upisi("delete from klub_zanr where klub_id=" . $klub . " and zanr_id=" . $zanr);
  }
}
$klubServis = new KlubServis(Broker::getInstance());
