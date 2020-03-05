<?php
include 'config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "POST",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

//cdabonnement = les 3 premieres lettres du nouvel abonnement
//verifier si le prix est bien convertible en int

$requete = "http://" . $GLOBALS['IP_SIEGE'] . "/abonnement?" .
    "&lb=" . $_POST['name_abonnement'] .
    "&prix=" . $_POST['price'] .
    "&description=" . $_POST['description'] .
    "&nbrdispojour=" . $_POST['nbr_days_cumul'] .
    "&horairedebut=" . $_POST['hr_start'] .
    "&horairefun=" . $_POST['hr_end'] .
    "&cycleabo=" . $_POST['nbr_days_abos'] .
    "&idag=" . $_POST['agence_selected'];
$requete = str_replace(" ", "%20", $requete);
//echo $requete;
$json = file_get_contents($requete, false, $context);
//$categ_service=json_decode($json, true);
header('Location: create_service.php?error=create_abo_clear');
exit();

?>