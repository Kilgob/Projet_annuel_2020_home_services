<?php

include 'config.php';
session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "PUT",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));


$requete = "http://" . $_SESSION['ip_agence'] . "/prestataire?nom=" . $_POST['nom'] .
    "&iduser=" . $_SESSION['nmuser'] .
    "&prenom=" . $_POST['prenom'] .
    "&mail=" . $_POST['mail'] .
    "&notel=" . $_POST['notel'] .
    "&password=" . $_POST['password'] .
    "&idcategservice=" . $_POST['categService'] .
    "&adresse=" . $_POST['adresse'] .
    "&ville=" . $_POST['ville'] .
    "&cdtype_user=pre" .
    "&okactif=" . $_POST['okactif'] .
    "&idabonnement=0";
$requete = str_replace(" ", "%20", $requete);

$json=file_get_contents($requete, false, $context);
$user_infos=json_decode($json, true);


if(1){//chnager la condition
    echo "prestataire créé";
    header('Location: prestataire.php');
    exit;
}
else{
    echo "Erreur lors de la création du nouveau prestataire";
    exit;
}

?>