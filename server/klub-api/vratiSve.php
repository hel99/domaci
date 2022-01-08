<?php
include "../servis/KlubServis.php";

try {
  $klubovi = $klubServis->vratiSve();
  echo json_encode([
    "success" => true,
    "klubovi" => $klubovi
  ]);
} catch (Exception $ex) {
  echo json_encode([
    "success" => false,
    "greska" => $ex->getMessage()
  ]);
}
