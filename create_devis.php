<?php
  session_start();


  $context = stream_context_create(array(
      'http' => array(
          'method' => "POST",
          'header' => "Authorization: Basic " . base64_encode("user:pass"))
  ));

  $json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/devis?idservice=" . $_POST['service'] . "&iduser=" . $_SESSION['nmuser'],false,$context);

  header('Location: rdv_service.php');
?>
