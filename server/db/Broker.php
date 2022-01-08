<?php

class Broker
{

  private $mysqli;
  private static $broker;
  private function __construct()
  {
    $this->mysqli = new mysqli('localhost', 'root', 'root', 'klubovi');
    $this->mysqli->set_charset("utf8");
  }

  public static function getInstance()
  {
    if (!isset(Broker::$broker)) {
      Broker::$broker = new Broker();
    }
    return Broker::$broker;
  }

  function ucitajVise($upit)
  {
    $rezultat = $this->mysqli->query($upit);
    if (!$rezultat) {
      throw new Exception($this->mysqli->error);
    }
    $rez = [];
    while ($red = $rezultat->fetch_assoc()) {
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
    return $rezultat->fetch_assoc();
  }

  function upisi($upit)
  {
    $rezultat = $this->mysqli->query($upit);
    if (!$rezultat) {
      throw new Exception($this->mysqli->error);
    }
  }
}
