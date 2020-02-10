<?php

    $context = stream_context_create(array(
        'http' => array(
            'method' => "POST",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    $requete = "http://172.16.69.181:6001/agence?nom=" . $_POST['name_agence'] . "&ville=" . $_POST['city_agence'];
    $requete = str_replace(" ", "%20", $requete);

    $json = file_get_contents($requete, false, $context);
    //$categ_service=json_decode($json, true);
    header('Location: create_service.php?error=account_missing');

?>