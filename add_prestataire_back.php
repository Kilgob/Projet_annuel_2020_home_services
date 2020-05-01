<?php

include_once("./lang.php");
include 'config.php';
session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));


//"54.37.153.32:6002/prestataire?nom=prestataire&prenom=le1er&mail=prest.1@gmail.com&notel=0548750047&password=toto&idcategservice=1&cdtype_user=1&idabonnement=0&adresse=15%20rue%20poulet%20braisé&ville=Versailles"
$json = file_get_contents("http://" . $GLOBALS['IP_SIEGE'] . "/agence_get_ip?idagence=" . $_POST['agence_selected'], false, $context);
$agence_infos = json_decode($json, true);
$ip_agence = $agence_infos['data'][0]['ip'] . ":" . $agence_infos['data'][0]['port'];

$context = stream_context_create(array(
    'http' => array(
        'method' => "POST",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));


$requete = "http://" . $ip_agence . "/prestataire?nom=" . $_POST['nom'] .
    "&prenom=" . $_POST['prenom'] .
    "&mail=" . $_POST['mail'] .
    "&notel=" . $_POST['notel'] .
    "&password=" . hash("sha256", $_POST['password']) .
    "&idcategservice=" . $_POST['categService'] .
    "&adresse=" . $_POST['adresse'] .
    "&ville=" . $_POST['ville'] .
    "&cdtype_user=pre" .
    "&idabonnement=1";
$requete = str_replace(" ", "%20", $requete);

$json=file_get_contents($requete, false, $context);


$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));

//Récupération des informations de connexion

$json = file_get_contents("http://" . $ip_agence . "/client?email=" . $_POST['mail'] . "&password=" . hash("sha256", $_POST['password']), false, $context);
$connection_infos = json_decode($json, true);

shell_exec("/home/fred/qrcode/qrcode " . $connection_infos['data'][0]['iduser'] . " https://32.ip-54-37-153.eu/infos_prestataire.php?id=" . $connection_infos['data'][0]['iduser'] . "\&agence=" . $ip_agence);


if(1){//chnager la condition
    echo t("prestataire créé");
    header('Location: add_prestataire.php');
    exit;
}
else{
    echo t("Erreur lors de la création du nouveau prestataire");
    exit;
}
?>
