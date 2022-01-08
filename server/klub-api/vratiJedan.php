<?php
include "../servis/KlubServis.php";
if (!isset($_GET['id'])) {
  echo json_encode([
    "success" => false,
    "greska" => "Id nije prosledjen"
  ]);
}
try {
  $klub = $klubServis->vratiJedan($_GET['id']);
  if (!$klub) {
    echo json_encode([
      "success" => false,
      "greska" => "Klub ne postoji"
    ]);
  }
  echo json_encode([
    "success" => true,
    "klub" => $klub
  ]);
} catch (Exception $ex) {
  echo json_encode([
    "success" => false,
    "greska" => $ex->getMessage()
  ]);
}
