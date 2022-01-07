<?php

class Broker
{

  private $mysqli;
  public function __construct($host, $username, $pass, $db, $port = 3306)
  {
    $this->mysqli = new mysqli($host, $username, $pass, $db, $port);
    $this->mysqli->set_charset("utf8");
  }

  function ucitajVise($upit)
  {
    $rezultat = $this->mysqli->query($upit);
    if (!$rezultat) {
      throw new Exception($this->mysqli->error);
    }
    $rez = [];
    while ($red = $rezultat->fetch_object()) {
      $rez[] = $red;
    }
    return $rez;
  }

  function ucitajJedan($upit)
  {
    $rezultat = $this->mysqli->query($upit);
    if (!$rezultat) {
      throw new Exception($this->mysqli->error);
    }
    return $rezultat->fetch_object();
  }

  function upisi($upit)
  {
    $rezultat = $this->mysqli->query($upit);
    if (!$rezultat) {
      throw new Exception($this->mysqli->error);
    }
  }
}
