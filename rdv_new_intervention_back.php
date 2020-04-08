<?php
session_start();
include 'config.php';


$context = stream_context_create(array(
    'http' => array(
        'method' => "POST",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

$ampm = $_POST['clock'] <10?'0':'';

$clock = $_POST['date'] . '%20' . $ampm . $_POST['clock'] .  ':00';


$requete = "http://" . $_SESSION['ip_agence'] . "/intervention?iduser=" . $_SESSION['nmuser'] .
    "&idservice=" . $_POST['service'] .
    '&dtcrea=' . $clock;

$json = file_get_contents($requete, false, $context);
//echo $clock;

header('Location: rdv_service_total.php');
exit;
?>
