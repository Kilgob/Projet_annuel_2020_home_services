<?php
session_start();
include 'config.php';

$context = stream_context_create(array(
    'http' => array(
        'method' => "PUT",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

//cdabonnement = les 3 premieres lettres du nouvel abonnement
//verifier si le prix est bien convertible en int

$requete = "http://" . $_SESSION['ip_agence'] . "/user_abonnement?" .
    "&iduser=" . $_SESSION['nmuser'] .
    "&idabonnement=" . $_POST['abo_selected'];
$requete = str_replace(" ", "%20", $requete);
//echo $requete;
$json = file_get_contents($requete, false, $context);
//$categ_service=json_decode($json, true);
header('Location: manage_my_account.php?error=abo_modified');
exit();

?>