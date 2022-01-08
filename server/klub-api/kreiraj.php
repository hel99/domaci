<?php
include "../servis/KlubServis.php";

try {
  $klubServis->kreiraj($_POST);
  echo json_encode([
    "success" => true,
  ]);
} catch (Exception $ex) {
  echo json_encode([
    "success" => false,
    "greska" => $ex->getMessage()
  ]);
}
