<?php
if (!isset($_POST['idfacture'])) {
  header('Location: paiement.php');
  exit;
}

  include 'header.php';

  $context = stream_context_create(array(
      'http' => array(
          'method' => "PUT",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/facture_np?idfacture=" . $_POST['idfacture'], false, $context);

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/upt_statut_abo?idtababonnement=" . $_SESSION['idTabAbonnement'], false, $context);

  $_SESSION['idTabAbonnement'] = null;
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Success</title>
  </head>
  <body>
    <h1>Paiement effectué avec succès !</h1>
    <h3>Vous pouvez récupérer votre facture sur votre espace personnel</h3>
  </body>
</html>
