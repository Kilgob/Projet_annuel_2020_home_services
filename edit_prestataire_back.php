<?php

include_once("./lang.php");
include 'config.php';
session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "PUT",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));

if($_POST['categService'] == 'cli') {

    $requete = "http://" . $_SESSION['ip_agence'] . "/prestataire?nom=" . $_POST['nom'] .
        "&iduser=" . $_SESSION['nmuser'] .
        "&prenom=" . $_POST['prenom'] .
        "&mail=" . $_POST['mail'] .
        "&notel=" . $_POST['notel'] .
        "&password=" . $_POST['password'] .
        "&idcategservice=0" .
        "&adresse=" . $_POST['adresse'] .
        "&ville=" . $_POST['ville'] .
        "&cdtype_user=" . $_POST['type_user'] .
        "&okactif=" . $_POST['okactif'] .
        "&idabonnement=0";
    $requete = str_replace(" ", "%20", $requete);
}
else{
    $requete = "http://" . $_SESSION['ip_agence'] . "/prestataire?nom=" . $_POST['nom'] .
        "&iduser=" . $_SESSION['nmuser'] .
        "&prenom=" . $_POST['prenom'] .
        "&mail=" . $_POST['mail'] .
        "&notel=" . $_POST['notel'] .
        "&password=" . $_POST['password'] .
        "&idcategservice=" . $_POST['categService'] .
        "&adresse=" . $_POST['adresse'] .
        "&ville=" . $_POST['ville'] .
        "&cdtype_user=" . $_POST['type_user'] .
        "&okactif=" . $_POST['okactif'] .
        "&idabonnement=0";
    $requete = str_replace(" ", "%20", $requete);
}
$json=file_get_contents($requete, false, $context);
$user_infos=json_decode($json, true);


if(1){//chnager la condition
    echo t("prestataire créé");
    header('Location: prestataire.php');
    exit;
}
else{
    echo t("Erreur lors de la création du nouveau prestataire");
    exit;
}

?>