<?php

include 'config.php';
session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "POST",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));


//"54.37.153.32:6002/prestataire?nom=prestataire&prenom=le1er&mail=prest.1@gmail.com&notel=0548750047&password=toto&idcategservice=1&cdtype_user=1&idabonnement=0&adresse=15%20rue%20poulet%20braisé&ville=Versailles"

$requete = "http://" . $_SESSION['ip_agence'] . "/prestataire?nom=" . $_POST['nom'] .
    "&prenom=" . $_POST['prenom'] .
    "&mail=" . $_POST['mail'] .
    "&notel=" . $_POST['notel'] .
    "&password=" . $_POST['password'] .
    "&idcategservice=" . $_POST['categService'] .
    "&adresse=" . $_POST['adresse'] .
    "&ville=" . $_POST['ville'] .
    "&cdtype_user=pre" .
    "&idabonnement=1";
$requete = str_replace(" ", "%20", $requete);

$json=file_get_contents($requete, false, $context);
$user_infos=json_decode($json, true);


if(1){//chnager la condition
    echo "prestataire créé";
    header('Location: add_prestataire.php');
    exit;
}
else{
    echo "Erreur lors de la création du nouveau prestataire";
    exit;
}

?>