<?php
include "../servis/ZanrServis.php";

try {
  $zanrovi = $zanrServis->vratiSve();
  echo json_encode([
    "success" => true,
    "zanrovi" => $zanrovi
  ]);
} catch (Exception $ex) {
  echo json_encode([
    "success" => false,
    "greska" => $ex->getMessage()
  ]);
}
