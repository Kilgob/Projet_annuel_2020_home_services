<?php
include 'config.php';

    $context = stream_context_create(array(
        'http' => array(
            'method' => "POST",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    if($_POST['service'] != '' && $_POST['price'] != '' && $_POST['agence_selected'] != '' && $_POST['categService'] != '') {
      $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/service?lb=" . $_POST['service'] . "&price=" . $_POST['price'] . "&idagence=" . $_POST['agence_selected'] . "&idcategservice=" . $_POST['categService'];
      $requete = str_replace(" ", "%20", $requete);

      $json = file_get_contents($requete, false, $context);
    }
    else {
      header('Location: create_service.php?error=no_creation_service');
      exit;
    }

    header('Location: create_service.php?error=succes_service');
    exit;

?>
