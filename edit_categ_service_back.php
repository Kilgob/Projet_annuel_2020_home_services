<?php

include 'config.php';
session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "PUT",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));


//http://54.37.153.32:6001/unique_service?lb=baysitter&price=600&idservice=1
$requete = "http://" . $GLOBALS['IP_SIEGE'] . "/unique_categ_service?lb=" . $_POST['lb'] .
    "&idcatservice=" . $_POST['idcateg'] .
    "&idagence=" . $_POST['agence_selected'] .
    "&statut=" . $_POST['okactif'];
$requete = str_replace(" ", "%20", $requete);

$json=file_get_contents($requete, false, $context);
$user_infos=json_decode($json, true);


if(1){//chnager la condition
    echo "modification du service effectué !";
    header('Location: prestataire.php');
    exit;
}
else{
    echo "Erreur lors de la modification du service !";
    header('Location: prestataire.php');
    exit;
}

?>