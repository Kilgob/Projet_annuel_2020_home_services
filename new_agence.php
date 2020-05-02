<?php
include 'config.php';

    $context = stream_context_create(array(
        'http' => array(
            'method' => "POST",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    if ($_POST['name_agence'] != '' && $_POST['city_agence'] != '' && $_POST['ip'] != '' && $_POST['port'] != '') {
      $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/agence?nom=" . $_POST['name_agence'] . "&ville=" . $_POST['city_agence'] . "&ip=" . $_POST['ip'] . "&port=" . $_POST['port'];
      $requete = str_replace(" ", "%20", $requete);

      $json = file_get_contents($requete, false, $context);
    }
    else {
      header('Location: create_service.php?error=no_creation_agence');
      exit;
    }

    //$categ_service=json_decode($json, true);
    header('Location: create_service.php?error=succes_agence');
    exit;

?>
