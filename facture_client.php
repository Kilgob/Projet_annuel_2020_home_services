<?php

include 'header.php';
include 'config.php';
date_default_timezone_set('Europe/Paris');

$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header'  => "Authorization: Basic " . base64_encode("user:pass")   )
));

$json = file_get_contents("http://" . $_SESSION['ip_agence'] . "/facture_client?iduser=" . $_SESSION['nmuser'], false, $context);
$factures = json_decode($json, true);


foreach ($factures['data'] as $facture) {
  if (strtotime('+1 month', strtotime($facture['dtcrea'])) < time()) {
    echo 'Facture du ' . strftime("%d/%m/%Y", strtotime($facture['dtcrea'])) . ' au ' . strftime("%d/%m/%Y", strtotime('+1 month',strtotime($facture['dtcrea']))) . '<br>';
    echo 'Montant : ' . $facture['montant'] . '€<br>';
    echo '<form method="POST" target="_blank" action="facture/index.php">';
    echo '<input type="hidden" name="iduser" value="' . $_SESSION['nmuser'] . '">';
    echo '<input type="hidden" name="idfacture" value="' . $facture['idfacture'] . '">';
    echo '<input type="hidden" name="dtdebut" value="' . strftime("%Y-%m-%d", strtotime($facture['dtcrea']))   . '">';
    echo '<input type="hidden" name="dtfin" value="' . strftime("%Y-%m-%d", strtotime('+1 month', strtotime($facture['dtcrea']))) . '">';
    echo '<input class="btn btn-secondary" type="submit" value="Afficher facture">';
    echo '</form>';
  }
}


?>
