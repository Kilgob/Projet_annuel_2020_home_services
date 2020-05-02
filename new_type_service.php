<?php
    include 'config.php';

    $context = stream_context_create(array(
        'http' => array(
            'method'=>"POST",
            'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
    ));

    if ($_POST['name_service'] != '' && $_POST['agence_selected'] != '') {
      $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/categ_from_agence?lb=" . $_POST['name_service'] . "&idagence=" . $_POST['agence_selected'];
      $requete = str_replace(" ", "%20", $requete);

      $json=file_get_contents($requete, false, $context);
    }
    else {
      header('Location: create_service.php?error=no_creation_categ');
      exit;
    }

    //$categ_service=json_decode($json, true);
    header('Location: create_service.php?error=succes_categ');
    exit;

?>
