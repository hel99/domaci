<?php
include "../servis/KlubServis.php";

try {
  $klubServis->izmeni($_POST['id'], $_POST);
  echo json_encode([
    "success" => true,
  ]);
} catch (Exception $ex) {
  echo json_encode([
    "success" => false,
    "greska" => $ex->getMessage()
  ]);
}
