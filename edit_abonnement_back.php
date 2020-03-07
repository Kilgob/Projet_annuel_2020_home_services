<?php

include 'config.php';
session_start();

$context = stream_context_create(array(
    'http' => array(
        'method' => "PUT",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));


//http://54.37.153.32:6001/unique_service?lb=baysitter&price=600&idservice=1
$requete = "http://" . $GLOBALS['IP_SIEGE'] . "/abonnement?" .
    "&lb=" . $_POST['lb'] .
    "&prix=" . $_POST['price'] .
    "&description=" . $_POST['description'] .
    "&nbrdispojour=" . $_POST['nbrdispo_days'] .
    "&horairedebut=" . $_POST['hr_start'] .
    "&horairefin=" . $_POST['hr_end'] .
    "&cycleabo=" . $_POST['nbr_days_abos'] .
    "&idabonnement=" . $_POST['idabonnement'] .
    "&idag=" . $_POST['agence_selected'];
$requete = str_replace(" ", "%20", $requete);

$json=file_get_contents($requete, false, $context);
$user_infos=json_decode($json, true);


if(1){//chnager la condition
    echo "modification de l'abonnemnt effectué !";
    header('Location: prestataire.php');
    exit;
}
else{
    echo "Erreur lors de la modification de l'abonnemennt !";
    header('Location: prestataire.php');
    exit;
}

?>