<?php
include 'config.php';

    $context = stream_context_create(array(
        'http' => array(
            'method' => "POST",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    //if(isset( $_POST['service']) && isset($_POST['price']) && isset($_POST['agence_selected']) && isset($_POST['categService']))

    $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/service?lb=" . $_POST['service'] . "&price=" . $_POST['price'] . "&idagence=" . $_POST['agence_selected'] . "&idcategservice=" . $_POST['categService'];
    $requete = str_replace(" ", "%20", $requete);

    $json = file_get_contents($requete, false, $context);
    //$categ_service=json_decode($json, true);
    header('Location: create_service.php?error=account_missing');


?>
