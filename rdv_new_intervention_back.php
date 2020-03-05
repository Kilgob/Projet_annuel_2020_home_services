<?php
session_start();
include 'config.php';


$context = stream_context_create(array(
    'http' => array(
        'method' => "POST",
        'header' => "Authorization: Basic " . base64_encode("user:pass"))
));

$ampm = $_GET['clock'] <10?'0':'';

$clock = $_GET['date'] . '%20' . $ampm . $_GET['clock'] .  ':00';


$requete = "http://" . $_SESSION['ip_agence'] . "/intervention?iduser=" . $_SESSION['nmuser'] .
    "&idservice=" . $_GET['service'] .
    '&dtcrea=' . $clock;

$json = file_get_contents($requete, false, $context);
//echo $clock;

header('Location: rdv_service_total.php');
exit;
?>