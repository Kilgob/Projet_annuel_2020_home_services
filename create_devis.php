<?php
  session_start();


  $context = stream_context_create(array(
      'http' => array(
          'method' => "POST",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

$clock = $_POST['date'] . '%20' . $ampm . $_POST['clock'] .  ':00';

  $json = file_get_contents(str_replace(" ", "%20", "http://" . $_SESSION['ip_agence'] . "/deviscli?idservice="
      . $_POST['service'] .
      "&iduser=" . $_SESSION['nmuser'] .
      "&idservice=" . $_POST['service'] .
      "&dtcrea=" . $clock .
      "&description=" . $_POST['description'] .
      "&idcateg=" . $_POST['categService']
      )
      ,false,$context);

  header('Location: rdv_service.php');
?>
