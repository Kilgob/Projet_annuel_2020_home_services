<?php
include 'config.php';

    $context = stream_context_create(array(
        'http' => array(
            'method' => "POST",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $requete = "http://" . $GLOBALS['IP_SIEGE'] . "/agence?nom=" . $_POST['name_agence'] . "&ville=" . $_POST['city_agence'] . "ip=" . $_POST['ip'] . "&port=" . $_POST['port'];
    $requete = str_replace(" ", "%20", $requete);

    $json = file_get_contents($requete, false, $context);
    //$categ_service=json_decode($json, true);
    header('Location: create_service.php?error=account_missing');

?>