<?php
  session_start();
  include 'config.php';

  $context = stream_context_create(array(
      'http' => array(
          'method' => "POST",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  $dtfin = str_replace(' ', '%20', date('Y-m-d H:i:s', strtotime('+' . $_GET['duration'] . ' days')));

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/user_abonnement?iduser=" . $_SESSION['nmuser'] . "&idabonnement=" . $_GET['idAbonnement'] . "&dtfin=" . $dtfin, false, $context);
  $isOk = json_decode($json, true);

  $context = stream_context_create(array(
      'http' => array(
          'method' => "GET",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/SelectClient?iduser=" . $_SESSION['nmuser'], false, $context);
  $user_infos = json_decode($json, true);

  $_SESSION['idTabAbonnement'] = $user_infos['data'][0]['idabonnement'];

  echo 'Abonnement souscrit avec succès !';

?>
