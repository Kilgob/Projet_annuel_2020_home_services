<?php

    $context = stream_context_create(array(
        'http' => array(
            'method' => "GET",
            'header' => "Authorization: Basic " . base64_encode("user:pass"))
    ));

    //if(isset( $_POST['service']) && isset($_POST['price']) && isset($_POST['agence_selected']) && isset($_POST['categService']))

    $requete = "http://172.16.69.181:6001/categ_from_agence?agence=" . $_GET['idagence'];
    $json = file_get_contents($requete, false, $context);
    $categ_service=json_decode($json, true);

    echo '<select name="categService" id="categ-service-select">';
    foreach ($categ_service['data'] as $result) {
        echo '<option value=\"' . $result['idcategservice'] . '">' . $result['lb'] . '</option>';
    }

    echo '<option value="" selected>--Choisissez une catégorie de service--</option>
        </select>';

?>


