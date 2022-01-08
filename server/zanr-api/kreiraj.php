<?php
include "../servis/ZanrServis.php";

try {
  $zanrServis->kreiraj($_POST['naziv']);
  echo json_encode([
    "success" => true,
  ]);
} catch (Exception $ex) {
  echo json_encode([
    "success" => false,
    "greska" => $ex->getMessage()
  ]);
}
