<?php
require "../db/Broker.php";
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

  public function vratiJedan($id)
  {
    $klub = $this->broker->ucitajJedan("select * from klub where id=" . $id);
    if (!isset($klub)) {
      throw new Exception("Klub ne postoji");
    }
    $klub["zanrovi"] = $this->broker->ucitajVise("select z.* from klub_zanr kz inner join zanr z on (z.id = kz.zanr_id) where kz.klub_id=" . $id);
    return $klub;
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
$klubServis = new KlubServis(Broker::getInstance());
