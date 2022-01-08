<?php
include "../servis/KlubServis.php";

try {
  $klubServis->obrisi($_POST['id']);
  echo json_encode([
    "success" => true,
  ]);
} catch (Exception $ex) {
  echo json_encode([
    "success" => false,
    "greska" => $ex->getMessage()
  ]);
}
