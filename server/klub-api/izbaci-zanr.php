<?php
include "../servis/KlubServis.php";

try {
  $klubServis->izbaciZanr($_POST['klub'], $_POST['zanr']);
  echo json_encode([
    "success" => true,
  ]);
} catch (Exception $ex) {
  echo json_encode([
    "success" => false,
    "greska" => $ex->getMessage()
  ]);
}
